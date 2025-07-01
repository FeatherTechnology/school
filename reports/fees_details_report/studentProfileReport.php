<?php
include "../../ajaxconfig.php";
@session_start();

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
}

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
    $splityear = explode('-', $year_id);
    $last_year = intval($splityear[0] - 1) . '-' . intval($splityear[1] - 1);
}

// 1. Get Student Details
$getStudentDetailsQry = $connect->query("SELECT 
    stdc.student_name, stdc.admission_number, stdc.studentrollno, stdc.medium, 
    sh.studentstype, sh.standard, sc.standard AS standard_name,sh.extra_curricular, 
    stdc.section, stdc.year_id, stdc.school_id, stdc.facility, sh.academic_year ,sh.transportarearefid
FROM student_creation stdc 
JOIN student_history sh ON stdc.student_id = sh.student_id 
JOIN standard_creation sc ON sh.standard = sc.standard_id 
WHERE stdc.student_id = '$student_id' AND sh.academic_year = '$year_id'");

$studentInfo = $getStudentDetailsQry->fetch();
$student_name = $studentInfo['student_name'];
$admission_number = $studentInfo['admission_number'];
$studentrollno = $studentInfo['studentrollno'];
$medium = $studentInfo['medium'];
$studentstype = $studentInfo['studentstype'];
$standard = $studentInfo['standard'];
$standard_name = $studentInfo['standard_name'];
$section = $studentInfo['section'];
$academic_year = $studentInfo['academic_year'];
$school_id = $studentInfo['school_id'];
$transportFacility = $studentInfo['facility'];
$extra_id = ($studentInfo['extra_curricular']) ? $studentInfo['extra_curricular'] : '0';
$transport_id = ($studentInfo['transportarearefid']) ? $studentInfo['transportarearefid'] : '0';
// 2. Build student_type condition
if ($studentstype == "1" || $studentstype == "2") {
    $student_type_cndtn = "(fm.student_type = '$studentstype' OR fm.student_type = '4')";
} else {
    $student_type_cndtn = "(fm.student_type = '$studentstype')";
}

// 3. Get total fees per particular
$totalFeesQry = $connect->query("
    SELECT af.amenity_particulars AS particular, SUM(af.amenity_amount) AS fee_collection
    FROM fees_master fm
    JOIN amenity_fee af ON af.fee_master_id = fm.fees_id
    JOIN student_history sh ON fm.standard = sh.standard
    WHERE fm.academic_year = '$academic_year' 
      AND fm.medium = '$medium' 
      AND $student_type_cndtn
      AND fm.standard = '$standard' 
      AND af.status = '1' 
      AND fm.school_id = '$school_id' 
      AND sh.student_id = '$student_id'
      AND sh.academic_year = '$academic_year'
");

$feeData = [];
while ($row = $totalFeesQry->fetch()) {
    $feeData[$row['particular']] = [
        'fee_collection' => $row['fee_collection'],
        'receipts' => []
    ];
}

// 4. Get fee paid details for each particular
$paidDetailsQry = $connect->query("
    SELECT af.amenity_particulars AS particular, afs.receipt_date, afs.receipt_no, 
           afd.fee_received AS fee_paid, afd.scholarship AS concession, afd.balance_tobe_paid AS balance
    FROM admission_fees afs
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id
    JOIN amenity_fee af ON af.amenity_fee_id = afd.fees_id
    WHERE afs.admission_id = '$student_id'
      AND afs.academic_year = '$academic_year'
      AND afd.fees_table_name = 'amenitytable'
     AND (afd.fee_received != 0 OR afd.scholarship != 0)
");

while ($row = $paidDetailsQry->fetch()) {
    $particular = $row['particular'];
    if (isset($feeData[$particular])) {
        $feeData[$particular]['receipts'][] = $row;
    }
}
$getExtraFeeDetailsQry = $connect->query("
    SELECT 
        ecaf.extra_fee_id,
        ecaf.extra_particulars AS particular,
        ecaf.extra_amount AS fee_collection
    FROM extra_curricular_activities_fee ecaf
    WHERE ecaf.extra_fee_id IN ($extra_id)
");

while ($row = $getExtraFeeDetailsQry->fetch()) {
    $particular = $row['particular'];
    $feeData[$particular] = [
        'fee_collection' => $row['fee_collection'],
        'receipts' => []
    ];
}

// Now fetch paid details for extra fees
$getExtraPaidQry = $connect->query("
    SELECT 
        afs.receipt_date,
        afs.receipt_no,
        ecaf.extra_particulars AS particular,
        afd.fee_received AS fee_paid,
        afd.scholarship AS concession,
        afd.balance_tobe_paid AS balance
    FROM admission_fees afs
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id
    JOIN extra_curricular_activities_fee ecaf ON ecaf.extra_fee_id = afd.fees_id
    WHERE afs.admission_id = '$student_id'
      AND afs.academic_year = '$academic_year'
      AND afd.fees_table_name = 'extratable'
       AND (afd.fee_received != 0 OR afd.scholarship != 0)
");

while ($row = $getExtraPaidQry->fetch()) {
    $particular = $row['particular'];
    if (isset($feeData[$particular])) {
        $feeData[$particular]['receipts'][] = $row;
    }
}

$getTermFeeQry = $connect->query("
    SELECT gcf.grp_course_id AS term_id,
           gcf.grp_particulars AS particular,
           gcf.grp_amount AS fee_collection
    FROM fees_master fm
    JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id
    WHERE fm.academic_year = '$academic_year'
      AND fm.medium = '$medium'
      AND $student_type_cndtn
      AND fm.standard = '$standard'
      AND fm.school_id = '$school_id'
");

while ($row = $getTermFeeQry->fetch()) {
    $particular = $row['particular'];
    $feeData[$particular] = [
        'fee_collection' => $row['fee_collection'],
        'receipts' => []
    ];
}
$getTermPaidQry = $connect->query("
    SELECT afs.receipt_date,
           afs.receipt_no,
           gcf.grp_particulars AS particular,
           afd.fee_received AS fee_paid,
           afd.scholarship AS concession,
           afd.balance_tobe_paid AS balance
    FROM admission_fees afs
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id
    JOIN group_course_fee gcf ON gcf.grp_course_id = afd.fees_id
    WHERE afs.admission_id = '$student_id'
      AND afs.academic_year = '$academic_year'
      AND afd.fees_table_name = 'grptable'
    AND (afd.fee_received != 0 OR afd.scholarship != 0)

");

while ($row = $getTermPaidQry->fetch()) {
    $particular = $row['particular'];
    if (isset($feeData[$particular])) {
        $feeData[$particular]['receipts'][] = $row;
    }
}
$transportFeeData = [];

$getTransportPendingQry = $connect->query(" 
    SELECT 
        acp.particulars, 
        acp.due_amount AS fee_collection 
    FROM 
        area_creation ac 
    JOIN 
        area_creation_particulars acp ON ac.area_id = acp.area_creation_id 
    WHERE 
        ac.area_id = '$transport_id' 
    ORDER BY 
        acp.due_date ASC 
");

while ($row = $getTransportPendingQry->fetch()) {
    $particular = $row['particulars'];
    $transportFeeData[$particular] = [
        'fee_collection' => $row['fee_collection'],
        'receipts' => []
    ];
}

$getTransportPaidQry = $connect->query(" 
    SELECT 
        taf.receipt_date, 
        taf.receipt_no, 
        acp.particulars AS particular, 
        tafd.fee_received AS fee_paid, 
        tafd.scholarship AS concession, 
        tafd.balance_tobe_paid AS balance 
    FROM 
        transport_admission_fees taf 
    JOIN 
        transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
    JOIN 
        area_creation_particulars acp ON tafd.area_creation_particulars_id = acp.particulars_id 
    WHERE 
        taf.admission_id = '$student_id' 
        AND taf.academic_year = '$academic_year' 
        AND (tafd.fee_received != 0 OR tafd.scholarship != 0)
");

while ($row = $getTransportPaidQry->fetch()) {
    $particular = $row['particular'];
    if (isset($transportFeeData[$particular])) {
        $transportFeeData[$particular]['receipts'][] = $row;
    }
}
$getManualConcessionQry = $connect->query("
    SELECT fc.fees_table_name, fc.fees_id, fc.scholarship_amount, fc.scholarship_header
    FROM fees_concession fc
    WHERE fc.student_id = '$student_id'
      AND fc.academic_year = '$academic_year'
      AND fc.school_id = '$school_id'
");
while ($row = $getManualConcessionQry->fetch()) {
    $table = $row['fees_table_name'];
    $feesId = $row['fees_id'];
    $concessionAmount = $row['scholarship_amount'];
    $particular = '';

    if ($table == 'amenitytable') {
        $particularQry = $connect->query("SELECT amenity_particulars FROM amenity_fee WHERE amenity_fee_id = '$feesId'");
        $particularRow = $particularQry->fetch();
        $particular = $particularRow['amenity_particulars'] ?? '';
    } elseif ($table == 'extratable') {
        $particularQry = $connect->query("SELECT extra_particulars FROM extra_curricular_activities_fee WHERE extra_fee_id = '$feesId'");
        $particularRow = $particularQry->fetch();
        $particular = $particularRow['extra_particulars'] ?? '';
    } elseif ($table == 'grptable') {
        $particularQry = $connect->query("SELECT grp_particulars FROM group_course_fee WHERE grp_course_id = '$feesId'");
        $particularRow = $particularQry->fetch();
        $particular = $particularRow['grp_particulars'] ?? '';
    } elseif ($table == 'transport') {
        $particularQry = $connect->query("SELECT particulars FROM area_creation_particulars WHERE particulars_id = '$feesId'");
        $particularRow = $particularQry->fetch();
        $particular = $particularRow['particulars'] ?? '';
    }

    if (!empty($particular)) {
        $manualRow = [
            'receipt_date' => '',
            'receipt_no' => 'Manual Concession',
            'fee_paid' => 0,
            'concession' => $concessionAmount,
            'balance' => ''
        ];

        // Insert into feeData or transportFeeData accordingly
        if ($table == 'transport') {
            if (!isset($transportFeeData[$particular])) {
                $transportFeeData[$particular] = [
                    'fee_collection' => 0,
                    'receipts' => []
                ];
            }
            $transportFeeData[$particular]['receipts'][] = $manualRow;
        } else {
            if (!isset($feeData[$particular])) {
                $feeData[$particular] = [
                    'fee_collection' => 0,
                    'receipts' => []
                ];
            }
            $feeData[$particular]['receipts'][] = $manualRow;
        }
    }
}
$lastYearPendingData = [];

$lastYearPendingQry = $connect->query("
   -- 1. grptable
SELECT 
    'grptable' AS fees_table_name,
    gcf.grp_particulars AS particular,
    gcf.grp_amount AS fee_collection,
    COALESCE(SUM(afd.fee_received), 0) AS fee_paid,
    COALESCE(SUM(afd.scholarship), 0) AS concession,
    (
        gcf.grp_amount 
        - COALESCE(SUM(afd.fee_received), 0)
        - COALESCE(SUM(afd.scholarship), 0)
        - COALESCE((
            SELECT SUM(fc.scholarship_amount)
            FROM fees_concession fc
            WHERE fc.student_id = af.admission_id
              AND fc.fees_table_name = 'grptable'
              AND fc.fees_master_id = afd.fees_master_id
        ), 0)
    ) AS balance
FROM group_course_fee gcf
JOIN admission_fees_details afd 
    ON gcf.grp_course_id = afd.fees_id 
    AND afd.fees_table_name = 'grptable'
JOIN admission_fees af 
    ON afd.admission_fees_ref_id = af.id
WHERE 
    af.admission_id = '$student_id'
    AND af.academic_year = '$last_year'
    AND gcf.fee_master_id = afd.fees_master_id
GROUP BY gcf.grp_course_id

UNION ALL

-- 2. extratable
SELECT 
    'extratable' AS fees_table_name,
    ecaf.extra_particulars AS particular,
    ecaf.extra_amount AS fee_collection,
    COALESCE(SUM(afd.fee_received), 0) AS fee_paid,
    COALESCE(SUM(afd.scholarship), 0) AS concession,
    (
        ecaf.extra_amount
        - COALESCE(SUM(afd.fee_received), 0)
        - COALESCE(SUM(afd.scholarship), 0)
        - COALESCE((
            SELECT SUM(fc.scholarship_amount)
            FROM fees_concession fc
            WHERE fc.student_id = af.admission_id
              AND fc.fees_table_name = 'extratable'
              AND fc.fees_master_id = afd.fees_master_id
        ), 0)
    ) AS balance
FROM extra_curricular_activities_fee ecaf
JOIN admission_fees_details afd 
    ON ecaf.extra_fee_id = afd.fees_id 
    AND afd.fees_table_name = 'extratable'
JOIN admission_fees af 
    ON afd.admission_fees_ref_id = af.id
WHERE 
    af.admission_id = '$student_id'
    AND af.academic_year = '$last_year'
    AND ecaf.fee_master_id = afd.fees_master_id
GROUP BY ecaf.extra_fee_id

UNION ALL

-- 3. amenitytable
SELECT 
    'amenitytable' AS fees_table_name,
    afee.amenity_particulars AS particular,
    afee.amenity_amount AS fee_collection,
    COALESCE(SUM(afd.fee_received), 0) AS fee_paid,
    COALESCE(SUM(afd.scholarship), 0) AS concession,
    (
        afee.amenity_amount
        - COALESCE(SUM(afd.fee_received), 0)
        - COALESCE(SUM(afd.scholarship), 0)
        - COALESCE((
            SELECT SUM(fc.scholarship_amount)
            FROM fees_concession fc
            WHERE fc.student_id = afs.admission_id
              AND fc.fees_table_name = 'amenitytable'
              AND fc.fees_master_id = afd.fees_master_id
        ), 0)
    ) AS balance
FROM amenity_fee afee
JOIN admission_fees_details afd 
    ON afee.amenity_fee_id = afd.fees_id 
    AND afd.fees_table_name = 'amenitytable'
JOIN admission_fees afs 
    ON afd.admission_fees_ref_id = afs.id
WHERE 
    afs.admission_id = '$student_id'
    AND afs.academic_year = '$last_year'
    AND afee.fee_master_id = afd.fees_master_id
GROUP BY afee.amenity_fee_id

UNION ALL

-- 4. transport
SELECT 
    'transport' AS fees_table_name,
    acp.particulars AS particular,
    acp.due_amount AS fee_collection,
    COALESCE(SUM(tafd.fee_received), 0) AS fee_paid,
    COALESCE(SUM(tafd.scholarship), 0) AS concession,
    (
        acp.due_amount
        - COALESCE(SUM(tafd.fee_received), 0)
        - COALESCE(SUM(tafd.scholarship), 0)
        - COALESCE((
            SELECT SUM(fc.scholarship_amount)
            FROM fees_concession fc
            WHERE fc.student_id = taf.admission_id
              AND fc.fees_table_name = 'transport'
              AND fc.fees_master_id = tafd.area_creation_id
        ), 0)
    ) AS balance
FROM area_creation_particulars acp
JOIN transport_admission_fees_details tafd 
    ON acp.particulars_id = tafd.area_creation_particulars_id
JOIN transport_admission_fees taf 
    ON tafd.admission_fees_ref_id = taf.id
WHERE 
    taf.admission_id = '$student_id'
    AND taf.academic_year = '$last_year'
    AND acp.area_creation_id = tafd.area_creation_id
GROUP BY acp.particulars_id

");

while ($row = $lastYearPendingQry->fetch()) {
    $particular = $row['particular'];
    $lastYearPendingData[$particular] = [
        'fee_collection' => $row['fee_collection'],
        'fee_paid' => $row['fee_paid'],
        'concession' => $row['concession'],
        'balance' => $row['fee_collection'] - $row['fee_paid'] - $row['concession']
    ];
}

?>

<table class="table table-bordered" id="show_student_profile">
    <thead>
        <tr>
            <th colspan="7" style="text-align:center;">AKV VIDYALAYA</th>
        </tr>
        <tr>
            <td colspan="7">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: left;"><b>Student Name:</b> <?= strtoupper($student_name) ?></td>
                        <td style="text-align: center;"><b>Standard:</b> <?= strtoupper($standard_name) ?></td>
                        <td style="text-align: right;"><b>Report Date:</b> <?= date('d/m/Y') ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <th>Receipt No.</th>
            <th>Particulars</th>
            <th>Fees Collection</th>
            <th>Fees Collected</th>
            <th>Concession</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($feeData as $particular => $details) {
            // First row for the total fee amount
            echo "<tr>
                <td></td>
                <td></td>
             <td><b>" . $particular . "</b></td>
                <td style='text-align: right;'>" . $details['fee_collection'] . "</td>
                <td></td>
                <td></td>
                 <td style='text-align: right;'>" . $details['fee_collection'] . "</td>
            </tr>";

            // Each payment row
            foreach ($details['receipts'] as $receipt) {
                echo "<tr>
                   <td>" . (!empty($receipt['receipt_date']) ? date('d/m/Y', strtotime($receipt['receipt_date'])) : '') . "</td>
                    <td>" . $receipt['receipt_no'] . "</td>
                    <td>" . $particular . "</td>
                    <td></td>
                    <td style='text-align: right;'>" . $receipt['fee_paid'] . "</td>
                    <td style='text-align: right;'>" . ($receipt['concession'] ?? '') . "</td>
                    <td style='text-align: right;'>" . ($receipt['balance'] ?? '') . "</td>
                </tr>";
            }
        }


        foreach ($transportFeeData as $particular => $details) {
            echo "<tr> 
        <td></td> 
        <td></td> 
      <td><b>" . $particular . "</b></td>
        <td style='text-align: right;'>" . $details['fee_collection'] . "</td> 
        <td></td> 
        <td></td> 
         <td style='text-align: right;'>" . $details['fee_collection'] . "</td>
    </tr>";

            foreach ($details['receipts'] as $receipt) {
                echo "<tr> 
           <td>" . (!empty($receipt['receipt_date']) ? date('d/m/Y', strtotime($receipt['receipt_date'])) : '') . "</td>
            <td>" . $receipt['receipt_no'] . "</td> 
            <td>" . $particular . "</td> 
            <td></td> 
            <td style='text-align: right;'>" . $receipt['fee_paid'] . "</td> 
            <td style='text-align: right;'>" . ($receipt['concession'] ?? '') . "</td> 
            <td style='text-align: right;'>" . ($receipt['balance'] ?? '') . "</td> 
        </tr>";
            }
        }

        // Display Last Year Total Row First
        $totalLastYearCollection = 0;
        $totalLastYearPaid = 0;
        $totalLastYearConcession = 0;

        foreach ($lastYearPendingData as $details) {
            $totalLastYearCollection += $details['fee_collection'];
            $totalLastYearPaid += $details['fee_paid'];
            $totalLastYearConcession += $details['concession'];
        }

        $lastYearBalance = $totalLastYearCollection - $totalLastYearPaid - $totalLastYearConcession;

        // Print Summary Row
        echo "<tr>
    <td></td>
    <td></td>
    <td><b>Last Year</b></td>
    <td style='text-align: right;'><b>{$totalLastYearCollection}</b></td>
    <td style='text-align: right;'><b>{$totalLastYearPaid}</b></td>
    <td style='text-align: right;'><b>{$totalLastYearConcession}</b></td>
    <td style='text-align: right;'><b>{$lastYearBalance}</b></td>
</tr>";

        // 2. Current Academic Year Paid for Last Year
        $lastyr_paidQry = $connect->query("
    SELECT lyf.receipt_date, lyf.receipt_no, lyfd.fee_received, lyfd.scholarship, lyfd.balance_tobe_paid 
    FROM last_year_fees lyf
    JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id
    WHERE lyf.admission_id = '$student_id' AND lyf.academic_year = '$year_id' AND (lyfd.fee_received != 0 OR lyfd.scholarship != 0)
");
$totalLastYearCurrentYearPaid = 0;
$totalLastYearCurrentYearConcession = 0;
        while ($ly_row = $lastyr_paidQry->fetch()) {
            $paid = $ly_row['fee_received'];
            $concession = $ly_row['scholarship'];
            $total = $paid + $concession;
            $balance = $ly_row['balance_tobe_paid'];; // Since this is current year payment for last year dues

    $totalLastYearCurrentYearPaid += $paid;
    $totalLastYearCurrentYearConcession += $concession;

            echo "<tr>
        <td>" . date('d/m/Y', strtotime($ly_row['receipt_date'])) . "</td>
        <td>" . $ly_row['receipt_no'] . "</td>
        <td></td>
        <td></td>
        <td style='text-align: right;'>{$paid}</td>
        <td style='text-align: right;'>{$concession}</td>
        <td style='text-align: right;'>{$balance}</td>
    </tr>";
        }
$last_bl = $lastYearBalance - ($totalLastYearCurrentYearPaid + $totalLastYearCurrentYearConcession);
        $grandTotalFeeCollection = 0;
        $grandTotalFeePaid = 0;
        $grandTotalFeeConcession = 0;

        foreach ($feeData as $particular => $details) {
            $grandTotalFeeCollection += $details['fee_collection'];
            foreach ($details['receipts'] as $receipt) {
                $grandTotalFeePaid += $receipt['fee_paid'];
                $grandTotalFeeConcession += $receipt['concession'];
            }
        }

        foreach ($transportFeeData as $particular => $details) {
            $grandTotalFeeCollection += $details['fee_collection'];
            foreach ($details['receipts'] as $receipt) {
                $grandTotalFeePaid += $receipt['fee_paid'];
                $grandTotalFeeConcession += $receipt['concession'];
            }
        }
      $grandTotalBalance = ($grandTotalFeeCollection - $grandTotalFeePaid - $grandTotalFeeConcession) + $last_bl;

        ?>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align: right;"><b>Grand Total Balance:</b></td>
            <td style="text-align: right;"><?= $grandTotalBalance ?></td>
        </tr>
    </tfoot>

</table>
<script>
    $(document).ready(function() {
        $('#show_student_profile').DataTable({
            ordering: false,
            paging: false,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    text: 'Print',
                    title: '',
                    customize: function(win) {
                        const css = `
                        table {
                            border-collapse: collapse !important;
                            width: 100%;
                        }
                        table, th, td {
                            border: 1px solid #000 !important;
                        }
                        table th, table td {
                            padding: 5px;
                            text-align: center;
                        }
                    `;
                        const style = win.document.createElement('style');
                        style.innerHTML = css;
                        win.document.head.appendChild(style);

                        var originalThead = $('#show_student_profile thead').clone();
                        $(win.document.body).find('table thead').replaceWith(originalThead);
                    }
                }
            ]
        });
    });
</script>