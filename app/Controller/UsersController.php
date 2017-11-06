<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController{
  public $components = array('Paginator', 'Flash','Session');

  public function login(){
    $this->layout='login';
    if($this->request->is(array('post','put'))){
        $is_valid=0;
        $cnt=$this->User->find('count',array(
          'conditions'=>array(
            'User.login_id'=>$this->request->data['User']['login_id'],
            'User.password'=>$this->request->data['User']['password'],
            'User.is_enable'=>1
          )
        ));
        if($cnt > 0){
          $is_valid=1;
        }
        if($is_valid == 0){
            $this->Flash->error('Invalid Credential !');
        }else{
          $this->Session->write('login_id',$this->request->data['User']['login_id']);
          //$this->Session->write('id',$this->request->data['User']['id']);
          $this->redirect(array(
            'controller'=>'dashboard',
            'action'=>'index'
          ));
        }
    }
  }
  //////////////////////////////////////////
}
