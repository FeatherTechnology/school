<?php
include "../ajaxconfig.php";
@session_start();
if (isset($_SESSION["userid"])) {
    $school_id = $_SESSION["school_id"];
}
$academic_year = $_SESSION['academic_year'];
//get school name by using session id.
$getschoolDetailsQry = $mysqli->query("SELECT sc.school_name, sc.district, sc.address1, sc.address2, sc.pincode, sc.contact_number, sc.web_url, sc.school_logo, stc.state FROM school_creation sc JOIN state_creation stc ON sc.state = stc.id WHERE sc.status = 0 AND school_id = '$school_id' ");
while ($schoolInfo = $getschoolDetailsQry->fetch_assoc()) {
    $school_name     = $schoolInfo["school_name"];
    $address1  = $schoolInfo["address1"];
    $address2  = $schoolInfo["address2"];
    $district  = $schoolInfo["district"];
    $state     = $schoolInfo["state"];
    $pincode  = $schoolInfo["pincode"];
    $contact_number  = $schoolInfo["contact_number"];
    $web_url     = $schoolInfo["web_url"];
    $school_logo     = $schoolInfo["school_logo"];
}

if (isset($_POST['payFeesid'])) {
    $payFeesid = $_POST['payFeesid'];
}

$getPayFees = $connect->query("SELECT 
stdc.admission_number, 
stdc.student_name, 
stdc.section, 
sc.standard, 
af.receipt_no, 
af.receipt_date,
afds.payment_mode
FROM 
admission_fees af 
JOIN 
student_creation stdc ON af.admission_id = stdc.student_id 
JOIN 
student_history sh ON sh.student_id = stdc.student_id and sh.academic_year = '$academic_year'
JOIN 
standard_creation sc ON sh.standard = sc.standard_id 
JOIN 
admission_fees_details afd ON af.id = afd.admission_fees_ref_id
LEFT JOIN admission_fees_denomination afds ON af.id = afds.admission_fees_ref_id 
WHERE af.id = '$payFeesid' && afd.fee_received > 0 ");
$payfeesDetails = $getPayFees->fetch();


function AmountInWords($amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? '' : null;
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

        table,
        th,
        td {
            border: 1px solid black;
        }

        td {
            padding: 4px;
            text-align: left;
        }
    }

    #printReceiptTable td.first-row {
        line-height: 1.5;
    }

    #printReceiptTable tr.last-row td {
        line-height: 3.5;
        /* margin-top: 30px; */
    }
</style>

<?php
$copyLabels = ['Student Copy', 'School Copy'];
foreach ($copyLabels as $copyLabel) {
?>
    <div id="printReceiptTable">
        <table class="table table-bordered table-responsive">
            <tr>
                <td style="text-align: center;">
                    <img src="uploads/school_creation/<?php echo $school_logo; ?>" height="100px" width="100px" alt="Logo">
                </td>
                <td style="text-align: center;">
                    <b><?php if (isset($school_name)) echo $school_name; ?></b></br>
                    <?php
                    if (isset($address1)) echo $address1 . ', ';
                    if (isset($address2)) echo $address2 . ', ';
                    if (isset($district)) echo $district . ' - ';
                    if (isset($pincode)) echo $pincode . '</br>';                    
                    ?> 
                    <span style="margin-right: 5px;">&#x260E;</span> - <?php echo $contact_number; ?>
                    <span style="margin-right: 5px;">🌏︎</span>- <?php if (isset($web_url)) echo $web_url; ?>
                </td>
                <td style=" white-space: nowrap;"  class="first-row">
                    Receipt No. <?php echo $payfeesDetails['receipt_no']; ?></br>
                    Manual Rcpt.No </br><br>
                    (<?php echo $copyLabel; ?>)
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: none; border-right: none; border-left: none; text-align: center;">
                    <strong>Group Fees</strong>
                </td>
            </tr>
            <tr>
                <td colspan='2' style="border-bottom: none; border-right: none; border-top: none;">
                    Admission Number: <?php echo $payfeesDetails['admission_number']; ?>
                </td>
                <td style="border-bottom: none; border-left: none; border-top: none;">
                    Date: <?php echo date('d-m-Y', strtotime($payfeesDetails['receipt_date'])); ?>
                </td>
            </tr>
            <tr>
                <td colspan='2' style="border-top: none; border-right: none; border-bottom: none;">
                    Student Name: <b><?php echo $payfeesDetails['student_name']; ?></b>
                </td>
                <td style="border-top: none; border-left: none; border-bottom: none;white-space: nowrap;">
                    Standard / Section : <?php echo $payfeesDetails['standard']; ?> - <?php echo $payfeesDetails['section']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-right: none; border-left: none; border-bottom: none; ">
                    Payment Mode:
                    <?php
                    if ($payfeesDetails['payment_mode'] == 'cash_payment') {
                        echo 'Cash';
                    } else if ($payfeesDetails['payment_mode'] == 'cheque') {
                        echo 'Cheque';
                    } else if ($payfeesDetails['payment_mode'] == 'neft') {
                        echo 'Bank Transfer';
                    } else {
                        echo '';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th> Sl No. </th>
                <th> Particulars </th>
                <th> Amount </th>
            </tr>
            <?php
            $getPayFeesQry = $connect->query("SELECT 
        afd.fee_received,
        CASE WHEN(gcf.grp_particulars <>'') THEN gcf.grp_particulars 
             WHEN(ecaf.extra_particulars <> '') THEN ecaf.extra_particulars 
             WHEN(aff.amenity_particulars <> '') THEN aff.amenity_particulars 
        END as particulars   
        FROM admission_fees af 
        JOIN student_creation stdc ON af.admission_id = stdc.student_id 
        JOIN standard_creation sc ON stdc.standard = sc.standard_id 
        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
        LEFT JOIN group_course_fee gcf ON afd.fees_table_name = 'grptable' AND afd.fees_id = gcf.grp_course_id 
        LEFT JOIN extra_curricular_activities_fee ecaf ON afd.fees_table_name = 'extratable' AND afd.fees_id = ecaf.extra_fee_id 
        LEFT JOIN amenity_fee aff ON afd.fees_table_name = 'amenitytable' AND afd.fees_id = aff.amenity_fee_id 
        WHERE af.id = '$payFeesid' && afd.fee_received > 0; ");

            $i = 1;
            $totalAmnt = 0;
            while ($getpayFeesDetails = $getPayFeesQry->fetch()) {
                $totalAmnt += $getpayFeesDetails['fee_received'];
            ?>
                <tr>
                    <td style="text-align: center;"> <?php echo $i++; ?> </td>
                    <td> <?php echo $getpayFeesDetails['particulars']; ?> </td>
                    <td style="text-align:right;" > <?php echo $getpayFeesDetails['fee_received']; ?> </td>
                </tr>
            <?php } ?>
            <tr>
                <td> </td>
                <td> Total amount </td>
                <td style="text-align:right;"> <?php echo $totalAmnt; ?> </td>
            </tr>
            <tr>
                <td colspan="3"> Amount in words: <?php echo AmountInWords($totalAmnt); ?> Only. </td>
            </tr>
            <tr class="last-row">
                <td colspan="2" style="text-align: justify;"> Seal </td>
                <td style="text-align: bottom;"> Signature </td>
            </tr>
        </table>
    </div>
    <?php if ($copyLabel == 'Student Copy') { ?>
        <hr style="border-top: 2px dashed #000; margin-top: 40px; margin-bottom: 40px;">
    <?php } ?>
<?php } ?>