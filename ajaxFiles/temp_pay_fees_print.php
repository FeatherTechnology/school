<?php
include "../ajaxconfig.php";

if(isset($_POST['tempFeesid'])){
    $tempFeesid = $_POST['tempFeesid'];
}

$getTempFees = $connect->query("SELECT 
tas.temp_no, 
tas.temp_student_name, 
sc.standard, 
taf.ReceiptNo, 
taf.ReceiptDate
FROM 
temp_admission_fees taf 
JOIN 
temp_admission_student tas ON taf.TempAdmissionId = tas.temp_admission_id 
JOIN 
standard_creation sc ON tas.temp_standard = sc.standard_id 
JOIN 
temp_admissionfees_details tafd ON taf.id = tafd.TempAdmFeeRefId
WHERE taf.id = '$tempFeesid' && tafd.FeeReceived > 0;
");
$tempfeesDetails = $getTempFees->fetch();


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
?>

<style type="text/css">
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        td {
            padding: 10px;
            text-align: left;
        }
    }

    #printReceiptTable td.first-row {
        line-height: 2.5;
    }
    
    #printReceiptTable tr.last-row td {
        line-height: 3.5;
        /* margin-top: 30px; */
    }
</style>

<div id="printReceiptTable">
    <table class="table table-bordered table-responsive">
    <tr>
        <td style="text-align: center;"> <img src="img/Logo.png" height="100px" width="100px" alt="Logo"> </td>
        <td style="text-align: center;"> VIDHYA PARTHI NATIONAL ACADEMY </br>
            SEELAPADI,Dindigul-624005 </br>
            <span style="margin-right: 5px;">&#x260E;</span> - 09597575922  <span style="margin-right: 5px;">&#x1F4E7;</span>- vpnacbse@gmail.com 
        </td>
        <td class="first-row"> Receipt No. <?php echo $tempfeesDetails['ReceiptNo'];?></br> 
            Manual Rcpt.No </br> 
            (Student copy)
        </td>
    </tr>
    <tr>
        <td colspan='2' style="border-bottom: none; border-right: none;">
            Admission Number: <?php echo $tempfeesDetails['temp_no'];?>
        </td>
        <td style="border-bottom: none; border-left: none;">
            Date: <?php echo date('d-m-Y',strtotime($tempfeesDetails['ReceiptDate']));?>
        </td>
    </tr>
    <tr>
        <td colspan='2' style="border-top: none; border-right: none;">
            Student Name: <?php echo $tempfeesDetails['temp_student_name'];?>
        </td>
        <td style="border-top: none; border-left: none;">
            Standard: <?php echo $tempfeesDetails['standard'];?>
        </td>
    </tr>
    <tr>
        <th>
            Sl No. 
        </th>
        <th>
            Particulars
        </th>
        <th>
            Amount 
        </th>
    </tr>
    <?php
    $getTempFeesQry = $connect->query("SELECT 
    tas.temp_no, 
    tas.temp_student_name, 
    tas.temp_standard, 
    sc.standard, 
    taf.ReceiptNo, 
    taf.ReceiptDate, 
    tafd.FeesTableName, 
    tafd.FeesId, 
    tafd.FeeReceived, 
    tafd.BalancetobePaid, 
    tafd.Scholarship,
    CASE WHEN(gcf.grp_particulars <>'') THEN gcf.grp_particulars ELSE CASE WHEN(ecaf.extra_particulars <> '') THEN ecaf.extra_particulars ELSE CASE WHEN(af.amenity_particulars <> '') THEN af.amenity_particulars END END END as particulars   
    FROM 
    temp_admission_fees taf 
    JOIN 
    temp_admission_student tas ON taf.TempAdmissionId = tas.temp_admission_id 
    JOIN 
    standard_creation sc ON tas.temp_standard = sc.standard_id 
    JOIN 
    temp_admissionfees_details tafd ON taf.id = tafd.TempAdmFeeRefId 
    LEFT JOIN 
    group_course_fee gcf ON tafd.FeesTableName = 'grptable' AND tafd.FeesId = gcf.grp_course_id 
    LEFT JOIN 
    extra_curricular_activities_fee ecaf ON tafd.FeesTableName = 'extratable' AND tafd.FeesId = ecaf.extra_fee_id 
    LEFT JOIN 
    amenity_fee af ON tafd.FeesTableName = 'amenitytable' AND tafd.FeesId = af.amenity_fee_id 
    WHERE taf.id = '$tempFeesid' && tafd.FeeReceived > 0;
    ");
    
    $i = 1;
    $totalAmnt = 0;
    while($getpayFeesDetails = $getTempFeesQry ->fetch()){
        $totalAmnt = $totalAmnt + $getpayFeesDetails['FeeReceived'];
        ?>
    <tr>
        <td> <?php echo $i++; ?> </td>
        <td> <?php echo $getpayFeesDetails['particulars'];?> </td>
        <td> <?php echo $getpayFeesDetails['FeeReceived'];?> </td>
    </tr>
    
    <?php
    } ?>
    <tr>
        <td> </td>
        <td> Total amount </td>
        <td> <?php echo $totalAmnt; ?> </td>
    </tr>
    <tr>
        <td colspan="3"> Amount in words: <?php echo AmountInWords($totalAmnt); ?> /- </td>
    </tr>
    <tr class="last-row">
        <td colspan="2" style="text-align: justify;">
            Seal 
        </td>
        <td style="text-align: center;"> 
            Signature 
        </td>
    </tr>
    </table>
</div>