<?php //debug($data);
$monthNum  = $data['SalaryDetail']['month'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
?>
<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>"Payslip"</title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

	<style type="text/css">
		.top {
			  border-top: thin solid;
			  border-color: black;
			}

			.bottom {
			  border-bottom: thin solid;
			  border-color: black;
			}

			.left {
			  border-left: thin solid;
			  border-color: black;
			}

			.right {
			  border-right: thin solid;
			  border-color: black;
			}
	</style>

</head>
<body onload="window.print();">
	<!-- <div id="payslipMenu">
		<input type="submit" class="printButton" value="{% trans "Print now" %}" />
		<form action="." method="post" enctype="multipart/form-data">
			{% csrf_token %}
			{{ form.as_p }}
            <input type="submit" name="download" value="{% trans "Get PDF" %}" />
		</form>
		<a href="{% url "payslip_generator" %}">{% trans "Clear payslip" %}</a>
	</div> -->
	<table border="1" width="100%">
		<thead>
			<tr>
				<th colspan="4">LUMINOUS INFOWAYS PVT. LTD. - PAYSLIP</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2">
					<p> EMPLOYEE'S NAME:&nbsp;<?php echo $data['SalaryDetail']['emp_name'];?> </p>
					<p> DESIGNATION:&nbsp;<?php echo $data['Designation']['name'];?></p>
					<!-- <p> DEPARTMENT:&nbsp;<?//php echo $data['SalaryDetail']['emp_name'];?> </p> -->
					<p> EMPLOYEE CODE:&nbsp;<?php echo $data['Employee']['employee_id'];?></p>
					<p> MONTHLY SALARY:&nbsp;RS.<?php echo $data['SalaryDetail']['emp_gross_sal']?>/-</p>
				</td>
				<td colspan="2">
					<p> FOR THE MONTH:&nbsp;<?php echo $monthName.','.$data['SalaryDetail']['year'];?> </p>
					<p> TOTAL DAYS:&nbsp;</p>
					<p> DAYS PAID:&nbsp;<?php echo $data['SalaryDetail']['no_of_days'];?> </p>
					<p> LEAVES AVAILED:&nbsp;</p>
				</td>
			</tr>
			<tr>
			<td colspan="4">
			<table width="100%">
			<tr class="top bottom left right">
				<td><strong>EARNINGS</strong></td>
				<td><strong>AMOUNT</strong></td>
				<td><strong>DEDUCTIONS</strong></td>
				<td><strong>AMOUNT</strong></td>
			</tr>
			<tr>
				<td>Basic</td>
				<td><?php echo $data['SalaryDetail']['emp_basic'];?></td>
				<td>ESI CONTRIBUTION</td>
				<td><?php echo $data['SalaryDetail']['emp_esi'];?></td>
			</tr>
			<tr>
				<td>HRA</td>
				<td><?php echo $data['SalaryDetail']['emp_hra'];?></td>
				<td>PF CONTRIBUTION</td>
				<td><?php echo $data['SalaryDetail']['emp_pf'];?></td>
			</tr>
			<tr>
				<td>CONVEYANCE ALLOWANCE</td>
				<td><?php echo $data['SalaryDetail']['emp_con_all'];?></td>
				<td>PROFESSIONAL TAX</td>
				<td><?php echo $data['SalaryDetail']['emp_prof_tax'];?></td>
			</tr>
			<tr>
				<td>COMMITMENT ALLOWANCE</td>
				<td><?php echo $data['SalaryDetail']['emp_commit_all'];?></td>
				<td>SALARY ADVANCE</td>
				<td><?php echo $data['SalaryDetail']['emp_adv'];?></td>
			</tr>
			<tr>
				<td>COMMUNICATION ALLOWANCE</td>
				<td><?php echo $data['SalaryDetail']['emp_comm_all'];?></td>
				<td>TDS</td>
				<td><?//php echo $data['SalaryDetail']['emp_pf'];?></td>
			</tr>
			<tr>
				<td>SPECIAL ALLOWANCE</td>
				<td><?php echo $data['SalaryDetail']['emp_spl_all'];?></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>GROSS EARNINGS</td>
				<td><?php echo $data['SalaryDetail']['emp_gross_sal'];?></td>
				<td>TOTAL DEDUCTIONS</td>
				<td></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong>NET PAY</strong>
				</td>
				<td colspan="2">
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p> &nbsp;0=>     POOR PERFORMER </p>
					<p> &nbsp;1=>     AVERAGE PERFORMER</p>
				</td>
				<td colspan="2">
					<p> &nbsp;2=> 	  GOOD PERFORMER </p>
					<p> &nbsp;3=> 	  EXCELLENT PERFORMER</p>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<p>NOTE:-</p>
					<p>1.LIPL reserves the right to alter, append or withdraw the benefits extended either in part or in full based on management’s discretion.</p>
					<p>2.This is a computer generated document and does not require signatures.</p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>