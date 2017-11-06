<?php //debug($data);exit;?>
<?php echo $this->Form->create('Salary');?>
<?php echo $this->Form->input('emp_id',array('type'=>'hidden','class'=> 'tbox','label'=>false,'div'=>false,'value'=>isset($data['Employee']['id'])?$data['Employee']['id']:$data['Salary']['emp_id'])); ?> 
<?php echo $this->Form->input('id',array('type'=>'hidden','class'=> 'tbox','label'=>false,'div'=>false,'value'=>isset($data['Salary']['id'])?$data['Salary']['id']:'')); ?>
<fieldset>
  <legend>Employee Details</legend>
<div class="col-md-6">
<fieldset>
  <legend>Gross</legend>
        <div class="form-group">
            <label class="control-label">Employee Name</label>
            <?php echo $this->Form->input('emp_name',array('type' =>'text','class'=>'form-control','div'=>false,'label'=>false,'required'=>'required','value'=>isset($data['Employee']['name'])?$data['Employee']['name']:$data['Salary']['emp_name']));
            ?> 
            <!-- <input class="form-control"> -->
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
        <div class="form-group">
            <label class="control-label">Working Days</label>
            <?php echo $this->Form->input('no_of_days',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','value'=>isset($data['Salary']['no_of_days'])?$data['Salary']['no_of_days']:''));
            ?> 
            <!-- <input class="form-control"> -->
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
        <div class="form-group">
            <label class="control-label">Basic</label>
            <?php echo $this->Form->input('emp_basic',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()",'value'=>isset($data['Salary']['emp_basic'])?$data['Salary']['emp_basic']:''));
            ?> 
            <!-- <input class="form-control"> -->
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
   <div class="form-group col-md-4">
      <label class="control-label">% of basic</label>
      <?php echo $this->Form->input('basic_percentage',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"gethra(this.value)",'value'=>isset($data['Salary']['basic_percentage'])?$data['Salary']['basic_percentage']:''));
      ?> 
  </div>
  <div class="form-group col-md-8">
      <label class="control-label">HRA</label>
      <?php echo $this->Form->input('emp_hra',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['emp_hra'])?$data['Salary']['emp_hra']:''));
      ?> 
  </div>
  <div class="form-group">
      <label class="control-label">Conveyance  Allowance</label>
      <?php echo $this->Form->input('emp_con_all',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()",'value'=>isset($data['Salary']['emp_con_all'])?$data['Salary']['emp_con_all']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
        <div class="form-group">
            <label class="control-label">Communication Allowance</label>
            <?php echo $this->Form->input('emp_comm_all',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()",'value'=>isset($data['Salary']['emp_comm_all'])?$data['Salary']['emp_comm_all']:''));
            ?> 
            <!-- <input class="form-control"> -->
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
        <div class="form-group">
            <label class="control-label">Special Allownce</label>
            <?php echo $this->Form->input('emp_spl_all',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getgross_sal()",'value'=>isset($data['Salary']['emp_spl_all'])?$data['Salary']['emp_spl_all']:''));
            ?> 
            <!-- <input class="form-control"> -->
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
  </fieldset>
  <div class="form-group">
      <label class="control-label">GROSS Salary</label>
      <?php echo $this->Form->input('emp_gross_sal',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','placeholder'=>'Basic+HRA+Conveyance+Communication+Special','value'=>isset($data['Salary']['emp_gross_sal'])?$data['Salary']['emp_gross_sal']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group col-md-4">
      <label class="control-label">% of Gross</label>
      <?php echo $this->Form->input('gross_percentage',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getcommit_all(this.value)",'value'=>isset($data['Salary']['gross_percentage'])?$data['Salary']['gross_percentage']:''));
      ?> 
  </div>
  <div class="form-group col-md-8">
      <label class="control-label">Commitment allowance</label>
      <?php echo $this->Form->input('emp_commit_all',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['emp_commit_all'])?$data['Salary']['emp_commit_all']:''));
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
      <?php echo $this->Form->input('empr_percentage_pf',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getempr_pf(this.value)",'value'=>isset($data['Salary']['empr_percentage_pf'])?$data['Salary']['empr_percentage_pf']:''));
      ?> 
  </div>                                  
  <div class="form-group col-md-8">
      <label class="control-label">Employer PF</label>
      <?php echo $this->Form->input('empr_pf',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['empr_pf'])?$data['Salary']['empr_pf']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group col-md-4">
      <label class="control-label">% of Gross</label>
      <?php echo $this->Form->input('empr_percentage_gross',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getempr_gross(this.value)",'value'=>isset($data['Salary']['empr_percentage_gross'])?$data['Salary']['empr_percentage_gross']:''));
      ?> 
  </div>
  <div class="form-group col-md-8">
      <label class="control-label">ESI (Employer)</label>
      <?php echo $this->Form->input('empr_esi',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['empr_esi'])?$data['Salary']['empr_esi']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group">
      <label class="control-label">CTC</label>
      <?php echo $this->Form->input('emp_ctc',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','placeholder'=>'Gross+PF+ESIC','value'=>isset($data['Salary']['emp_ctc'])?$data['Salary']['emp_ctc']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
</fieldset>
<fieldset>
  <legend>Take Home</legend>
  <div class="form-group col-md-4">
      <label class="control-label">% of Basic</label>
      <?php echo $this->Form->input('emp_percentage_pf',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getemp_pf(this.value)",'value'=>isset($data['Salary']['emp_percentage_pf'])?$data['Salary']['emp_percentage_pf']:''));
      ?> 
  </div>
  <div class="form-group col-md-8">
      <label class="control-label">Employee PF</label>
      <?php echo $this->Form->input('emp_pf',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['emp_pf'])?$data['Salary']['emp_pf']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group col-md-4">
      <label class="control-label">% of Gross</label>
      <?php echo $this->Form->input('emp_percentage_gross',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"getemp_gross(this.value)",'value'=>isset($data['Salary']['emp_percentage_gross'])?$data['Salary']['emp_percentage_gross']:''));
      ?> 
  </div>
  <div class="form-group col-md-8">
      <label class="control-label">ESIC (Employee)</label>
      <?php echo $this->Form->input('emp_esi',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','value'=>isset($data['Salary']['emp_esi'])?$data['Salary']['emp_esi']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group">
      <label class="control-label">Proffessional Tax (PT)</label>
      <?php echo $this->Form->input('emp_prof_tax',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"takehome()",'value'=>isset($data['Salary']['emp_prof_tax'])?$data['Salary']['emp_prof_tax']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group">
      <label class="control-label">Income Tax (IT)</label>
      <?php echo $this->Form->input('emp_inc_tax',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','onkeyup'=>"takehome()",'value'=>isset($data['Salary']['emp_inc_tax'])?$data['Salary']['emp_inc_tax']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
  <div class="form-group">
      <label class="control-label">Advance</label>
      <?php echo $this->Form->input('emp_adv',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'onkeyup'=>"takehome()",'value'=>isset($data['Salary']['emp_adv'])?$data['Salary']['emp_adv']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
</fieldset>
<div class="form-group">
      <label class="control-label">Take Home</label>
      <?php echo $this->Form->input('emp_takehome',array('type' =>'text','class'=>'form-control numeric','div'=>false,'label'=>false,'required'=>'required','readonly','placeholder' =>'Gross-employeePF-ESIC-PT-IT-Advance','value'=>isset($data['Salary']['emp_takehome'])?$data['Salary']['emp_takehome']:''));
      ?> 
      <!-- <input class="form-control"> -->
      <!-- <p class="help-block">Example block-level help text here.</p> -->
  </div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
<button type="reset" class="btn btn-success">Reset</button>
</fieldset>