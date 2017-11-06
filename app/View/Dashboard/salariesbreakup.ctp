          <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Master Salary Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-md-12">
                            <?php echo $this->Form->create('Search');?>
                                <fieldset>
                                  <legend>Get Employee Details</legend>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Category</label>
                                      <?php echo $this->Form->input('category_id',array('label'=>false,'class'=>'form-control','options'=>$categories,'empty'=>'-- Select Category --','required'=>false,'onchange'=>'loadempsbycat(this.value)','style'=>'width:200px;'));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Designation</label>
                                      <?php echo $this->Form->input('designation_id',array('label'=>false,'class'=>'form-control','options'=>$designations,'empty'=>'-- Select Designation --','required'=>false,'onchange'=>'loadempsbydes(this.value)','style'=>'width:200px;'));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label class="control-label">Select Employee</label>
                                      <?php echo $this->Form->input('employee_id',array('label'=>false,'class'=>'form-control','options'=>$employees,'empty'=>'-- Select Employee --','required'=>false,'style'=>'width:200px;','onchange'=>"loadempdata()"));
                                      ?> 
                                  </div>
                                  <!-- <div class="form-group col-md-3">
                                  <label class="control-label"></label>
                                  <?//php echo $this->Form->button('Search',array('type'=>'button','label'=>false,'onclick'=>"loadempdata()",'class'=>'form-control btn btn-primary','style'=>'width:100px;'));
                                     //   echo $this->Form->end();
                                  ?>
                                  </div> -->
                              </fieldset>
                              </div>
                            <div class="employeedetail">
                            <?php echo $this->Form->create('Salary');?>
                            <?php echo $this->Form->input('emp_id',array('type'=>'hidden','class'=> 'tbox','label'=>false,'div'=>false)); ?> 
                                <fieldset>
                                  <legend>Employee Details</legend>
                                <div class="col-md-6">
                                <fieldset>
                                  <legend>Gross</legend>
                                        <div class="form-group">
                                            <label class="control-label">Employee Name</label>
                                            <?php echo $this->Form->input('emp_name',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                            ?> 
                                            <!-- <input class="form-control"> -->
                                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Working Days</label>
                                            <?php echo $this->Form->input('no_of_days',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                            ?> 
                                            <!-- <input class="form-control"> -->
                                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Basic</label>
                                            <?php echo $this->Form->input('emp_basic',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()"));
                                            ?> 
                                            <!-- <input class="form-control"> -->
                                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                                        </div>
                                   <div class="form-group col-md-4">
                                      <label class="control-label">% of basic</label>
                                      <?php echo $this->Form->input('basic_percentage',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"gethra(this.value)"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-8">
                                      <label class="control-label">HRA</label>
                                      <?php echo $this->Form->input('emp_hra',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label">Conveyance  Allowance</label>
                                      <?php echo $this->Form->input('emp_con_all',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()"));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                        <div class="form-group">
                                            <label class="control-label">Communication Allowance</label>
                                            <?php echo $this->Form->input('emp_comm_all',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()"));
                                            ?> 
                                            <!-- <input class="form-control"> -->
                                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Special Allownce</label>
                                            <?php echo $this->Form->input('emp_spl_all',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()"));
                                            ?> 
                                            <!-- <input class="form-control"> -->
                                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                                        </div>
                                  </fieldset>
                                  <div class="form-group">
                                      <label class="control-label">GROSS Salary</label>
                                      <?php echo $this->Form->input('emp_gross_sal',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','placeholder'=>'Basic+HRA+Conveyance+Communication+Special'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label class="control-label">% of Gross</label>
                                      <?php echo $this->Form->input('gross_percentage',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getcommit_all(this.value)"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-8">
                                      <label class="control-label">Commitment allowance</label>
                                      <?php echo $this->Form->input('emp_commit_all',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                </div>
                                <div class="col-md-6">
                                <fieldset>
                                  <legend>CTC</legend>
                                  <div class="form-group col-md-4">
                                      <label class="control-label">% of Basic</label>
                                      <?php echo $this->Form->input('empr_percentage_pf',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getempr_pf(this.value)"));
                                      ?> 
                                  </div>                                  
                                  <div class="form-group col-md-8">
                                      <label class="control-label">Employer PF</label>
                                      <?php echo $this->Form->input('empr_pf',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label class="control-label">% of Gross</label>
                                      <?php echo $this->Form->input('empr_percentage_gross',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getempr_gross(this.value)"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-8">
                                      <label class="control-label">ESI (Employer)</label>
                                      <?php echo $this->Form->input('empr_esi',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label">CTC</label>
                                      <?php echo $this->Form->input('emp_ctc',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','placeholder'=>'Gross+PF+ESIC'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <legend>Take Home</legend>
                                  <div class="form-group col-md-4">
                                      <label class="control-label">% of Basic</label>
                                      <?php echo $this->Form->input('emp_percentage_pf',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getemp_pf(this.value)"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-8">
                                      <label class="control-label">Employee PF</label>
                                      <?php echo $this->Form->input('emp_pf',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label class="control-label">% of Gross</label>
                                      <?php echo $this->Form->input('emp_percentage_gross',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getemp_gross(this.value)"));
                                      ?> 
                                  </div>
                                  <div class="form-group col-md-8">
                                      <label class="control-label">ESIC (Employee)</label>
                                      <?php echo $this->Form->input('emp_esi',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label">Proffessional Tax (PT)</label>
                                      <?php echo $this->Form->input('emp_prof_tax',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"takehome()"));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label">Income Tax (IT)</label>
                                      <?php echo $this->Form->input('emp_inc_tax',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"takehome()"));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label">Advance</label>
                                      <?php echo $this->Form->input('emp_adv',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'onkeyup'=>"takehome()"));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                </fieldset>
                                <div class="form-group">
                                      <label class="control-label">Take Home</label>
                                      <?php echo $this->Form->input('emp_takehome',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','placeholder' =>'Gross-employeePF-ESIC-PT-IT-Advance'));
                                      ?> 
                                      <!-- <input class="form-control"> -->
                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                  </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-success">Reset</button>
                                </fieldset>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
<script type="text/javascript">
//////////////////////////////////////////////hra/////////////////////////////////////////////////////
  function gethra(str){
    var basic=document.getElementById("SalaryEmpBasic").value;
    if(str != '' && basic!=''){
      $.get("<?php echo SITE; ?>dashboard/gethra/"+str+"/"+basic,function(data){
        $("#SalaryEmpHra").val(data);
        $('#SalaryEmpHra').attr('readonly', true);
        getgross_sal();
      });
    }
  }
  
  /////////////////commitment allowance///////////////////////////////////////////////////////////////
  function getcommit_all(str){
     var gross=document.getElementById("SalaryEmpGrossSal").value;
      if(str != '' && gross!=''){
        $.get("<?php echo SITE; ?>dashboard/getcommit_all/"+str+"/"+gross,function(data){
          $("#SalaryEmpCommitAll").val(data);
          $('#SalaryEmpCommitAll').attr('readonly', true);
        });
      }
  }
  ///////////////////////////////////////employee//////////////////////////////////////////////////////
  function getemp_pf(str){
    var basic=document.getElementById("SalaryEmpBasic").value;
    if(str != '' && basic!=''){
      $.get("<?php echo SITE; ?>dashboard/gethra/"+str+"/"+basic,function(data){
        $("#SalaryEmpPf").val(data);
        $('#SalaryEmpPf').attr('readonly', true);
        takehome();
      });
    }
  }
  function getemp_gross(str){
     var gross=document.getElementById("SalaryEmpGrossSal").value;
      if(str != '' && gross!=''){
        $.get("<?php echo SITE; ?>dashboard/getcommit_all/"+str+"/"+gross,function(data){
          $("#SalaryEmpEsi").val(data);
          $('#SalaryEmpEsi').attr('readonly', true);
          takehome();
        });
      }
  }
  ///////////////////////////employer////////////////////////////////////////////////////////////////
  function getempr_pf(str){
    var basic=document.getElementById("SalaryEmpBasic").value;
    if(str != '' && basic!=''){
      $.get("<?php echo SITE; ?>dashboard/gethra/"+str+"/"+basic,function(data){
        $("#SalaryEmprPf").val(data);
        $('#SalaryEmprPf').attr('readonly', true);
        getctc();
      });
    }
  }
  function getempr_gross(str){
     var gross=document.getElementById("SalaryEmpGrossSal").value;
      if(str != '' && gross!=''){
        $.get("<?php echo SITE; ?>dashboard/getcommit_all/"+str+"/"+gross,function(data){
          $("#SalaryEmprEsi").val(data);
          $('#SalaryEmprEsi').attr('readonly', true);
          getctc();
        });
      }
  }
  function takehome(){
    var a,b,c;
        if(document.getElementById('SalaryEmpGrossSal').value == ''){
          a=0;
        }else{
          a=parseFloat(document.getElementById('SalaryEmpGrossSal').value);
        }
        if(document.getElementById('SalaryEmpPf').value == ''){
          b=0;
        }else{
          b= parseFloat(document.getElementById('SalaryEmpPf').value);
        }
        if(document.getElementById('SalaryEmpEsi').value == ''){
          c=0;
        }else{
          c=parseFloat(document.getElementById('SalaryEmpEsi').value);
        }
        if(document.getElementById('SalaryEmpProfTax').value == ''){
          g=0;
        }else{
          g=parseFloat(document.getElementById('SalaryEmpProfTax').value);
        }
        if(document.getElementById('SalaryEmpIncTax').value == ''){
          e=0;
        }else{
          e=parseFloat(document.getElementById('SalaryEmpIncTax').value);
        }
        if(document.getElementById('SalaryEmpAdv').value == ''){
          f=0;
        }else{
          f=parseFloat(document.getElementById('SalaryEmpAdv').value);
        }
        
        

        d=Math.round(a-b-c-g-e-f);
        document.getElementById('SalaryEmpTakehome').value=d;
        $('#SalaryEmpTakehome').attr('readonly', true);
  }
  function getctc(){
    
      var a,b,c;
        if(document.getElementById('SalaryEmpGrossSal').value == ''){
          a=0;
        }else{
          a=parseFloat(document.getElementById('SalaryEmpGrossSal').value);
        }
        if(document.getElementById('SalaryEmprPf').value == ''){
          b=0;
        }else{
          b= parseFloat(document.getElementById('SalaryEmprPf').value);
        }
        if(document.getElementById('SalaryEmprEsi').value == ''){
          c=0;
        }else{
          c=parseFloat(document.getElementById('SalaryEmprEsi').value);
        }
        
        

        d=Math.round(a+b+c);
        document.getElementById('SalaryEmpCtc').value=d;
        $('#SalaryEmpCtc').attr('readonly', true);
    
  }

  function getgross_sal(){
    
      var a,b,c;
        if(document.getElementById('SalaryEmpBasic').value == ''){
          a=0;
        }else{
          a=parseFloat(document.getElementById('SalaryEmpBasic').value);
        }
        if(document.getElementById('SalaryEmpHra').value == ''){
          b=0;
        }else{
          b= parseFloat(document.getElementById('SalaryEmpHra').value);
        }
        if(document.getElementById('SalaryEmpConAll').value == ''){
          c=0;
        }else{
          c=parseFloat(document.getElementById('SalaryEmpConAll').value);
        }
        if(document.getElementById('SalaryEmpCommAll').value == ''){
          e=0;
        }else{
          e=parseFloat(document.getElementById('SalaryEmpCommAll').value);
        }
        if(document.getElementById('SalaryEmpSplAll').value == ''){
          f=0;
        }else{
          f=parseFloat(document.getElementById('SalaryEmpSplAll').value);
        }
        

        d=Math.round(a+b+c+e+f);
        document.getElementById('SalaryEmpGrossSal').value=d;
        $('#SalaryEmpGrossSal').attr('readonly', true);
        getctc();
        takehome();
  }

  function loadempsbycat(str){
    if(str != ''){
      $.get("<?php echo SITE; ?>dashboard/loadempsbycat/"+str,function(data){
        $("#SearchEmployeeId").html(data);
      });
    }
  }

  function loadempsbydes(str){
    if(str != ''){
      $.get("<?php echo SITE; ?>dashboard/loadempsbydes/"+str,function(data){
        $("#SearchEmployeeId").html(data);
      });
    }
  }

  function loadempdata(){
    var str=document.getElementById("SearchEmployeeId").value;
    if(str != ""){
      $.get("<?php echo SITE; ?>dashboard/loadempsdata/"+str,function(data){
        $(".employeedetail").html(data);
        $('#SalaryEmpName').attr('readonly', true);
        /*var res = data.split("****");
        $("#SalaryEmpName").val(res[0]);
        $("#SalaryEmpId").val(res[1]);*/
      });
    }else{
      $("#divloadempdata").html("");
    }
  }
</script>