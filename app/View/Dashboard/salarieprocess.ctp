    
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
                                      <?php echo $this->Form->input('year',array('label'=>false,'class'=>'form-control','options'=>$years,'empty'=>'-- Select Year --','required'=>false,'style'=>'width:200px;','onchange'=>'getemplist1(this.value)','data-tabindex' => "1"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Month</label>
                                      <?php echo $this->Form->input('month',array('label'=>false,'class'=>'form-control','options'=>$months,'empty'=>'-- Select Month --','required'=>false,'onchange'=>'getemplist(this.value)','style'=>'width:200px;','data-tabindex' => "2"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Designation</label>
                                      <?php echo $this->Form->input('designation_id',array('label'=>false,'class'=>'form-control','options'=>$designations,'empty'=>'-- Select Designation --','required'=>false,'onchange'=>'getemplist2(this.value)','style'=>'width:200px;','data-tabindex' => "3"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Department</label>
                                      <?php echo $this->Form->input('dept_id',array('label'=>false,'class'=>'form-control','options'=>$department_list,'empty'=>'-- Select Department --','required'=>false,'onchange'=>'getdeptemplist(this.value)','style'=>'width:200px;','data-tabindex' => "4"));
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
        
            var year = '".$selectedyear."';
            $('#select2-SalaryDetailYear-container').html(year);
            $('#SalaryDetailYear').val( year );
            var month = '".$selectedmonth."';
            var formattedMonth = '".$selectedmonthname."';
            $('#select2-SalaryDetailMonth-container').html(formattedMonth);
            $('#SalaryDetailMonth').val(month);
            var desg='".$selecteddesg."';
            $('#SalaryDetailDesignationId').val(desg);
            getemplist(month);

    function processsalary(emp_id,month,year){
      var leaves_approved=$('.leaves_approved_'+emp_id).val();
      var leaves_availed=$('.leaves_availed_'+emp_id).val();
        var url = '".$ajaxProcess."';
        $.post(url, {year:year,month:month,emp_id:emp_id,leaves_approved:leaves_approved,leaves_availed:leaves_availed}, function(res) {
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
      var dept=$('#SalaryDetailDeptId').val;
      var val=$('#SalaryDetailMonth').val();
      if(year==''){
        alert('Please select a year');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:year,month:val,desg:desg,dept:dept}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }
    function getemplist2(val){
      var year=$('#SalaryDetailYear').val();
      var month=$('#SalaryDetailMonth').val();
      var dept=$('#SalaryDetailDeptId').val;
      if(year=='' && month ==''){
        alert('Please select a year');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:year,month:month,desg:val,dept:dept}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }
    function getemplist1(val){
      var month=$('#SalaryDetailMonth').val();
      var desg=$('#SalaryDetailDesignationId').val();
      var dept=$('#SalaryDetailDeptId').val;
      if(month==''){
        alert('Please select a month');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:val,month:month,desg:desg,dept:dept}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
           
    }
  function getdeptemplist(val){
    var year=$('#SalaryDetailYear').val();
    var month=$('#SalaryDetailMonth').val();
    var desg=$('#SalaryDetailDesignationId').val();
      if(month==''){
        alert('Please select a month');
      }else{
        var url = '".$ajaxUrl."';
        $.post(url, {year:year,month:month,dept:val,desg:desg}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        }); 
      }
  }

",array('inline'=>false));
?>


<script type="text/javascript">
var elements = $(document).find('select.form-control');
for (var i = 0, l = elements.length; i < l; i++) {
  var $select = $(elements[i]), $label = $select.parents('.form-group').find('label');
  $select.select2({
    allowClear: false,
    placeholder: $select.data('placeholder'),
    minimumResultsForSearch: 0,
    theme: 'bootstrap',
    width: '100%' // https://github.com/select2/select2/issues/3278
  });
  
  // Trigger focus
  $label.on('click', function (e) {
    $(this).parents('.form-group').find('select').trigger('focus').select2('focus');
  });
  
  // Trigger search
  $select.on('keydown', function (e) {
    var $select = $(this), $select2 = $select.data('select2'), $container = $select2.$container;
    
    // Unprintable keys
    if (typeof e.which === 'undefined' || $.inArray(e.which, [0, 8, 9, 12, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 44, 45, 46, 91, 92, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 123, 124, 144, 145, 224, 225, 57392, 63289]) >= 0) {
      return true;
    }

    // Opened dropdown
    if ($container.hasClass('select2-container--open')) {
      return true;
    }

    $select.select2('open');

    // Default search value
    var $search = $select2.dropdown.$search || $select2.selection.$search, query = $.inArray(e.which, [13, 40, 108]) < 0 ? String.fromCharCode(e.which) : '';
    if (query !== '') {
      $search.val(query).trigger('keyup');
    }
  });

  // Format, placeholder
  $select.on('select2:open', function (e) {
    var $select = $(this), $select2 = $select.data('select2'), $dropdown = $select2.dropdown.$dropdown || $select2.selection.$dropdown, $search = $select2.dropdown.$search || $select2.selection.$search, data = $select.select2('data');
    
    // Above dropdown
    if ($dropdown.hasClass('select2-dropdown--above')) {
      $dropdown.append($search.parents('.select2-search--dropdown').detach());
    }

    // Placeholder
    $search.attr('placeholder', (data[0].text !== '' ? data[0].text : $select.data('placeholder')));
  });
}
</script>  