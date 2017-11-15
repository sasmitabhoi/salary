<?php
App::uses('AppController', 'Controller');
class DashboardController extends AppController{
  public $components = array('Paginator', 'Flash','Session');
  public $layout='dashboard';

public function beforeFilter(){
  $this->response->disableCache();
  parent::beforeFilter();
  // if($this->Session->read('login_id') == ''){
  //   $this->redirect(array(
  //     'controller'=>'users',
  //     'action'=>'login'
  //   ));
  // }
}

  public function index(){

  }
  ////////////////////////////////////////////
  public function designations(){
    $this->loadModel('Designation');
    $this->Designation->query("truncate table designations");
    $this->Designation->setDataSource('live');
    $count=0;
    $datas=$this->Designation->query("select * from ohrm_job_title order by id");
    $this->Designation->setDataSource('default');
    foreach($datas as $data){
      if($data['ohrm_job_title']['is_deleted'] != 1){
        $this->Designation->create();
        $this->request->data['Designation']['name']=$data['ohrm_job_title']['job_title'];
        $this->request->data['Designation']['hrm_id']=$data['ohrm_job_title']['id'];
        $this->Designation->save($this->request->data);
        $count++;
      }
    }
    if($count >0){
        $this->Session->write('message_type','success');
        $this->Session->write('message',$count.'Designations Updated Successfully .......');
      }
  }
//////////////////////////////////////////////
public function categories(){
  $this->loadModel('Category');
  $this->Category->query("truncate table categories");
  $this->Category->setDataSource('live');
  $count=0;
  $datas=$this->Category->query("select * from ohrm_job_category order by id");
  $this->Category->setDataSource('default');
  foreach($datas as $data){
      $this->Category->create();
      $this->request->data['Category']['name']=$data['ohrm_job_category']['name'];
      $this->request->data['Category']['hrm_id']=$data['ohrm_job_category']['id'];
      $this->Category->save($this->request->data);
      $count++;
  }
      if($count >0){
        $this->Session->write('message_type','success');
        $this->Session->write('message',$count.'Categories Updated Successfully .......');
      }
}
//////////////////////////////////////////////
public function employees(){
  $this->loadModel('Employee');
  $this->Employee->query("truncate table employees");
  $this->Employee->setDataSource('live');
  $count=0;
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
      $this->request->data['Employee']['dept_id']=$data['hs_hr_employee']['work_station'];
      if($data['hs_hr_employee']['termination_id'] != '' && $data['hs_hr_employee']['termination_id'] > 0){
        $this->request->data['Employee']['is_terminated']=1;
      }else{
        $this->request->data['Employee']['is_terminated']=0;
      }
      $this->Employee->save($this->request->data);
        $count++;
      
  }
  if($count >0){
        $this->Session->write('message_type','success');
        $this->Session->write('message',$count.'Employees Updated Successfully .......');
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
      if(isset($this->data['Salary']['emp_id']) && $this->data['Salary']['emp_id']!=''){
          if ($this->Salary->save($this->request->data)) {
            $this->Session->write('message_type','success');
            $this->Session->write('message','Master salary Saved.');
          } else {
            $this->Session->write('message_type','error');
            $this->Session->write('message','Master salary not saved. Please, try again.');
          }
      }else{
        $this->Session->write('message_type','error');
        $this->Session->write('message','Please enter a valid employee !');
        //$this->Flash->error(__('Please enter a valid employee.'));
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
  $this->Designation->setDataSource('live');
  $department=$this->Designation->query("select id,name from ohrm_subunit order by name");
  $this->Designation->setDataSource('default');
  // debug($department);
  $department_list=array();
  foreach ($department as $key => $value) {
   $department_list[$value['ohrm_subunit']['id']]=$value['ohrm_subunit']['name'];
  }

// debug($department_list);
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
        if(isset($this->data['SalaryDetail']['year']) && $this->data['SalaryDetail']['year']!=''){
              $year=$this->data['SalaryDetail']['year'];
            }
            if(isset($this->data['SalaryDetail']['month']) && $this->data['SalaryDetail']['month']!=''){
              $month=$this->data['SalaryDetail']['month'];
            }
            $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            //debug($this->data);exit;
            $success=0;
            $fail=0;
            $count=0;
            foreach($this->data['checkbox'] as $key=>$val){
              $count++;
              $salaryDetail = 0;
              if(isset($val['id']) && $val['id']!=''){
                $id= $val['id'];
              }
              if(isset($val['emp_id']) && $val['emp_id'] > 0 && $id==''){
                $salaryDetail=$this->SalaryDetail->find('count',array(
                'conditions'=>array(
                  'SalaryDetail.emp_id'=>$val['emp_id'],
                  'SalaryDetail.year'=>$year,
                  'SalaryDetail.month'=>$month,
                ),
              ));
              } 
              //echo $salaryDetail;exit;
              if($salaryDetail>0){
                $fail++;
              }else{
                  if(isset($val['emp_id']) && $val['emp_id'] > 0){
                  $salary=$this->Salary->find('first',array(
                    'conditions'=>array(
                      'Salary.emp_id'=>$val['emp_id'],
                    ),
                  ));
                 $salary['Salary']['no_of_days']=$number;
                 $salary['Salary']['year']=$year;
                 $salary['Salary']['month']=$month;
                 $salary['Salary']['processed_by_hr']='Y';
                 
                 if(isset($id) && $id!=''){
                    $salary['Salary']['processed_by_accounts']='Y';
                    $salary['Salary']['id']=$id;
                    unset($salary['Salary']['days_paid']);
                    unset($salary['Salary']['leaves_availed']);
                    unset($salary['Salary']['leaves_approved']);
                    $execPath = $_SERVER['SERVER_NAME']."/salary/Dashboard/salaryslip/".$id;
                    $note_name = $year.$month.$id.'.pdf';
                    $note_path = WWW_ROOT.DS.'printpdf/'.$note_name;
                    $html2Pdfcmd = "xvfb-run -a wkhtmltopdf $execPath $note_path";
                    shell_exec($html2Pdfcmd);

                 }else{
                   $salary['Salary']['days_paid']=($number-$this->data['SalaryDetail'][$key]['leaves_availed'])+$this->data['SalaryDetail'][$key]['leaves_approved'];
                   $salary['Salary']['leaves_approved']=$this->data['SalaryDetail'][$key]['leaves_approved'];
                   $salary['Salary']['leaves_availed']=$this->data['SalaryDetail'][$key]['leaves_availed'];
                   unset($salary['Salary']['id']);
                 }
                 //debug($salary);
                 if ($this->SalaryDetail->saveAll($salary['Salary'])) {
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Salary Details Saved.');
                    $success++;
                  } else {
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Salary Details not Saved. Please, try again.');
                    $fail++;
                  }
              }else{
                $fail++;
              }
              }
              
            }
            //exit;
            //echo $success;exit;
            if($count == $success){
              $this->Session->write('message_type','success');
              $this->Session->write('message',$success.'success salary Saved.');
            }else{
              $this->Session->write('message_type','success');
              $this->Session->write('message',$success.'success salary Saved.'.$fail.' failed salary');
            }
            
        }
      // }
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
  if(isset($year) && $year!=''){
    $selectedyear = $year;
  }else{
    $selectedyear = date("Y");
  }
  if(isset($month) && $month!=''){
    $selectedmonth = $month;
  }else{
    $selectedmonth = date("m", strtotime("-1 month"));
    $selectedmonthname = date("F", strtotime("-1 month"));
  }
  $selecteddesg='';
  if(isset($this->data['SalaryDetail']['desg']) && $this->data['SalaryDetail']['desg']!=''){
    $selecteddesg = $this->data['SalaryDetail']['desg'];
  }
  $this->set(compact('years','months','designations','department_list','selectedmonth','selectedmonthname','selectedyear','selecteddesg'));
}
////////////salary process//////////////////
public function process_sal(){
  $this->loadModel('SalaryDetail');
  $this->loadModel('Salary');
  //debug($this->data);
  $number = cal_days_in_month(CAL_GREGORIAN, $this->data['month'], $this->data['year']);
  
  $salary=$this->Salary->find('first',array(
          'conditions'=>array(
            'Salary.emp_id'=>$this->data['emp_id'],
          ),
        ));
       $salary['Salary']['no_of_days']=$number;
       $salary['Salary']['year']=$this->data['year'];
       $salary['Salary']['month']=$this->data['month'];
       $salary['Salary']['leaves_approved']=$this->data['leaves_approved'];
       $salary['Salary']['leaves_availed']=$this->data['leaves_availed'];
       $salary['Salary']['days_paid']=($number-$this->data['leaves_availed'])+$this->data['leaves_approved'];
       $salary['Salary']['processed_by_hr']='Y';
       if(isset($id) && $id!=''){
          $salary['Salary']['processed_by_accounts']='Y';
          $salary['Salary']['id']=$id;
          $execPath = $_SERVER['SERVER_NAME']."/salary/Dashboard/salaryslip/".$id;
          //$note_name = 'pdf_note_'.rand().'_'.time().'.pdf';
          $note_name = $year.$month.$id.'.pdf';
          $note_path = WWW_ROOT.DS.'printpdf/'.$note_name;
          $html2Pdfcmd = "xvfb-run -a wkhtmltopdf $execPath $note_path";
          shell_exec($html2Pdfcmd);
       }else{
         unset($salary['Salary']['id']);
       }
       //debug($salary['Salary']);exit;
       
      if ($this->SalaryDetail->saveAll($salary['Salary'])) {
        echo 'SUCCESS';exit;
      } else {
        echo 'FAILED';exit;
      }
}
////////////////////////Release Salary///////////
public function release_sal(){
  $this->loadModel('SalaryDetail');
       if(isset($this->data['id']) && $this->data['id']!=''){
          $this->request->data['SalaryDetail']['id']=$this->data['id'];
          $this->request->data['SalaryDetail']['processed_by_accounts']="'Y'";
          $execPath = $_SERVER['SERVER_NAME']."/salary/Dashboard/salaryslip/".$this->data['id'];
          //$note_name = 'pdf_note_'.rand().'_'.time().'.pdf';
          $note_name = $this->data['year'].$this->data['month'].$this->data['id'].'.pdf';
          $note_path = WWW_ROOT.DS.'printpdf/'.$note_name;
          $html2Pdfcmd = "xvfb-run -a wkhtmltopdf $execPath $note_path";
          shell_exec($html2Pdfcmd);
       }
       // debug($this->request->data);exit;
       
      if ($this->SalaryDetail->updateAll(array("SalaryDetail.processed_by_accounts"=>"'Y'"),array("SalaryDetail.id"=>$this->data['id']))) {
        echo 'SUCCESS';exit;
      } else {
        echo 'FAILED';exit;
      }
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
    $dept='';
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
        if(isset($this->data['dept']) && $this->data['dept'] != 0){
          $dept=$this->data['dept'];
          $condition1 += array('Employee.dept_id' => $dept);
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
      'fields' => array('Salary.*','SalaryDetail.id','SalaryDetail.month','SalaryDetail.days_paid','SalaryDetail.leaves_approved','SalaryDetail.leaves_availed','SalaryDetail.year','SalaryDetail.processed_by_hr','SalaryDetail.processed_by_accounts'),
      'limit'     => 20,
    );
    //debug($this->paginate);
    $this->set(array(
      'data'   => $this->paginate('Salary'),
      'year'   => $year,
      'month'  => $month,
      'desg'   => $desg,
      'dept'   => $dept
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
    $findemp_id=$this->SalaryDetail->find('first',array(
      'recursive'=>-1,
      'conditions'=>array(
        'SalaryDetail.id'=>$id,
      ),
    ));
    $employe_id=$findemp_id['SalaryDetail']['emp_id'];
    $finddept_id=$this->Employee->find('first',array(
      'recursive'=>-1,
      'conditions'=>array(
        'Employee.id'=>$employe_id,
      ),
    ));
    
    $this->SalaryDetail->setDataSource('live');
    $dept_name=$this->SalaryDetail->query("select name from ohrm_subunit where id=".$finddept_id['Employee']['dept_id']."");
    $this->SalaryDetail->setDataSource('default');
    $dep_name=$dept_name[0]['ohrm_subunit']['name'];
    //$deparment_name=$this->Deparment->query("select name from ohrm_subunit where id=");
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
    $this->set(compact('data','dep_name'));
  }
///////////////////////download pdf////////////
  public function pdfDownload($id=''){
      $this->autorender=false;
      
      $execPath = $_SERVER['SERVER_NAME']."/salary/Dashboard/salaryslip/".$id;
      $note_name = 'pdf_note_'.rand().'_'.time().'.pdf';
      //move_uploaded_file($file['tmp_name'],WWW_ROOT.DS.'printpdf/'.$note_name);
      //$data->read(WWW_ROOT.DS.'challanfiles/'.$file['name']);
      //$note_path = __DIR__.'/../../files/pdfDownload/'.$note_name;
      // echo  WWW_ROOT.'printpdf/'.$note_name;exit;
      $note_path = WWW_ROOT.DS.'printpdf/'.$note_name;
      $html2Pdfcmd = "xvfb-run -a wkhtmltopdf $execPath $note_path";
      shell_exec($html2Pdfcmd);
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
        $this->Session->write('message_type','success');
        $this->Session->write('message','Master salary Saved.');
        return $this->redirect(array('action' => 'salariesbreakup'));
      } else {
        $this->Session->write('message_type','error');
        $this->Session->write('message','Master salary not saved. Please, try again.');
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
//////////////////////////load emp data/////////////
public function ajaxloadempsdata(){
  $this->layout = 'ajax';
    $this->loadModel('OhrmKpi');
    $this->loadModel('OhrmPerformanceReview');
    $this->loadModel('OhrmReviewerRating');
    $this->loadModel('HsHrEmployee');
    $condition = array(); 
    $condition1 = array();
    $desg='';
        
        if(isset($this->data['desg']) && $this->data['desg'] != ''){
          $desg=$this->data['desg'];
          $condition += array('HsHrEmployee.job_title_code' => $desg );
        }
        if(isset($this->data['from_month']) && $this->data['from_month'] != '' && isset($this->data['from_year']) && $this->data['from_year'] != ''){
          $work_period_start=$this->data['from_year'].'-'.$this->data['from_month'].'-01';
          $condition += array('OhrmPerformanceReview.work_period_start >=' => $work_period_start );

        }
        if(isset($this->data['to_month']) && $this->data['to_month'] != '' && isset($this->data['to_year']) && $this->data['to_year'] != ''){
          $a_date = $this->data['to_year'].'-'.$this->data['to_month'].'-01';
          $work_period_end=date("Y-m-t", strtotime($a_date));
          $condition += array('OhrmPerformanceReview.work_period_end <=' => $work_period_end );
        }
        if(isset($this->data['dept']) && $this->data['dept'] != ''){
          $dept=$this->data['dept'];
          $condition += array('HsHrEmployee.work_station' => $dept );
        }
    $this->OhrmPerformanceReview->setDataSource('live');
    $this->HsHrEmployee->setDataSource('live');
    $employees = $this->HsHrEmployee->find('all',array(
      'recursive'=>-1,
      'joins' => array(
            array(
                'alias' => 'OhrmPerformanceReview',
                'table' => 'ohrm_performance_review',
                'type' => 'inner',
                'conditions' => array('OhrmPerformanceReview.employee_number=HsHrEmployee.emp_number'),
            )      
        ),
      'conditions'  => $condition,
      'fields' => array('HsHrEmployee.emp_number','HsHrEmployee.emp_firstname','HsHrEmployee.emp_middle_name','HsHrEmployee.emp_lastname'),
      /*'order'=>array(
        'Designation.name'
      )*/
    ));
    $employee_list=array();
    foreach ($employees as $key => $value) {
      $name=$value['HsHrEmployee']['emp_firstname'];
     if($value['HsHrEmployee']['emp_middle_name'] != ''){
        $name=$name.' '.$value['HsHrEmployee']['emp_middle_name'];
      }
      if($value['HsHrEmployee']['emp_lastname'] != ''){
        $name=$name.' '.$value['HsHrEmployee']['emp_lastname'];
      }
     $employee_list[$value['HsHrEmployee']['emp_number']]=$name;
    }
    //debug($employee_list);exit;
    $this->set(array('employee_list'   => $employee_list,));
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
//////////////////////kpi report////////////////////
public function kpicompactReport(){
    $this->loadModel('Salary');
    $this->loadModel('SalaryDetail');
    $this->loadModel('Employee');
    $this->loadModel('OhrmKpi');
    $this->loadModel('OhrmPerformanceReview');
    $this->loadModel('OhrmReviewerRating');

    $this->loadModel('Designation');
    $this->Designation->primaryKey='hrm_id';
    $designations=$this->Designation->find('list',array(
      'order'=>array(
        'Designation.name'
      )
    ));
    $this->Designation->setDataSource('live');
    $department=$this->Designation->query("select id,name from ohrm_subunit order by name");
    $this->Designation->setDataSource('default');
    // debug($department);
    $department_list=array();
    foreach ($department as $key => $value) {
     $department_list[$value['ohrm_subunit']['id']]=$value['ohrm_subunit']['name'];
    }
    $this->OhrmPerformanceReview->setDataSource('live');
    
    $this->paginate = array(
      'recursive'=>-1,
      'limit'     => 20,
    );
    $from_year=date('Y')-3;
    $to_year=date('Y')+1;
    $years=null;
    for($i=$from_year;$i<=$to_year;$i++){
      $years[$i]=$i;
    }
    $months=array(
      '01'=>'January',
      '02'=>'February',
      '03'=>'March',
      '04'=>'April',
      '05'=>'May',
      '06'=>'Jun',
      '07'=>'July',
      '08'=>'August',
      '09'=>'September',
      '10'=>'October',
      '11'=>'November',
      '12'=>'December'
    );
    $employees=$this->Employee->find('list',array(
        'conditions'=>array(
          'Employee.is_terminated'=>0,
        ),
        'order'=>array(
          'Employee.name'
        )
      ));
    //debug($this->paginate);
    $this->set(array(
      'data'   => $this->paginate('OhrmPerformanceReview'),
      'designations' => $designations,
      'department_list' => $department_list,
      'years'           => $years,
      'months'          => $months,
      'employees'       => $employees
    ));

}
//////////////////////////////ajax get year//////////////////////////
public function ajaxYear(){
  $this->layout = 'ajax';
    $from_year=$this->data['year'];
    $to_year=date('Y')+4;
    $years=null;
    for($i=$from_year;$i<=$to_year;$i++){
      $years[$i]=$i;
    }
    $this->set(array(
      'years'   => $years,
    ));
}

////////////////////////////////////////////////////////////////////
public function kpiview(){
  $this->loadModel('Designation');
  $this->loadModel('Department');
  $this->loadModel('Employee');
  $this->Designation->primaryKey='hrm_id';
  $designations=$this->Designation->find('list',array(
    'order'=>array(
      'Designation.name'
    )
  ));
  $desg='';
  $dept='';
  $emp_id='';
  $name='';
  $from_year=date('Y')-3;
    $to_year=date('Y')+1;
    $years=null;
    for($i=$from_year;$i<=$to_year;$i++){
      $years[$i]=$i;
    }
    $months=array(
      '01'=>'January',
      '02'=>'February',
      '03'=>'March',
      '04'=>'April',
      '05'=>'May',
      '06'=>'Jun',
      '07'=>'July',
      '08'=>'August',
      '09'=>'September',
      '10'=>'October',
      '11'=>'November',
      '12'=>'December'
    );
  
      $this->Department->setDataSource('live');
      $department_list = $this->Department->find('list', array(
        'order'  => array(
          'Department.name',
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
  $this->set(compact('designations','years','months','department_list','employees','desg','dept','emp_id','name'));
}

////////////////////////////////////////////////////

public function ajaxKpi(){
  $this->layout = 'ajax';
    $this->loadModel('OhrmKpi');
    $this->loadModel('OhrmPerformanceReview');
    $this->loadModel('OhrmReviewerRating');
    $this->loadModel('HsHrEmployee');
    $condition = array(); 
    $condition1 = array();
    $desg='';
    $name='';
    $dept='';
    $emp_id='';
         $this->OhrmPerformanceReview->setDataSource('live');
         $this->HsHrEmployee->setDataSource('live');
        //debug($this->data);exit;
        if(isset($this->data['desg']) && $this->data['desg'] != ''){
          $desg=$this->data['desg'];
          $condition += array('OhrmPerformanceReview.job_title_code' => $desg );
        }
        if(isset($this->data['from_month']) && $this->data['from_month'] != '' && isset($this->data['from_year']) && $this->data['from_year'] != ''){
          $work_period_start=$this->data['from_year'].'-'.$this->data['from_month'].'-01';
          $condition += array('OhrmPerformanceReview.work_period_start >=' => $work_period_start );

        }
        if(isset($this->data['to_month']) && $this->data['to_month'] != '' && isset($this->data['to_year']) && $this->data['to_year'] != ''){
          $a_date = $this->data['to_year'].'-'.$this->data['to_month'].'-01';
          $work_period_end=date("Y-m-t", strtotime($a_date));
          $condition += array('OhrmPerformanceReview.work_period_end <=' => $work_period_end );
        }
        if(isset($this->data['dept']) && $this->data['dept'] != ''){
          $dept=$this->data['dept'];
          $condition += array('HsHrEmployee.work_station' => $dept );
        }
        if(isset($this->data['emp_name']) && $this->data['emp_name'] != ''){
          //$emp_name=$this->data['emp_name'];
          //$emp_name=str_replace(" ","%",$emp_name);
          //concat(HsHrEmployee.emp_firstname,' ',HsHrEmployee.emp_middle_name,' ',HsHrEmployee.emp_lastname)
          //$condition += array("concat(HsHrEmployee.emp_firstname,' ',HsHrEmployee.emp_middle_name,' ',HsHrEmployee.emp_lastname) LIKE '%$emp_name%'");
          $emp_id=$this->data['emp_name'];
          $condition += array('HsHrEmployee.emp_number' => $this->data['emp_name'] );
        }
      if(isset($this->data['emp_name']) && $this->data['emp_name'] != ''){
      $emp_name = $this->HsHrEmployee->find('first',array(
        'recursive'=>-1,
        'conditions'  => array('HsHrEmployee.emp_number' => $this->data['emp_name'] ),
        'fields' => array('HsHrEmployee.emp_firstname','HsHrEmployee.emp_middle_name','HsHrEmployee.emp_lastname'),
      ));
      $name=$emp_name['HsHrEmployee']['emp_firstname'];
         if($emp_name['HsHrEmployee']['emp_middle_name'] != ''){
            $name=$name.' '.$emp_name['HsHrEmployee']['emp_middle_name'];
          }
          if($emp_name['HsHrEmployee']['emp_lastname'] != ''){
            $name=$name.' '.$emp_name['HsHrEmployee']['emp_lastname'];
          }
        
      }
        //debug($condition1);
    
    $this->paginate = array(
      'recursive'=>-1,
      'joins' => array(
            array(
                'alias' => 'HsHrEmployee',
                'table' => 'hs_hr_employee',
                'type' => 'inner',
                'conditions' => array('HsHrEmployee.emp_number = OhrmPerformanceReview.employee_number'),
            )      
        ),
      'conditions'  => $condition,
      'limit'     => 20,
    );
    //debug($this->paginate);
    $this->set(array(
      'reviewdata'   => $this->paginate('OhrmPerformanceReview'),
      'desg'   => $desg,
      '$dept'  => $dept,
      'emp_id' => $emp_id,
      'name'   => $name
    ));
   
}
///////////////////////////ajaxkpiCompact///////////////////
public function ajaxkpiCompact(){
    $this->layout = 'ajax';
    $this->loadModel('OhrmKpi');
    $this->loadModel('OhrmPerformanceReview');
    $this->loadModel('OhrmReviewerRating');
    $this->loadModel('HsHrEmployee');
    $condition = array(); 
    $condition1 = array();
    $dept='';
    $name='';
    $emp_id='';
    //debug($this->data);exit;
        $this->OhrmPerformanceReview->setDataSource('live');
        $this->HsHrEmployee->setDataSource('live');
        if(isset($this->data['from_month']) && $this->data['from_month'] != 0 && isset($this->data['from_year']) && $this->data['from_year'] != 0){
          /*$from_date=$this->data['from_date'];
          $from_date=explode("/",$from_date);*/
          $work_period_start=$this->data['from_year'].'-'.$this->data['from_month'].'-01';
          $condition1 += array('OhrmPerformanceReview.work_period_start >=' => $work_period_start );

        }
        if(isset($this->data['to_month']) && $this->data['to_month'] != 0 && isset($this->data['to_year']) && $this->data['to_year'] != 0){
          /*$to_date=$this->data['to_date'];
          $to_date=explode("/",$to_date);*/
          $a_date = $this->data['to_year'].'-'.$this->data['to_month'].'-01';
          $work_period_end=date("Y-m-t", strtotime($a_date));
          //$work_period_end=$this->data['to_year'].'-'.$this->data['to_month'].'-t';
          $condition1 += array('OhrmPerformanceReview.work_period_end <=' => $work_period_end );
        }
        if(isset($this->data['desg']) && $this->data['desg'] != ''){
          $desg=$this->data['desg'];
          $condition1 += array('OhrmPerformanceReview.job_title_code' => $desg );
        }
        if(isset($this->data['dept']) && $this->data['dept'] != 0){
          $dept=$this->data['dept'];
          $condition1 += array('HsHrEmployee.work_station' => $dept );
        }
        // if(isset($this->data['emp_name']) && $this->data['emp_name'] != ''){
        //   $emp_name=$this->data['emp_name'];
        //   $emp_name=str_replace(" ","%",$emp_name);
        //   //concat(HsHrEmployee.emp_firstname,' ',HsHrEmployee.emp_middle_name,' ',HsHrEmployee.emp_lastname)
        //   $condition1 += array("concat(HsHrEmployee.emp_firstname,' ',HsHrEmployee.emp_middle_name,' ',HsHrEmployee.emp_lastname) LIKE '%$emp_name%'");
        // }
        if(isset($this->data['emp_name']) && $this->data['emp_name'] != ''){
          $emp_id=$this->data['emp_name'];
          $condition1 += array('HsHrEmployee.emp_number' => $this->data['emp_name'] );
        }
      if(isset($this->data['emp_name']) && $this->data['emp_name'] != ''){
        $emp_name = $this->HsHrEmployee->find('first',array(
          'recursive'=>-1,
          'conditions'  => array('HsHrEmployee.emp_number' => $this->data['emp_name'] ),
          'fields' => array('HsHrEmployee.emp_firstname','HsHrEmployee.emp_middle_name','HsHrEmployee.emp_lastname'),
        ));
        $name=$emp_name['HsHrEmployee']['emp_firstname'];
         if($emp_name['HsHrEmployee']['emp_middle_name'] != ''){
            $name=$name.' '.$emp_name['HsHrEmployee']['emp_middle_name'];
          }
          if($emp_name['HsHrEmployee']['emp_lastname'] != ''){
            $name=$name.' '.$emp_name['HsHrEmployee']['emp_lastname'];
          }
        
      }
        //debug($condition1);exit;
    
    $this->paginate = array(
      'recursive'=>-1,
      'joins' => array(
            array(
                'alias' => 'HsHrEmployee',
                'table' => 'hs_hr_employee',
                'type' => 'inner',
                'conditions' => array('HsHrEmployee.emp_number = OhrmPerformanceReview.employee_number'),
            )      
        ),
      'conditions'  => $condition1,
      'limit'     => 20,
    );
    //debug($this->paginate);
    $this->set(array(
      'data'   => $this->paginate('OhrmPerformanceReview.*'),
      'dept'   => $dept,
      'name'   => $name
    ));
}


}
