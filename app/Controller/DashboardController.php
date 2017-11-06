<?php
App::uses('AppController', 'Controller');
class DashboardController extends AppController{
  public $components = array('Paginator', 'Flash','Session');
  public $layout='dashboard';

public function beforeFilter(){
  $this->response->disableCache();
  if($this->Session->read('login_id') == ''){
    $this->redirect(array(
      'controller'=>'users',
      'action'=>'login'
    ));
  }
}

  public function index(){

  }
  ////////////////////////////////////////////
  public function designations(){
    $this->loadModel('Designation');
    $this->Designation->query("truncate table designations");
    $this->Designation->setDataSource('live');
    $datas=$this->Designation->query("select * from ohrm_job_title order by id");
    $this->Designation->setDataSource('default');
    foreach($datas as $data){
      if($data['ohrm_job_title']['is_deleted'] != 1){
        $this->Designation->create();
        $this->request->data['Designation']['name']=$data['ohrm_job_title']['job_title'];
        $this->request->data['Designation']['hrm_id']=$data['ohrm_job_title']['id'];
        $this->Designation->save($this->request->data);
      }
    }
  }
//////////////////////////////////////////////
public function categories(){
  $this->loadModel('Category');
  $this->Category->query("truncate table categories");
  $this->Category->setDataSource('live');
  $datas=$this->Category->query("select * from ohrm_job_category order by id");
  $this->Category->setDataSource('default');
  foreach($datas as $data){
      $this->Category->create();
      $this->request->data['Category']['name']=$data['ohrm_job_category']['name'];
      $this->request->data['Category']['hrm_id']=$data['ohrm_job_category']['id'];
      $this->Category->save($this->request->data);
  }
}
//////////////////////////////////////////////
public function employees(){
  $this->loadModel('Employee');
  $this->Employee->query("truncate table employees");
  $this->Employee->setDataSource('live');
  $datas=$this->Employee->query("select * from hs_hr_employee order by emp_number");
  $this->Employee->setDataSource('default');
  foreach($datas as $data){
      $this->Employee->create();
      $this->request->data['Employee']['name']=$data['hs_hr_employee']['emp_firstname'];
      if($data['hs_hr_employee']['emp_middle_name'] != ''){
        $this->request->data['Employee']['name']=$this->request->data['Employee']['name'].' '.$data['hs_hr_employee']['emp_middle_name'];
      }
      if($data['hs_hr_employee']['emp_lastname'] != ''){
        $this->request->data['Employee']['name']=$this->request->data['Employee']['name'].' '.$data['hs_hr_employee']['emp_lastname'];
      }
      $this->request->data['Employee']['emp_number']=$data['hs_hr_employee']['emp_number'];
      $this->request->data['Employee']['employee_id']=$data['hs_hr_employee']['employee_id'];
      $this->request->data['Employee']['emp_gender']=$data['hs_hr_employee']['emp_gender'];
      $this->request->data['Employee']['emp_status']=$data['hs_hr_employee']['emp_status'];
      $this->request->data['Employee']['designation_id']=$data['hs_hr_employee']['job_title_code'];
      $this->request->data['Employee']['category_id']=$data['hs_hr_employee']['eeo_cat_code'];
      $this->request->data['Employee']['emp_mobile']=$data['hs_hr_employee']['emp_mobile'];
      $this->request->data['Employee']['emp_work_email']=$data['hs_hr_employee']['emp_work_email'];
      if($data['hs_hr_employee']['termination_id'] != '' && $data['hs_hr_employee']['termination_id'] > 0){
        $this->request->data['Employee']['is_terminated']=1;
      }else{
        $this->request->data['Employee']['is_terminated']=0;
      }
      $this->Employee->save($this->request->data);
  }
}
////////////gethra////////////////////////////////////
public function gethra(){
  $this->layout='ajax';
  //debug($this->params);exit;
  $basic_percentage=$this->params['pass'][0];
  $basic=$this->params['pass'][1];
  $hra=($basic_percentage/100)*$basic;
  echo $hra;exit;
}
/////////////getcommit_all///////////////////////////
public function getcommit_all(){
  $this->layout='ajax';
  $gross_percentage=$this->params['pass'][0];
  $gross=$this->params['pass'][1];
  $comm_all=($gross_percentage/100)*$gross;
  echo $comm_all;exit;
}
//////////////////salary breakup////////////////////////
public function salariesbreakup(){
  $this->loadModel('Salary');
  $this->loadModel('Category');
  $this->loadModel('Designation');
  $this->loadModel('Employee');

  if($this->request->is(array('put','post'))){
      //debug($this->data);exit;
      if ($this->Salary->save($this->request->data)) {
        $this->Flash->success(__('Master salary Saved.'));
        //return $this->redirect(array('action' => 'index'));
      } else {
        $this->Flash->error(__('Master salary not saved. Please, try again.'));
      }
      
  }

  $from_year=date('Y')-3;
  $to_year=date('Y')+1;
  $years=null;
  for($i=$from_year;$i<=$to_year;$i++){
    $years[$i]=$i;
  }
  $months=array(
    '1'=>'January',
    '2'=>'February',
    '3'=>'March',
    '4'=>'April',
    '5'=>'May',
    '6'=>'Jun',
    '7'=>'July',
    '8'=>'August',
    '9'=>'September',
    '10'=>'October',
    '11'=>'November',
    '12'=>'December'
  );
  $this->Category->primaryKey='hrm_id';
  $categories=$this->Category->find('list',array(
    'order'=>array(
      'Category.name'
    )
  ));
  $this->Designation->primaryKey='hrm_id';
  $designations=$this->Designation->find('list',array(
    'order'=>array(
      'Designation.name'
    )
  ));
  $employees=$this->Employee->find('list',array(
    'conditions'=>array(
      'Employee.is_terminated'=>0,
    ),
    'order'=>array(
      'Employee.name'
    )
  ));
  $this->set(compact('years','months','categories','designations','employees'));
}

///////////////////Process Salary///////////////////////
public function salarieprocess(){
  $this->loadModel('Salary');
  $this->loadModel('SalaryDetail');
  $this->loadModel('Designation');
  $this->Designation->primaryKey='hrm_id';
  $designations=$this->Designation->find('list',array(
    'order'=>array(
      'Designation.name'
    )
  ));
  if($this->request->is(array('put','post'))){
   
      
    $year='';
    $month='';
    $id='';
    $chk=0;
    //debug($this->data);exit;
      if(isset($this->data['checkbox']) && is_array($this->data['checkbox']) && !empty($this->data['checkbox'])){
        foreach($this->data['checkbox'] as $val1){
          if($this->Session->read('login_id') == 'accountadmin'){
            if(isset($val1['emp_id']) && $val1['emp_id'] > 0 && isset($val1['id']) && $val1['id'] > 0){
                $chk++;
            }
          }else{
            if(isset($val1['emp_id']) && $val1['emp_id'] > 0){
                $chk++;
            }
          }
          
        }
      }
      //echo $chk;exit;
      if($chk > 0){
       // debug($this->data);exit;
       //if(isset($this->data['SalaryDetail']['checkbox']) && $this->data['SalaryDetail']['checkbox'] >0){
      if(isset($this->data['checkbox']) && is_array($this->data['checkbox']) && !empty($this->data['checkbox'])){
        if(isset($this->data['year']) && $this->data['year']!=''){
              $year=$this->data['year'];
            }
            if(isset($this->data['month']) && $this->data['month']!=''){
              $month=$this->data['month'];
            }
            //debug($this->data);exit;
            $success=0;
            $fail=0;
            $count=0;
            foreach($this->data['checkbox'] as $val){
              $count++;
              if(isset($val['emp_id']) && $val['emp_id'] > 0){
                  $salary=$this->Salary->find('first',array(
                'conditions'=>array(
                  'Salary.emp_id'=>$val['emp_id'],
                ),
              ));
                 $salary['Salary']['year']=$year;
                 $salary['Salary']['month']=$month;
                 $salary['Salary']['processed_by_hr']='Y';
                 if(isset($val['id']) && $val['id']!=''){
                    $id= $val['id'];
                  }
                 if(isset($id) && $id!=''){
                    $salary['Salary']['processed_by_accounts']='Y';
                    $salary['Salary']['id']=$id;
                 }else{
                   unset($salary['Salary']['id']);
                 }
                 //debug($salary);
                 if ($this->SalaryDetail->saveAll($salary['Salary'])) {
                    $this->Flash->success(__('salary released.'));
                    $success++;
                  } else {
                    $this->Flash->error(__('salary not released. Please, try again.'));
                    $fail++;
                  }
              }else{
                $fail++;
              }
              
            }
            //exit;
            //echo $success;exit;
            if($count == $success){
              $this->Flash->success(__($success.'success salary Saved.'));
              return $this->redirect(array('action' => 'salarieprocess'));
            }else{
              $this->Flash->success(__($success.'success salary Saved.'.$fail.' failed salary'));
              return $this->redirect(array('action' => 'salarieprocess'));
            }
            
        }
      // }
       }
      if(isset($this->data['SalaryRelease']['id']) && $this->data['SalaryRelease']['id']!=''){
        $id= $this->data['SalaryRelease']['id'];
      }
      if(isset($this->data['SalaryRelease']['year']) && $this->data['SalaryRelease']['year']!=''){
        $year=$this->data['SalaryRelease']['year'];
      }
      if(isset($this->data['SalaryRelease']['month']) && $this->data['SalaryRelease']['month']!=''){
        $month=$this->data['SalaryRelease']['month'];
      }
      if(isset($this->data['SalaryRelease']['emp_id']) && $this->data['SalaryRelease']['emp_id']!=''){
        $emp_id=$this->data['SalaryRelease']['emp_id'];
      }
      if(isset($this->data['SalaryProcess']['year']) && $this->data['SalaryProcess']['year']!=''){
        $year=$this->data['SalaryProcess']['year'];
      }
      if(isset($this->data['SalaryProcess']['month']) && $this->data['SalaryProcess']['month']!=''){
        $month=$this->data['SalaryProcess']['month'];
      }
      if(isset($this->data['SalaryProcess']['emp_id']) && $this->data['SalaryProcess']['emp_id']!=''){
        $emp_id=$this->data['SalaryProcess']['emp_id'];
      }

      
      
      //debug($this->request->data);
      $salary=$this->Salary->find('first',array(
          'conditions'=>array(
            'Salary.emp_id'=>$emp_id,
          ),
        ));
       $salary['Salary']['year']=$year;
       $salary['Salary']['month']=$month;
       $salary['Salary']['processed_by_hr']='Y';
       if(isset($id) && $id!=''){
          $salary['Salary']['processed_by_accounts']='Y';
          $salary['Salary']['id']=$id;
       }else{
         unset($salary['Salary']['id']);
       }
       //debug($salary['Salary']);exit;
       
      if ($this->SalaryDetail->saveAll($salary['Salary'])) {
        $this->Flash->success(__('salary Saved.'));
        //return $this->redirect(array('action' => 'index'));
      } else {
        $this->Flash->error(__('salary not saved. Please, try again.'));
      }
      
  }
  $from_year=date('Y')-3;
  $to_year=date('Y')+1;
  $years=null;
  for($i=$from_year;$i<=$to_year;$i++){
    $years[$i]=$i;
  }
  $months=array(
    '1'=>'January',
    '2'=>'February',
    '3'=>'March',
    '4'=>'April',
    '5'=>'May',
    '6'=>'Jun',
    '7'=>'July',
    '8'=>'August',
    '9'=>'September',
    '10'=>'October',
    '11'=>'November',
    '12'=>'December'
  );

  $this->set(compact('years','months','designations'));
}
////////////salary release//////////////////
public function salarierelease(){
  $this->loadModel('SalaryDetail');
}
/////////////ajax salary process/////////////
public function indexAjax(){
    $this->layout = 'ajax';
    $this->loadModel('Salary');
    $this->loadModel('SalaryDetail');
    $this->loadModel('Employee');
    //debug($this->data);exit;
    $condition = array(); 
    $month='';
    $year='';
    $desg='';
    $condition1 = array();
        if(isset($this->data['year']) && $this->data['year'] != 0){
          $year=$this->data['year'];
            //$condition += array('SalaryDetail.year' => $year );
        }
        if(isset($this->data['month']) && $this->data['month'] != 0){
          $month=$this->data['month'];
            //$condition += array('SalaryDetail.month' => $month );
        }
        if(isset($this->data['desg']) && $this->data['desg'] != 0){
          $desg=$this->data['desg'];
          $condition1 += array('Employee.designation_id' => $desg);
            //$condition += array('SalaryDetail.month' => $month );
        }
        //$condition += array('SalaryDetail.emp_id = Salary.emp_id' );
    if($this->Session->read('login_id') == 'accountadmin'){
      $condition +=array('SalaryDetail.processed_by_hr' => 'Y' );
    }
    $this->paginate = array(
      'recursive'=>-1,
      'joins' => array(
        array(
            'alias' => 'SalaryDetail',
            'table' => 'salary_details',
            'type' => 'left',
            'conditions' => array('SalaryDetail.emp_id = Salary.emp_id','SalaryDetail.year' => $year,'SalaryDetail.month' => $month),
        ),
        array(
            'alias' => 'Employee',
            'table' => 'employees',
            'type' => 'inner',
            'conditions' => array('Employee.id = Salary.emp_id')+$condition1,
        )     
    ),

      /*'conditions' => array(
        'OR' => array(
            array(
                'SalaryDetail.year' => $year,
                'SalaryDetail.month' => $month
            ),
            array(
                'SalaryDetail.year is null',
                'SalaryDetail.month is null'
            )
        )
    ),*/

      'conditions'  => $condition,
      'fields' => array('Salary.*','SalaryDetail.id','SalaryDetail.month','SalaryDetail.year','SalaryDetail.processed_by_hr','SalaryDetail.processed_by_accounts'),
      'limit'     => 20,
    );
    //debug($this->paginate);
    $this->set(array(
      'data'      => $this->paginate('Salary'),
      'year'   => $year,
      'month'   => $month,
    ));
  }
///////////////////salaryslip////////////////
  public function salaryslip($id=''){
    $this->layout='';
    $this->loadModel('Salary');
    $this->loadModel('SalaryDetail');
    $this->loadModel('Employee');
    $this->loadModel('Designation');
    $this->Designation->primaryKey='hrm_id';
    $data=$this->SalaryDetail->find('first',array(
    'recursive'=>-1,
    'joins' => array(
        array(
            'alias' => 'Employee',
            'table' => 'employees',
            'type' => 'inner',
            'conditions' => array('Employee.id = SalaryDetail.emp_id'),
        ),
        array(
            'alias' => 'Designation',
            'table' => 'designations',
            'type' => 'inner',
            'conditions' => array('Designation.hrm_id=Employee.designation_id'),
        )        
    ),
    'conditions'=>array(
      'SalaryDetail.id'=>$id,
    ),
    'fields' => array('SalaryDetail.*','Employee.employee_id','Designation.name')
    
  ));
    $this->set(compact('data'));
  }
//////////////////////////////////////////////
public function loadempsdata($id){
  $this->autorender = false;
  $this->layout='ajax';
  $this->loadModel('Employee');
  $this->loadModel('Salary');

  if($this->request->is(array('put','post'))){
      //debug($this->data);exit;
      if ($this->Salary->save($this->request->data)) {
        $this->Flash->success(__('Master salary Saved.'));
        return $this->redirect(array('action' => 'salariesbreakup'));
      } else {
        $this->Flash->error(__('Master salary not saved. Please, try again.'));
      }
      
  }

  $empcount=$this->Salary->find('count',array(
    'conditions'=>array(
      'Salary.emp_id'=>$id,
    )
    
  ));
  if($empcount>0){
    $data=$this->Salary->find('first',array(
    'conditions'=>array(
      'Salary.emp_id'=>$id,
    )
    
  ));

  }else{
    $data=$this->Employee->find('first',array(
    'conditions'=>array(
      'Employee.id'=>$id,
      'Employee.is_terminated'=>0,
    )
    
  ));

  }
    //echo $employees[0]['Employee']['name'].'****'.$employees[0]['Employee']['id'];exit;
  $this->set(compact('data'));
}
//////////////////////////////////////////////
public function salariesadd(){
  $this->loadModel('Salary');
  $this->loadModel('Category');
  $this->loadModel('Designation');
  $this->loadModel('Employee');
  $from_year=date('Y')-3;
  $to_year=date('Y')+1;
  $years=null;
  for($i=$from_year;$i<=$to_year;$i++){
    $years[$i]=$i;
  }
  $months=array(
    '1'=>'January',
    '2'=>'February',
    '3'=>'March',
    '4'=>'April',
    '5'=>'May',
    '6'=>'Jun',
    '7'=>'July',
    '8'=>'August',
    '9'=>'September',
    '10'=>'October',
    '11'=>'November',
    '12'=>'December'
  );
  $this->Category->primaryKey='hrm_id';
  $categories=$this->Category->find('list',array(
    'order'=>array(
      'Category.name'
    )
  ));
  $this->Designation->primaryKey='hrm_id';
  $designations=$this->Designation->find('list',array(
    'order'=>array(
      'Designation.name'
    )
  ));
  $employees=$this->Employee->find('list',array(
    'order'=>array(
      'Employee.name'
    )
  ));
  $this->set(compact('years','months','categories','designations','employees'));
}
//////////////////////////////////////////////
public function loadempsbycat($id){
  $this->layout=NULL;
  $this->loadModel('Employee');
  $employees=$this->Employee->find('list',array(
    'conditions'=>array(
      'Employee.category_id'=>$id,
      'Employee.is_terminated'=>0,
    ),
    'order'=>array(
      'Employee.name'
    )
  ));
  $this->set(compact('employees'));
}
//////////////////////////////////////////////
public function loadempsbydes($id){
  $this->layout=NULL;
  $this->loadModel('Employee');
  $employees=$this->Employee->find('list',array(
    'conditions'=>array(
      'Employee.designation_id'=>$id,
      'Employee.is_terminated'=>0,
    ),
    'order'=>array(
      'Employee.name'
    )
  ));
  $this->set(compact('employees'));
}
//////////////////////////////////////////////
public function logout(){
  $this->Session->write('login_id','');
  $this->redirect(array(
    'controller'=>'users',
    'action'=>'login'
  ));
}
//////////////////////////////////////////
}
