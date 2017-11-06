<div class="box-header">
    <div class="row">
        <div class="col-sm-8" align="left">            
            <h3 class="box-title">Salary Report</h3>
        </div>
    </div>
</div>
<?php //debug($data);
if(is_array($data) && count($data)>0){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#listingDiv',
        'evalScripts'               => true,
        //'before'                    => '$("#lodding_image").show();',
        //'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'Dashboard',
            'action'                => 'indexAjax',         
        )
    ));         
    echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
    echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null,array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Js->writeBuffer();
?>
        </ul>
    </div>
    <div class="col-sm-7 text-right" style="padding-top:30px;">
<?php
echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>
    </div>
</div>
<?php echo $this->Form->create('SalaryDetail',array('url'=>'/Dashboard/salarieprocess','admin'=>false));?>
<table id="example2" class="table table-bordered table-hover">
	<thead>
		<tr class="warning">
            <th><?php 
            if($this->Session->read('login_id') == 'accountadmin'){
                echo $this->Form->input('checkbox', array('type'=>'checkbox','label'=>false,'id'=>"selectAll",'class' => 'releasecheckboxbutton'));
            }else{
                echo $this->Form->input('checkbox', array('type'=>'checkbox','label'=>false,'id'=>"selectAll",'class' => 'checkboxbutton'));
            }
            ?>
            </th>
            <th>Sl. No.</th>
            <th>Employee Name</th>
			<th>Basic</th>
			<th>Gross Salary</th>
			<th>CTC</th>
            <th>Take Home</th>
            <th>Year</th>
            <th>Month</th>
            <th>Action By HR</th>
            <th>Action By Accounts</th>
            <th>Print Details</th>
		</tr>
	</thead>
	<tbody>
<?php
	$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
	foreach($data as $key=>$val){
?>	
		<tr>
            <td>
            <?php 
            if($this->Session->read('login_id') == 'accountadmin'){
                if(isset($val['SalaryDetail']['processed_by_accounts']) && $val['SalaryDetail']['processed_by_accounts']=='Y'){

                    }else{
                        echo $this->Form->input('checkbox.'.$rowCnt.'.id', array('type'=>'checkbox','class'=>'releasecheckboxbutton','label'=>false,'value'=>$val['SalaryDetail']['id'])); 
                        echo $this->Form->input('checkbox.'.$rowCnt.'.emp_id', array('type'=>'hidden','class'=>'releasecheckboxbutton','label'=>false,'value'=>$val['Salary']['emp_id'])); 
                    }
                
            }else{
                //echo $this->Form->create('SalaryDetail',array('url'=>'/Dashboard/salarieprocess','admin'=>false));
               if(isset($val['SalaryDetail']['id']) && $val['SalaryDetail']['id']!=''){
                   
               }else{
                    echo $this->Form->input('checkbox.'.$rowCnt.'.emp_id', array('type'=>'checkbox','class'=>'checkboxbutton','label'=>false,'value'=> $val['Salary']['emp_id'])); 
               }
           }
             ?>
            </td>
			<td><?php echo $rowCnt;?></td>
            <td><?php echo h($val['Salary']['emp_name'])?></td>
			<td><?php echo h($val['Salary']['emp_basic'])?></td>
			<td><?php echo h($val['Salary']['emp_gross_sal'])?></td>
			<td><?php echo h($val['Salary']['emp_ctc'])?></td>	
            <td><?php echo h($val['Salary']['emp_takehome'])?></td> 
            <td><?php echo h($val['SalaryDetail']['year'])?></td> 
            <td><?php echo h($val['SalaryDetail']['month'])?></td> 
            <td><?php 
            if(isset($val['SalaryDetail']['processed_by_hr']) && $val['SalaryDetail']['processed_by_hr']=='Y'){
                echo 'Salary Processed by Hr';
            }else{
                echo $this->Form->create('SalaryProcess',array('url'=>'/Dashboard/salarieprocess','admin'=>false));
                echo $this->Form->input('emp_id',array('type'=>'hidden','value'=> $val['Salary']['emp_id']));
                echo $this->Form->input('year',array('type'=>'hidden','value'=> $year));
                echo $this->Form->input('month',array('type'=>'hidden','value'=> $month));
                echo $this->Form->end(array('label'=>'Process','class'=>'btn btn-primary process-button','div'=>false,'onclick'=>'return confirm("Are you sure want to process this salary?")'));
                }?>
            </td> 
            <td>
              
                 <?php if(isset($val['SalaryDetail']['processed_by_accounts']) && $val['SalaryDetail']['processed_by_accounts']=='Y'){
                        echo 'Salary released by accounts';
                    }else{
                        if($this->Session->read('login_id') == 'accountadmin'){
                        echo $this->Form->create('SalaryRelease',array('url'=>'/Dashboard/salarieprocess','admin'=>false));
                        echo $this->Form->input('emp_id',array('type'=>'hidden','value'=> $val['Salary']['emp_id']));
                        echo $this->Form->input('id',array('type'=>'hidden','value'=> $val['SalaryDetail']['id']));
                        echo $this->Form->input('year',array('type'=>'hidden','value'=> $year));
                        echo $this->Form->input('month',array('type'=>'hidden','value'=> $month));
                        echo $this->Form->end(array('label'=>'Release Salary','class'=>'btn btn-primary release-button','div'=>false,'onclick'=>'return confirm("Are you sure want to release this salary?")'));
                }}?>              
            
            </td>	
            <td>
                <?php if(isset($val['SalaryDetail']['processed_by_accounts']) && $val['SalaryDetail']['processed_by_accounts']=='Y'){
                        echo $this->Html->link('PrintDetail', array('controller' => 'Dashboard','action'=>'salaryslip',$val['SalaryDetail']['id']),array('target' => '_blank','class'=>'btn btn-success'));
                        echo $this->Html->link('PrintPDF', '/printpdf/'.$year.$month.$val['SalaryDetail']['id'].'.pdf',array('target' => '_blank','class'=>'btn btn-success'));
                        /*echo $this->Form->create('PrintDetail',array('url'=>'/Dashboard/salaryslip','admin'=>false));
                        echo $this->Form->input('id',array('type'=>'hidden','value'=> $val['SalaryDetail']['id']));
                        echo $this->Form->input('year',array('type'=>'hidden','value'=> $year));
                        echo $this->Form->input('month',array('type'=>'hidden','value'=> $month));
                        echo $this->Form->end(array('label'=>'Print','class'=>'btn btn-success release-button','div'=>false));*/
                    }else{
                        echo 'In Progress';
                        }?>
            </td>						
		</tr>
<?php
		$rowCnt++;
	}
