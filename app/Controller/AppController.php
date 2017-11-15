<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
function beforeFilter(){
	$this->set('funcall',$this); 
}
	function findemployeename($emp_no){
      $this->loadModel('Employee');
      $return = $this->Employee->find('first', array(
        'conditions'  => array(
          'emp_number'  => $emp_no,
        )
      ));

      return $return['Employee']['name'];
    }
    function finddeptname($dept_id){
    $this->loadModel('Department');
      $this->Department->setDataSource('live');
      $return = $this->Department->find('first', array(
        'conditions'  => array(
          'id'  => $dept_id,
        )
      ));
      return $return['Department']['name'];
    }
     function findkpi($emp_no){
    $this->loadModel('OhrmPerformanceReview');
    $this->loadModel('OhrmReviewerRating');
    $this->loadModel('OhrmKpi');
      $this->OhrmPerformanceReview->setDataSource('live');
      $this->OhrmReviewerRating->setDataSource('live');
      $this->OhrmKpi->setDataSource('live');
      $return = $this->OhrmPerformanceReview->find('first', array(
        'conditions'  => array(
          'OhrmPerformanceReview.employee_number'  => 324,
        ),
      ));
      $kpirating = $this->OhrmReviewerRating->find('all', array(
      	'recursive'=>-1,
		    'joins' => array(
		        array(
		            'alias' => 'OhrmKpi',
		            'table' => 'ohrm_kpi',
		            'type' => 'inner',
		            'conditions' => array('OhrmKpi.id = OhrmReviewerRating.kpi_id'),
		        )      
		    ),
        'conditions'  => array(
          'OhrmReviewerRating.review_id'  => $return['OhrmPerformanceReview']['id'],
        ),
        'fields' => array('OhrmReviewerRating.*','OhrmKpi.kpi_indicators','OhrmKpi.max_rating')
      ));
     
      return $kpirating;
    }

    function findkpititle($desg_id){
    	$this->loadModel('OhrmKpi');
    	$this->OhrmKpi->setDataSource('live');
	      $return = $this->OhrmKpi->find('all', array(
	        'conditions'  => array(
	          'OhrmKpi.job_title_code'  => $desg_id,
	        ),
	        'order'=>array(
		      'OhrmKpi.id'
		    )
	      ));
	      return $return;
    }
    
    
}
