<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<?php
echo $this->Form->create('Salary');
/*echo $this->Form->input('year',array(
  'label'=>'Select Year',
  'options'=>$years,
  'default'=>date('Y'),
  'empty'=>'-- Select Year --',
  'required'
));
echo $this->Form->input('month',array(
  'label'=>'Select Month',
  'options'=>$months,
  'default'=>(int)date('m'),
  'empty'=>'-- Select Month --',
  'required'
));*/
echo $this->Form->input('category_id',array(
  'label'=>'Select Category',
  'options'=>$categories,
  'empty'=>'-- Select Category --',
  'required'=>false,
  'onchange'=>'loadempsbycat(this.value)'
));
echo $this->Form->input('designation_id',array(
  'label'=>'Select Designation',
  'options'=>$designations,
  'empty'=>'-- Select Designation --',
  'required'=>false,
  'onchange'=>'loadempsbydes(this.value)'
));
echo $this->Form->input('employee_id',array(
  'label'=>'Select Employee',
  'options'=>$employees,
  'empty'=>'-- Select Employee --',
  'required',
));
 ?>
<button type="button" name="button" onclick="loadempdata()">Proceed</button>
<div class="" id="divloadempdata"></div>
 </form>
<script type="text/javascript">
  function loadempsbycat(str){
    if(str != ''){
      $.get("<?php echo SITE; ?>dashboard/loadempsbycat/"+str,function(data){
        $("#SalaryEmployeeId").html(data);
      });
    }
  }

  function loadempsbydes(str){
    if(str != ''){
      $.get("<?php echo SITE; ?>dashboard/loadempsbydes/"+str,function(data){
        $("#SalaryEmployeeId").html(data);
      });
    }
  }

  function loadempdata(){
    var str=document.getElementById("SalaryEmployeeId").value;
    if(str != ""){
      alert(str);
    }else{
      $("#divloadempdata").html("");
    }
  }
</script>