?>		
	</tbody>
</table>
            <?php   
                    echo $this->Form->input('year',array('type'=>'hidden','value'=> $year));
                    echo $this->Form->input('month',array('type'=>'hidden','value'=> $month));
                    if($this->Session->read('login_id') == 'accountadmin'){
                        echo $this->Form->end(array('label'=>'Release All','class'=>'btn btn-primary','div'=>false,'id'=>'releaseall','disabled' => 'disabled','onclick'=>'return confirm("Are you sure want to release this salary?")'));
                    }else{
                        echo $this->Form->end(array('label'=>'Process All','class'=>'btn btn-primary','div'=>false,'id'=>'processall','disabled' => 'disabled','onclick'=>'return confirm("Are you sure want to process this salary?")'));
                    }
                    
            ?>
<?php
}
?>
<script type="text/javascript">
  $('#selectAll').click(function (e) {
      $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
  });

    
    $(".checkboxbutton").click(function(){
        var anyBoxesChecked = false;
        $('.checkboxbutton').each(function() {
            if ($(this).is(":checked")) {
                anyBoxesChecked = true;
                $('#processall').prop('disabled', false);
                $('.process-button').prop('disabled', true);
                //alert($(this).is(":checked"));
            }
        });
     
        if (anyBoxesChecked == false) {
           $('#processall').prop('disabled', true);
           $('.process-button').prop('disabled', false);
          /*alert('Please select at least one checkbox');
          return false;*/
        } 
    });

    $(".releasecheckboxbutton").click(function(){
        var anyBoxesChecked = false;
        $('.releasecheckboxbutton').each(function() {
            if ($(this).is(":checked")) {
                anyBoxesChecked = true;
                $('#releaseall').prop('disabled', false);
                $('.release-button').prop('disabled', true);
                //alert($(this).is(":checked"));
            }
        });
     
        if (anyBoxesChecked == false) {
           $('#releaseall').prop('disabled', true);
           $('.release-button').prop('disabled', false);
          /*alert('Please select at least one checkbox');
          return false;*/
        } 
    });
  
</script>