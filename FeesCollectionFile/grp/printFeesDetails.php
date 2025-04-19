<?php
@session_start();
include '../../ajaxconfig.php';

if (isset($_POST["fees_ids"])) $fees_ids = $_POST["fees_ids"];
if (isset($_POST["pay_fees_id"])) $pay_fees_id = $_POST["pay_fees_id"];
if (isset($_POST["student_id"])) $student_id = $_POST["student_id"];
if (isset($_POST["receipt_date"])) $receipt_date = $_POST["receipt_date"];
if (isset($_POST["receipt_number"])) $receipt_number = $_POST["receipt_number"];
if (isset($_POST["academic_year"])) $academic_year = $_POST["academic_year"];
if (isset($_POST["mergedParticularsArray"])) $mergedParticularsArray = $_POST["mergedParticularsArray"];
if (isset($_POST["mergedAmountArray"])) $mergedAmountArray = $_POST["mergedAmountArray"];

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
}

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

// Fetch student details
$qry = $mysqli->query("SELECT stdc.student_name, stdc.admission_number, stdc.section, sc.standard 
    FROM student_creation stdc 
    JOIN student_history sh ON sh.student_id = stdc.student_id  
    JOIN standard_creation sc ON sh.standard = sc.standard_id 
    WHERE sh.student_id = '$student_id' AND stdc.status=0 AND stdc.school_id='$school_id' AND sh.academic_year='$year_id'");

$row = $qry->fetch_assoc();
$student_name = $row["student_name"];
$admission_number = $row["admission_number"];
$standard = $row["standard"];
$section = $row["section"];

// Fetch school info
$getbrc = $mysqli->query("SELECT sc.school_name, sc.district, sc.address1, sc.address2, sc.pincode, sc.contact_number, sc.email_id, sc.school_logo, stc.state 
    FROM school_creation sc 
    JOIN state_creation stc ON sc.state = stc.id 
    WHERE sc.status = 0 AND school_id = '$school_id'");
$schoolInfo = $getbrc->fetch_assoc();
$school_name = $schoolInfo["school_name"];
$address1 = $schoolInfo["address1"];
$address2 = $schoolInfo["address2"];
$district = $schoolInfo["district"];
$state = $schoolInfo["state"];
$pincode = $schoolInfo["pincode"];
$contact_number = $schoolInfo["contact_number"];
$email_id = $schoolInfo["email_id"];
$school_logo = $schoolInfo["school_logo"];
?>

<head>
    <style>
        th {
            text-align: center;
            font-weight: bold;
        }

        #dettable tr.last-row td {
        line-height: 3.5;
        /* margin-top: 30px; */
    }
    </style>
</head>
<div class="approvedtablefield">
    <?php
    $copyLabels = ['Student Copy', 'School Copy'];
    $pay_mode = '';
    foreach ($copyLabels as $copyLabel) {
    ?>
        <div id="dettable" style="border:1px solid black;margin: 20px auto; padding: 10px;">
            <table rules="all" style="width: 100%; border-style: double; border: 1px solid black; margin: auto;">
                <tr>
                    <td><img src="uploads/school_creation/<?php echo $school_logo; ?>" height="50px" width="50px" alt="LOGO" style="padding: 5px;"></td>
                    <td style="text-align: center;">
                        <b><?php echo $school_name; ?></b><br>
                        <?php echo "$address1, $address2, $district,<br>$state - $pincode"; ?><br>
                        ☎ - <?php echo $contact_number; ?> ✉ - <?php echo $email_id; ?>
                    </td>
                    <td style="padding: 5px;">
                        Receipt Number: <?php echo $receipt_number; ?><br>
                        Manual Rcpt.No:<br>
                        (<?php echo $copyLabel; ?>)
                    </td>

                </tr>
            </table>
            <?php
            if (strpos($receipt_number, 'LAST') === 0) {
                echo '<p style="text-align: center; font-weight: bold;">Last Year Fees</p>';
            } else {
                echo '<p style="text-align: center; font-weight: bold;">Group Fees</p>';
            }
            ?>

            <table style="width: 100%; margin-bottom: 10px;">
                <tr>
                    <td>Admission Number: <?php echo $admission_number; ?></td>
                    <td style="text-align: right;">Date: <?php echo $receipt_date; ?></td>
                </tr>
                <tr>
                    <td>Student Name: <?php echo $student_name; ?></td>
                    <td style="text-align: right;">Standard / Section: <?php echo "$standard - $section"; ?></td>
                </tr>
            </table>

            <table rules="all" style="width: 100%; border-style: double; border: 1px solid black; margin: auto;">
                <tr>
                    <th>SI.No</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                </tr>
                <?php
                $totalamnt = 0;
                $a = 1;

                if (strpos($receipt_number, 'LAST') === 0) {
                    $query = $mysqli->query("SELECT 
                    CASE 
                        WHEN(lfd.fees_table_name = 'grptable') THEN gcf.grp_particulars 
                        WHEN(lfd.fees_table_name = 'extratable') THEN ecaf.extra_particulars 
                        WHEN(lfd.fees_table_name = 'amenitytable') THEN aff.amenity_particulars 
                        WHEN(lfd.fees_table_name = 'transport') THEN acp.particulars 
                    END as particulars, 
                    lfd.fee_received,
                    lfds.payment_mode
                FROM last_year_fees lf 
                JOIN last_year_fees_details lfd ON lf.id = lfd.admission_fees_ref_id 
                JOIN last_year_fees_denomination lfds ON lf.id = lfds.admission_fees_ref_id 
                LEFT JOIN group_course_fee gcf ON lfd.fees_table_name = 'grptable' AND lfd.fees_id = gcf.grp_course_id 
                LEFT JOIN extra_curricular_activities_fee ecaf ON lfd.fees_table_name = 'extratable' AND lfd.fees_id = ecaf.extra_fee_id 
                LEFT JOIN amenity_fee aff ON lfd.fees_table_name = 'amenitytable' AND lfd.fees_id = aff.amenity_fee_id 
                LEFT JOIN area_creation_particulars acp ON lfd.fees_table_name = 'transport' AND lfd.fees_id = acp.particulars_id 
                WHERE lf.id = '$fees_ids' AND lfd.fee_received != '0'");
                } else {
                    $query = $mysqli->query("SELECT 
                    CASE 
                        WHEN(afd.fees_table_name = 'grptable') THEN gcf.grp_particulars 
                        WHEN(afd.fees_table_name = 'extratable') THEN ecaf.extra_particulars 
                        WHEN(afd.fees_table_name = 'amenitytable') THEN aff.amenity_particulars 
                    END as particulars, 
                    afd.fee_received ,
                    afds.payment_mode
                FROM admission_fees af 
                JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
                LEFT JOIN admission_fees_denomination afds ON af.id = afds.admission_fees_ref_id 
                LEFT JOIN group_course_fee gcf ON afd.fees_table_name = 'grptable' AND afd.fees_id = gcf.grp_course_id 
                LEFT JOIN extra_curricular_activities_fee ecaf ON afd.fees_table_name = 'extratable' AND afd.fees_id = ecaf.extra_fee_id 
                LEFT JOIN amenity_fee aff ON afd.fees_table_name = 'amenitytable' AND afd.fees_id = aff.amenity_fee_id 
                WHERE af.id = '$fees_ids' AND afd.fee_received != '0'");
                }
                $pay_mode = '';
                while ($row = $query->fetch_assoc()) {
                    echo "<tr>
                    <td>{$a}</td>
                    <td>{$row['particulars']}</td>
                    <td style='text-align:right;'> " . ($row['fee_received']) . "</td>
                </tr>";
                    $totalamnt += $row['fee_received'];
                    $a++;
                    if ($row['payment_mode'] == 'cash_payment') {
                        $pay_mode = 'Cash';
                    } else if ($row['payment_mode'] == 'cheque') {
                        $pay_mode = 'Cheque';
                    } else if ($row['payment_mode'] == 'neft') {
                        $pay_mode = 'Bank Transfer';
                    } else {
                        $pay_mode = '';
                    }
                }
                ?>
                <p style="width: 33%;">Payment Mode: <?php echo $pay_mode; ?></p>
                <tr>
                    <td colspan="2" style="text-align:right;"><b>Total Amount:</b></td>
                    <td style="text-align:right;"><b> <?php echo ($totalamnt); ?></b></td>
                </tr>
                <tr>
                    <td colspan="3"> Amount in words: <?php echo AmountInWords($totalamnt); ?> Only.</td>
                </tr>
                <tr class="last-row">
                    <td colspan="2" style="text-align: justify;"> Seal </td>
                    <td style="text-align: center;"> Signature </td>
                </tr>
            </table>


        </div>
        <?php if ($copyLabel == 'Student Copy') { ?>
            <hr style="border-top: 2px dashed #000; margin-top: 40px; margin-bottom: 40px;">
        <?php } ?>
    <?php } ?>
</div>

<button type="button" name="printpurchase" onclick="poprint()" id="printpurchase" class="btn btn-primary" style="display:none">Print</button>

<script type="text/javascript">
    function poprint() {
        var Bill = document.getElementById("dettable").innerHTML;
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write(Bill);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
    document.getElementById("printpurchase").click()
</script>