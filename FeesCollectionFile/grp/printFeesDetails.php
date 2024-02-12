<?php
@session_start();
include '../../ajaxconfig.php';

if(isset($_POST["fees_ids"])){
	$fees_ids=$_POST["fees_ids"]; 
}
if(isset($_POST["pay_fees_id"])){
	$pay_fees_id=$_POST["pay_fees_id"]; 
}
if(isset($_POST["student_id"])){
	$student_id=$_POST["student_id"]; 
}
if(isset($_POST["receipt_date"])){
	$receipt_date=$_POST["receipt_date"]; 
}
if(isset($_POST["receipt_number"])){
	$receipt_number=$_POST["receipt_number"]; 
}
if(isset($_POST["academic_year"])){
	$academic_year=$_POST["academic_year"]; 
}
if(isset($_POST["mergedParticularsArray"])){
	$mergedParticularsArray=$_POST["mergedParticularsArray"]; 
} 
if(isset($_POST["mergedAmountArray"])){
	$mergedAmountArray=$_POST["mergedAmountArray"]; 
}
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
    // $academic_year = $_SESSION["academic_year"];
} 
// Function to convert number to words
function AmountInWords($amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
        ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
        ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
    " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
    return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}												

$qry =$mysqli->query("SELECT stdc.student_name, stdc.admission_number, stdc.section, sc.standard FROM student_creation stdc JOIN standard_creation sc ON stdc.standard = sc.standard_id WHERE stdc.student_id = '$student_id' AND stdc.status=0 AND stdc.school_id='$school_id' AND stdc.year_id='$year_id'"); 
// SELECT * FROM student_creation WHERE student_id = '$student_id' AND status=0
while($row=$qry->fetch_assoc()){
	$student_name=$row["student_name"]; 	
	$admission_number=$row["admission_number"];
	$standard=$row["standard"];
	$section=$row["section"];
} 

$getbrc=$mysqli->query("SELECT * FROM school_creation WHERE status = 0 AND school_id = '$school_id' AND FIND_IN_SET('$year_id', year_id) > 0");
// SELECT * FROM school_creation WHERE status=0 AND school_id='$school_id' AND year_id='$year_id'
while ($brc=$getbrc->fetch_assoc()) {
	$address1  =$brc["address1"];
	$address2  =$brc["address2"];
	$district  =$brc["district"];
	$state     =$brc["state"];
	$email_id     =$brc["email_id"];
	$school_name     =$brc["school_name"]; 
} 
?>

<head>
<style type="text/css">
	th{
		text-align: center;
		font-weight: bold;
	}
</style>
</head>

<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;margin: auto;">

<table rules="all" style="width: 100%;border-style: double;border: 1px solid black;margin: auto;">
	<tr>
	
		<td><img src="img/Logo.png" height="50px" width="50px" alt="testing"></td>
		<td style="text-align: center;"><b style="font-size:20px;"><?php echo $school_name;?></b><br><?php echo $address1;?>&nbsp;&nbsp;<?php echo $address2; ?> &nbsp;<?php echo $district; ?>&nbsp;&nbsp;
		<br><span class="icon-mail"></span><?php echo $email_id;?>			
		</td>
		<td>
			Receipt Number: <?php echo $receipt_number; ?><br>
			Manual Rcpt.No:<BR>
			(Student Copy)
		</td>
	</tr>
</table>
<p style="float:right">Date: <?php echo $receipt_date; ?></p>
<p>Admission Number: <?php echo $admission_number; ?></p>
<p style="float:right">Standard & Section: <?php echo $standard ?> &amp; <?php echo $section; ?></p>
<p>Student Name: <?php echo $student_name; ?></p>

<br /><br />
<table rules="all" style="width: 100%;border-style: double;border: 1px solid black;margin: auto;">
	<tr>
		<th style="background-color: white;color: black; text-align: left;">SI.No</th>
		<th style="background-color: white;color: black; text-align: left;">Particulars</th>
		<th style="background-color: white;color: black; text-align: left;">Amount</th>
	</tr>
	<tr>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;"><?php echo 1; ?></td>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;"><?php echo $mergedParticularsArray; ?></td>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;"><?php echo $mergedAmountArray; ?></td>
	</tr>
	<tr>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;"></td>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;">Total</td>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;"><?php echo $mergedAmountArray; ?></td>
	</tr>
	<tr>
	<td colspan="3">Amount In Words: <span id="amountInWords"><?php echo AmountInWords($mergedAmountArray) . ' Rupees Only/-'; ?></span></td>

	</tr>
</table><br><p style="float:right">Signature</p>
<p>Seal</p>

</div>
</div>
				
<button type="button" name="printpurchase" onclick="poprint()" id="printpurchase" class="btn btn-primary">Print</button>

<script type="text/javascript">
function poprint(){
var Bill = document.getElementById("dettable").innerHTML;
var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write(Bill);
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
}
document.getElementById("printpurchase").click()
</script>
