          <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <!-- <h1 class="page-header">Forms</h1> -->
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Process Salary
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-md-12">
                            <?php echo $this->Form->create('SalaryDetail');?>
                                <fieldset>
                                  <legend>Process Salary</legend>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Year</label>
                                      <?php echo $this->Form->input('year',array('label'=>false,'class'=>'form-control','options'=>$years,'empty'=>'-- Select Year --','required'=>false,'style'=>'width:200px;','onchange'=>'getemplist1(this.value)'));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Month</label>
                                      <?php echo $this->Form->input('month',array('label'=>false,'class'=>'form-control','options'=>$months,'empty'=>'-- Select Month --','required'=>false,'onchange'=>'getemplist(this.value)','style'=>'width:200px;'));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Designation</label>
                                      <?php echo $this->Form->input('designation_id',array('label'=>false,'class'=>'form-control','options'=>$designations,'empty'=>'-- Select Designation --','required'=>false,'onchange'=>'getemplist2(this.value)','style'=>'width:200px;'));
                                      ?> 
                                  </div>
                              </fieldset>
                              </div>
                            
                            </div>
                            
                        </div>
                    </div>
                     <!-- End Form Elements -->
                     <!--table listing-->
                     
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive" id="listingDiv" style="background-color:white">

                                </div>
                            </div>
                        </div>
                <!-- end table listing-->
                
                </div>
            </div>
<?php
$ajaxUrl   = $this->Html->url(array('controller'=>'Dashboard','action'=>'indexAjax'));
$ajaxProcess   = $this->Html->url(array('controller'=>'Dashboard','action'=>'process_sal'));
$ajaxRelease   = $this->Html->url(array('controller'=>'Dashboard','action'=>'release_sal'));
echo $this->Html->scriptBlock("

    function processsalary(emp_id,month,year){
      var days_paid=$('.days_paid_'+emp_id).val();
      var leaves_availed=$('.leaves_availed_'+emp_id).val();
        var url = '".$ajaxProcess."';
        $.post(url, {year:year,month:month,emp_id:emp_id,days_paid:days_paid,leaves_availed:leaves_availed}, function(res) {
            if (res == 'SUCCESS') {
               getemplist(month);
            }
        }); 
      
           
    }
    function releasesalary(emp_id,id,month,year){
        var url = '".$ajaxRelease."';
        $.post(url, {emp_id:emp_id,id:id,year:year,month:month}, function(res) {
            if (res == 'SUCCESS') {
               getemplist(month);
            }
        }); 
      
           
    }
    
    function getemplist(val){
      var year=$('#SalaryDetailYear').val();
      var desg=$('#SalaryDetailDesignationId').val();
      var val=$('#SalaryDetailMonth').val();
      if(year==''){
        alert('Please select a year');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:year,month:val,desg:desg}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }
    function getemplist2(val){
      var year=$('#SalaryDetailYear').val();
      var month=$('#SalaryDetailMonth').val();
      if(year=='' && month ==''){
        alert('Please select a year');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:year,month:month,desg:val}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }
    function getemplist1(val){
      var month=$('#SalaryDetailMonth').val();
      if(month==''){
        alert('Please select a month');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:val,month:month}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }

",array('inline'=>false));
?>


<!-- $(document).ready(function(){
        showData();
    }); -->