<?php //debug($data);
if(isset($data) && is_array($data) && count($data)>0){


$monthNum  = $data['SalaryDetail']['month'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
$leave_deduction=round($data['SalaryDetail']['emp_gross_sal']-(($data['SalaryDetail']['emp_gross_sal']/$data['SalaryDetail']['no_of_days'])*$data['SalaryDetail']['days_paid']),2);
$total_deduction=$data['SalaryDetail']['emp_adv']+$data['SalaryDetail']['emp_prof_tax']+$data['SalaryDetail']['emp_pf']+$data['SalaryDetail']['emp_esi']+$leave_deduction;
  /**
  * Converting Currency Numbers to words currency format
   */
$netpay=$data['SalaryDetail']['emp_gross_sal']-$total_deduction;
function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Salary Slip</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/font-awesome.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/jquerysctipttop.css" media="all" /> -->
  <script src="<?php echo $this->webroot; ?>js/jquery.min.js"></script>
  <script src="<?php echo $this->webroot; ?>js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="js/simpleZoom.js"></script> -->
<style>
.table {border:2px solid #000;}
.table>tbody>tr>td {border-top:none; font-size: 12px;padding:5px;}  
.table>tbody>tr>th {border-bottom:1px solid #000; font-size: 12px;padding:5px;} 
.table>tbody>tr>td.dot{border-left:1px dashed #000;}
.table>tbody>tr>th>h4{font-weight:bold; padding-top:15px;}
.container{width: 850px;} 
</style>
</head>
<body onload="window.print();">
<div class="container">
<div class="row">
<div class="col-md-12">
<table class="table">
  <tr>
    <th><img src="<?php echo $this->webroot; ?>img/logo-(2).png" alt="new-logo.jpg" /></th>
    <th colspan="3"><h4>LUMINOUS INFOWAYS PVT. LTD. - PAYSLIP</h4></th>
  </tr>
 
  <tr style="border-bottom:none;">
    <td class="col-md-3"><b>EMPLOYEE'S NAME</b></td>
    <td class="col-md-3"><b><?php echo $data['SalaryDetail']['emp_name'];?></b></td>
    <td class="col-md-3"><b>FOR THE MONTH</b></td>
    <td class="col-md-3"><b><?php echo $monthName.','.$data['SalaryDetail']['year'];?></b></td>
  </tr>
  <tr>
    <td><b>DESIGNATION</b></td>
    <td><b><?php echo $data['Designation']['name'];?></b></td>
    <td><b>TOTAL DAYS</b></td>
    <td><b><?php echo $data['SalaryDetail']['no_of_days'];?></b></td>
  </tr>
  <tr>
    <td><b>DEPARTMENT</b></td>
    <td><b><?php echo $dep_name;?></b></td>
    <td><b>DAYS PAID</b></td>
    <td><b><?php echo $data['SalaryDetail']['days_paid'];?></b></td>
  </tr>
  <tr>
    <td><b>EMPLOYEE CODE<b></td>
    <td><b><?php echo $data['Employee']['employee_id'];?></b></td>
    <td><b>LEAVES AVAILED</b></td>
    <td><b><?php echo $data['SalaryDetail']['leaves_availed'];?></b></td>
  </tr>
  <tr>
    <td><b>MONTHLY SALARY</b></td>
    <td><b>Rs <?php echo $data['SalaryDetail']['emp_gross_sal']?>/-</b></td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <th>EARNINGS</th>
    <th>AMOUNT</th>
    <th>DEDUCTIONS</th>
    <th>AMOUNT</th>
  </tr>
  <tr>
    <td>BASIC</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_basic'];?></td>
    <td class="dot">ESI CONTRIBUTION</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_esi'];?></td>
  </tr>
  <tr>
    <td class="dot">HRA</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_hra'];?></td>
    <td class="dot">PF CONTRIBUTION</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_pf'];?></td>
  </tr>
  <tr>
    <td class="dot">CONVEYANCE ALLOWANCE</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_con_all'];?></td>
    <td class="dot">PROFESSIONAL TAX</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_prof_tax'];?></td>
  </tr>
  <tr>
    <td class="dot">COMMITMENT ALLOWANCE</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_commit_all'];?></td>
    <td class="dot">SALARY ADVANCE</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_adv'];?></td>
  </tr>
  <tr>
    <td class="dot">COMMUNICATION ALLOWANCE</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_comm_all'];?></td>
    <td class="dot">TDS</td>
    <td class="dot"></td>
  </tr>
  <tr>
    <td class="dot">SPECIAL ALLOWANCE</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_spl_all'];?></td>
    <td class="dot">LEAVE DEDUCTION</td>
    <td class="dot"><?php echo $leave_deduction;?></td>
  </tr>
  <tr>
    <td class="dot">GROSS EARNINGS</td>
    <td class="dot"><?php echo $data['SalaryDetail']['emp_gross_sal'];?></td>
    <td class="dot">TOTAL DEDUCTIONS</td>
    <td class="dot"><?php echo $total_deduction;?></td>
  </tr>
  <tr>
    <th style="text-align:left;">NET PAY</th>
    <th colspan="3" style="text-align:left;"><?php echo $data['SalaryDetail']['emp_gross_sal']-$total_deduction;?></th>
  </tr>
  <tr>
    <th style="text-align:left;" colspan="2">In Words: <?php echo strtoupper(getIndianCurrency($netpay));?> ONLY</th>
    <th style="text-align:left;" colspan="2">HR DEPARTMENT-0674-2304010</th>
    
  </tr>
  <tr>
    <th colspan="4">PERFORMANCE RATING PARAMETERS</th>
  </tr>
  <tr>
    <td colspan="2">0= POOR PERFORMER</td>
    <td colspan="2">2= GOOD PERFORMER</td>
  </tr>
  <tr>
    <td colspan="2">1= AVERAGE PERFORMER</td>
    <td colspan="2">3= EXCELLENT PERFORMER</td>
  </tr>
 
  <tr>
  <td colspan="4"><b>NOTE:</b><br>
  LIPL reserves the right to alter, append or withdraw the    benefits extended either in part or in full based on management's discretion.<br>
  This is a computer generated document and does not    require signatures.
  </td>
  </tr>
 
</table>
</div>
</div>
</div>


</body>
</html>
<?php }else{?>
<span style="color: red;text-align: center;">No Data Found</span>
<?php }?>