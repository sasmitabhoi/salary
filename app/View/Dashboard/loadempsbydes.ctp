<?php
echo $this->Form->input('Salary.employee_id',array(
  'label'=>'Select Employee',
  'options'=>$employees,
  'empty'=>'-- Select Employee --',
  'required',
));
 ?>
