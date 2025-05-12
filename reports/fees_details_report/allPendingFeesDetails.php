<?php
include "../../ajaxconfig.php";
@session_start();
if (isset($_SESSION['school_id'])) {
    $school_id = $_SESSION['school_id'];
}

if (isset($_POST['academicyear'])) {
    $academicyear = $_POST['academicyear'];
    $splityear = explode('-', $academicyear);
    $lastyear = intval($splityear[0] - 1) . '-' . intval($splityear[1] - 1);
}
if (isset($_POST['stdMedium'])) {
    $stdMedium = $_POST['stdMedium'];
}
if (isset($_POST['stdStandard'])) {
    $stdStandard = $_POST['stdStandard'];
}
if (isset($_POST['stdSection'])) {
    $stdSection = $_POST['stdSection'];
}
?>
<table class="table table-bordered" id="show_student_allPending_list" style="text-align: left;">
    <thead>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">Admission Number</th>
            <th rowspan="2">Student Name</th>
            <th rowspan="2">Standard & Section</th>
            <th rowspan="2">Mobile No</th>
            <th rowspan="2">Last Year Pending</th>
            <th rowspan="2">Admission</th>
            <th rowspan="2">Uniform</th>
            <th rowspan="2">Books</th>
            <th colspan="3">Pending Fees</th>
            <th colspan="3">Transport Fees</th>
            <th rowspan="2">ECA</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>Term&nbsp;I</th>
            <th>Term II</th>
            <th>Term III</th>
            <th>Term&nbsp;I</th>
            <th>Term II</th>
            <th>Term III</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $getStudentListQry = $connect->query("SELECT sc.student_id, sc.admission_number, sc.student_name, std.standard, sh.section, sh.extra_curricular, sh.transportarearefid, sh.studentstype, sc.sms_sent_no,sc.leaving_term
FROM `student_creation` sc 
LEFT JOIN student_history sh ON sc.student_id = sh.student_id
JOIN standard_creation std ON sh.standard = std.standard_id
WHERE sh.academic_year  = '$academicyear' && sc.medium = '$stdMedium' && sh.standard = '$stdStandard' && sc.leaving_term !='1' && sc.leaving_term !='5' &&  sh.section = '$stdSection' && sc.school_id = '$school_id' ORDER BY sc.student_name ASC  
");
        $i = 1;
        $ls_pending = 0;
        $grnd_admission_pending = 0;
        $grnd_uniform_pending = 0;
        $grnd_eca_pending = 0;
        $grnd_term1_pending = 0;
        $grnd_term2_pending = 0;
        $grnd_term3_pending = 0;
        $grnd_book_pending = 0;
        $grnd_extra_pending = 0;
        $grnd_trans1_pending = 0;
        $grnd_trans2_pending = 0;
        $grnd_trans3_pending = 0;

        while ($studentList = $getStudentListQry->fetchObject()) {
            $studentsType = $studentList->studentstype;
            if ($studentsType == "1" || $studentsType == "2") {
                $student_type_cndtn = "(fm.student_type = '$studentsType' OR fm.student_type = '4')";
            } else {
                $student_type_cndtn = "(fm.student_type = '$studentsType')";
            }
            $leavingTerm = $studentList->leaving_term;

            $getLastYearPending = $connect->query("SELECT 
    SUM(pending) AS total_balance_tobe_paid
FROM (
    -- First subquery for 'grptable'
    (SELECT 
        (
            (
                SELECT SUM(gcf.grp_amount)
                FROM group_course_fee gcf
                WHERE gcf.fee_master_id = afd.fees_master_id
            ) - (SUM(afd.fee_received) + SUM(afd.scholarship))
        ) - COALESCE(
            (
                SELECT SUM(scholarship_amount)
                FROM fees_concession
                WHERE student_id = '$studentList->student_id'
                AND fees_table_name = 'grptable'
                AND fees_master_id = afd.fees_master_id
            ), 0
        ) AS pending
    FROM admission_fees af
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id
    WHERE af.admission_id = '$studentList->student_id'
    AND af.academic_year = '$lastyear'
    AND afd.fees_table_name = 'grptable')

    UNION 

    -- Second subquery for 'extratable'
    (SELECT 
        (
            (
                SELECT SUM(ecaf.extra_amount)
                FROM extra_curricular_activities_fee ecaf
                JOIN student_history sh ON sh.student_id = '$studentList->student_id'
                WHERE FIND_IN_SET(ecaf.extra_fee_id, sh.extra_curricular)
                AND sh.academic_year = '$lastyear'
            ) - (COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0))
        ) - COALESCE(
            (
                SELECT SUM(scholarship_amount)
                FROM fees_concession
                WHERE student_id = '$studentList->student_id'
                AND fees_table_name = 'extratable'
                AND fees_master_id = afd.fees_master_id
            ), 0
        ) AS pending
    FROM admission_fees af
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id
    WHERE af.admission_id = '$studentList->student_id'
    AND af.academic_year = '$lastyear'
    AND afd.fees_table_name = 'extratable')

    UNION 

    -- Third subquery for 'amenitytable'
    (SELECT 
        (
            (
                SELECT SUM(af.amenity_amount)
                FROM amenity_fee af
                WHERE af.fee_master_id = afd.fees_master_id
            ) - (SUM(afd.fee_received) + SUM(afd.scholarship))
        ) - COALESCE(
            (
                SELECT SUM(scholarship_amount)
                FROM fees_concession
                WHERE student_id = '$studentList->student_id'
                AND fees_table_name = 'amenitytable'
                AND fees_master_id = afd.fees_master_id
            ), 0
        ) AS pending
    FROM admission_fees afs
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id
    WHERE afs.admission_id = '$studentList->student_id'
    AND afs.academic_year = '$lastyear'
    AND afd.fees_table_name = 'amenitytable')

    UNION 

    -- Fourth subquery for 'transport'
    (SELECT 
        COALESCE(
            (
                (
                    SELECT SUM(acp.due_amount)
                    FROM area_creation_particulars acp
                    JOIN student_history sh ON sh.student_id = '$studentList->student_id'
                    WHERE acp.area_creation_id = sh.transportarearefid
                    AND sh.academic_year = '$lastyear'
                ) - (COALESCE(SUM(tafd.fee_received), 0) + COALESCE(SUM(tafd.scholarship), 0))
            ) - COALESCE(
                (
                    SELECT SUM(scholarship_amount)
                    FROM fees_concession
                    WHERE student_id = '$studentList->student_id'
                    AND fees_table_name = 'transport'
                    AND fees_master_id = tafd.area_creation_id
                ), 0
            ), 0
        ) AS pending
    FROM transport_admission_fees af
    JOIN transport_admission_fees_details tafd ON af.id = tafd.admission_fees_ref_id
    WHERE af.admission_id = '$studentList->student_id'
    AND af.academic_year = '$lastyear')
) AS total_balance;
");
            $lastyearpending = $getLastYearPending->fetchObject();
            $lastPending = $lastyearpending->total_balance_tobe_paid;
            $lastyr_grpfeeQry = $connect->query("SELECT (SUM(lyfd.fee_received)) as paid_grp_amount 
            FROM `last_year_fees` lyf 
            JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id 
            JOIN group_course_fee gcf ON lyfd.fees_id = gcf.grp_course_id 
            WHERE lyf.admission_id = '$studentList->student_id' AND lyf.academic_year = '$academicyear' ");
            if ($lastyr_grpfeeQry->rowCount() > 0) {
                $lastyr_grp_amount = $lastyr_grpfeeQry->fetch()['paid_grp_amount'];
            } else {
                $lastyr_grp_amount = '0';
            }
            $lsPending =  $lastPending  - $lastyr_grp_amount;
            $getTermPendingQry = $connect->query("SELECT 
    gcf.grp_particulars, 
    ABS(
        ABS(
            gcf.grp_amount - (
                SELECT 
                    COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0) 
                FROM 
                    admission_fees_details afd 
                JOIN 
                    admission_fees af 
                ON 
                    afd.admission_fees_ref_id = af.id 
                WHERE 
                    afd.fees_id = gcf.grp_course_id 
                    AND afd.fees_table_name = 'grptable' 
                    AND af.admission_id = '$studentList->student_id'
            )
        ) - 
        COALESCE(
            (SELECT SUM(scholarship_amount) 
             FROM fees_concession 
             WHERE student_id = '$studentList->student_id' 
             AND fees_table_name = 'grptable' 
             AND fees_id = gcf.grp_course_id), 
            0
        )
    ) AS termPending, 
    gcf.grp_amount AS termAmnt  
FROM 
    fees_master fm 
JOIN 
    group_course_fee gcf 
ON 
    fm.fees_id = gcf.fee_master_id 
WHERE 
    fm.academic_year = '$academicyear' 
    AND fm.medium = '$stdMedium' 
    AND $student_type_cndtn 
    AND fm.standard = '$stdStandard' 
    AND fm.school_id = '$school_id' 
ORDER BY 
    gcf.grp_date ASC;
");
            $term_pending = array();
            while ($termPendingInfo = $getTermPendingQry->fetch()) {
                $termPending = $termPendingInfo['termPending'];
                $termAmnt = $termPendingInfo['termAmnt'];

                // Check if termPending is null, then consider the full term amount
                $currentPending = is_null($termPending) ? $termAmnt : $termPending;

                // Logic to handle pending amounts based on leaving term
                if ($leavingTerm == 2) {
                    // If the student leaves after 1st term, only show 1st term pending amount
                    $term_pending[] = ($termPendingInfo['grp_particulars'] == 'I Term Fee') ? $currentPending : 0;
                } elseif ($leavingTerm == 3) {
                    // If the student leaves after 2nd term, show pending for the 1st and 2nd terms
                    $term_pending[] = ($termPendingInfo['grp_particulars'] <= 'II Term Fee') ? $currentPending : 0;
                } else {
                    // If student stays beyond the 2nd term, show all pending terms
                    $term_pending[] = $currentPending;
                }
            }

            $getBookPendingQry = $connect->query("SELECT 
    (af.amenity_amount - (
        SELECT 
            COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0)
        FROM 
            admission_fees_details afd 
        JOIN 
            admission_fees af2 
        ON 
            afd.admission_fees_ref_id = af2.id 
        WHERE 
            afd.fees_id = af.amenity_fee_id 
            AND afd.fees_table_name = 'amenitytable' 
            AND af2.admission_id = '$studentList->student_id'
    ) 
    ) - COALESCE(
        (SELECT SUM(scholarship_amount) 
         FROM fees_concession 
         WHERE student_id = '$studentList->student_id' 
         AND fees_table_name = 'amenitytable' 
         AND fees_id = af.amenity_fee_id), 0
    ) AS bookPending, 
    af.amenity_amount AS bookAmnt  
FROM 
    fees_master fm 
JOIN 
    amenity_fee af 
ON 
    fm.fees_id = af.fee_master_id 
WHERE 
    fm.academic_year = '$academicyear' 
    AND fm.medium = '$stdMedium' 
    AND $student_type_cndtn 
    AND fm.standard = '$stdStandard' 
    AND fm.school_id = '$school_id' 
ORDER BY 
    af.amenity_date ASC;
");
            if ($getBookPendingQry->rowCount() > 0) {
                $bookpendingInfo = $getBookPendingQry->fetch();
                $bookPending = $bookpendingInfo['bookPending'];
                $bookAmnt = $bookpendingInfo['bookAmnt'];
                $currentBookPending = is_null($bookPending) ? $bookAmnt : $bookPending;
                // Logic to handle pending amounts based on leaving term
                if ($leavingTerm == 2 && $leavingTerm == 3) {
                    // If the student leaves after 1st term, only show 1st term pending amount
                    $book_pending = 0;
                } else {
                    // If student stays beyond the 2nd term, show all pending terms
                    $book_pending = $currentBookPending;
                }
            } else {
                $book_pending = '0';
            }
            $extra_id = ($studentList->extra_curricular) ? $studentList->extra_curricular : '0';

            // Initialize pending amounts
            $eca_pending = 0;
            $uniform_pending = 0;
            $admission_pending = 0;

            // Get all relevant extra_curricular fee entries
            $getExtraPendingQry = $connect->query("
                SELECT 
                    ecaf.extra_fee_id,
                    ecaf.extra_particulars,
                    ecaf.extra_amount,
                    COALESCE(
                        (
                            ecaf.extra_amount 
                            - (
                                SELECT 
                                    COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0)
                                FROM admission_fees_details afd 
                                JOIN admission_fees af ON afd.admission_fees_ref_id = af.id 
                                WHERE afd.fees_id = ecaf.extra_fee_id 
                                    AND afd.fees_table_name = 'extratable' 
                                    AND af.admission_id = '$studentList->student_id'
                            )
                        ), 0
                    )
                    - COALESCE((
                        SELECT SUM(scholarship_amount) 
                        FROM fees_concession 
                        WHERE student_id ='$studentList->student_id' 
                            AND fees_table_name ='extratable' 
                            AND fees_id = ecaf.extra_fee_id
                    ),0) AS extraPending
                FROM extra_curricular_activities_fee ecaf 
                WHERE ecaf.extra_fee_id IN ($extra_id)
            ");

            if ($getExtraPendingQry->rowCount() > 0) {
                while ($extrapendingInfo = $getExtraPendingQry->fetch()) {
                    $extra_particulars = strtolower($extrapendingInfo['extra_particulars']);
                    $extraPending = $extrapendingInfo['extraPending'];
                    $extraAmnt = $extrapendingInfo['extra_amount'];
                    $currentExtraPending = is_null($extraPending) ? $extraAmnt : $extraPending;

                    // Handle leaving term logic
                    $pending_amount = ($leavingTerm == 2 || $leavingTerm == 3) ? 0 : $currentExtraPending;

                    if (strpos($extra_particulars, 'uniform') !== false) {
                        $uniform_pending += $pending_amount;
                    } elseif (strpos($extra_particulars, 'admission') !== false) {
                        $admission_pending += $pending_amount;
                    } elseif (strpos($extra_particulars, 'eca') !== false) {
                        $eca_pending += $pending_amount;
                    }
                }
            } else {
                $uniform_pending = 0;
                $admission_pending = 0;
                $eca_pending = 0;
            }

            $transport_id = ($studentList->transportarearefid) ? $studentList->transportarearefid : '0';
            $getTransportPendingQry = $connect->query("SELECT
    acp.particulars,
    COALESCE(
        acp.due_amount - COALESCE((
            SELECT
                SUM(tafd.fee_received) + SUM(tafd.scholarship)
            FROM
                transport_admission_fees_details tafd
            JOIN
                transport_admission_fees taf ON tafd.admission_fees_ref_id = taf.id
            WHERE
                tafd.area_creation_particulars_id = acp.particulars_id
                AND taf.admission_id = '$studentList->student_id'
        ), 0), 0) 
    - COALESCE((
            SELECT
                SUM(scholarship_amount)
            FROM
                fees_concession
            WHERE
                student_id = '$studentList->student_id'
                AND fees_table_name = 'transport'
                AND fees_id = acp.particulars_id
        ), 0) AS transport_pending,
    acp.due_amount AS transAmnt
FROM 
    area_creation ac
JOIN 
    area_creation_particulars acp 
ON 
    ac.area_id = acp.area_creation_id
WHERE 
    ac.area_id = '$transport_id'
ORDER BY 
    acp.due_date ASC;
 ");
            $transport_pending = array();
            while ($transportPendingInfo = $getTransportPendingQry->fetch()) {
                $transportpending = $transportPendingInfo['transport_pending'];
                $transAmnt = $transportPendingInfo['transAmnt'];
                // Check if termPending is null, then consider the full term amount
                $currentTransPending = is_null($transportpending) ? $termAmnt : $transportpending;

                // Logic to handle pending amounts based on leaving term
                if ($leavingTerm == 2) {
                    // If the student leaves after 1st term, only show 1st term pending amount
                    $transport_pending[] = ($transportPendingInfo['particulars'] == 'Term I') ? $currentTransPending : 0;
                } elseif ($leavingTerm == 3) {
                    // If the student leaves after 2nd term, show pending for the 1st and 2nd terms
                    $transport_pending[] = ($transportPendingInfo['particulars'] <= 'Term II') ? $currentTransPending : 0;
                } else {
                    // If student stays beyond the 2nd term, show all pending terms
                    $transport_pending[] = $currentTransPending;
                }
            }

        ?>
            <tr>
                <td style="text-align: center;"><?php echo $i++; ?></td>
                <td style="text-right;"><?php echo $studentList->admission_number; ?></td>
                <td style="text-align: left;"><?php echo $studentList->student_name; ?></td>
                <td style="text-align: left;"><?php echo $studentList->standard . ' - ' . $studentList->section; ?></td>
                <td style="text-align: left;"><?php echo $studentList->sms_sent_no; ?></td>
                <td style="text-align: right;"><?php echo ($lsPending > 0) ? $lsPending : '0'; ?></td>
                <td style="text-align: right;"><?php echo $admission_pending; ?></td>
                <td style="text-align: right;"><?php echo $uniform_pending; ?></td>
                <td style="text-align: right;"><?php echo $book_pending; ?></td>
                <td style="text-align: right;"><?php echo ($term_pending) ? $term_pending[0] : '0'; ?></td>
                <td style="text-align: right;"><?php echo ($term_pending) ? $term_pending[1] : '0'; ?></td>
                <td style="text-align: right;"><?php echo ($term_pending) ? $term_pending[2] : '0'; ?></td>
                <td style="text-align: right;"><?php echo ($transport_pending) ? $transport_pending[0] : '0'; ?></td>
                <td style="text-align: right;"><?php echo ($transport_pending) ? $transport_pending[1] : '0'; ?></td>
                <td style="text-align: right;"><?php echo ($transport_pending) ? $transport_pending[2] : '0'; ?></td>
                <td style="text-align: right;"><?php echo $eca_pending; ?></td>
                <td></td>
            </tr>

        <?php
            $ls_pending += ($lsPending > 0) ? $lsPending : '0';
            $grnd_admission_pending += $admission_pending;
            $grnd_uniform_pending += $uniform_pending;
            $grnd_book_pending += $book_pending;
            $grnd_term1_pending += ($term_pending) ? $term_pending[0] : '0';
            $grnd_term2_pending += ($term_pending) ? $term_pending[1] : '0';
            $grnd_term3_pending += ($term_pending) ? $term_pending[2] : '0';
            $grnd_trans1_pending += ($transport_pending) ? $transport_pending[0] : '0';
            $grnd_trans2_pending += ($transport_pending) ? $transport_pending[1] : '0';
            $grnd_trans3_pending += ($transport_pending) ? $transport_pending[2] : '0';
            $grnd_eca_pending += $eca_pending;
        } ?>
        <tr style="font-weight: bold;">
            <td><?php echo $i; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Grand Total</td>
            <td class="text-right"><?php echo $ls_pending; ?></td>
            <td class="text-right"><?php echo $grnd_admission_pending; ?></td>
            <td class="text-right"><?php echo $grnd_uniform_pending; ?></td>
            <td class="text-right"><?php echo $grnd_book_pending; ?></td>
            <td class="text-right"><?php echo $grnd_term1_pending; ?></td>
            <td class="text-right"><?php echo $grnd_term2_pending; ?></td>
            <td class="text-right"><?php echo $grnd_term3_pending; ?></td>
            <td class="text-right"><?php echo $grnd_trans1_pending; ?></td>
            <td class="text-right"><?php echo $grnd_trans2_pending; ?></td>
            <td class="text-right"><?php echo $grnd_trans3_pending; ?></td>
            <td class="text-right"><?php echo $grnd_eca_pending; ?></td>
            <td></td>

        </tr>
    </tbody>
    <!-- <tfoot>
        <tr>
            <td colspan="5"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot> -->
</table>

<script>
    $(document).ready(function () {
        $('#show_student_allPending_list').DataTable({
            order: [[0, "asc"]],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    text: 'Print',
                    customize: function (win) {
                        var thead = '<thead>' +
                            '<tr>' +
                            '<th rowspan="2">S.No</th>' +
                            '<th rowspan="2">Admission Number</th>' +
                            '<th rowspan="2">Student Name</th>' +
                            '<th rowspan="2">Standard & Section</th>' +
                            '<th rowspan="2">Mobile No</th>' +
                            '<th rowspan="2">Last Year Pending</th>' +
                            '<th rowspan="2">Admission</th>' +
                            '<th rowspan="2">Uniform</th>' +
                            '<th rowspan="2">Books</th>' +
                            '<th colspan="3">Pending Fees</th>' +
                            '<th colspan="3">Transport Fees</th>' +
                            '<th rowspan="2">ECA</th>' +
                            '<th rowspan="2">Action</th>' +
                            '</tr>' +
                            '<tr>' +
                            '<th>Term I</th>' +
                            '<th>Term II</th>' +
                            '<th>Term III</th>' +
                            '<th>Term I</th>' +
                            '<th>Term II</th>' +
                            '<th>Term III</th>' +
                            '</tr>' +
                            '</thead>';
                        $(win.document.body).find('table').html(thead + $(win.document.body).find('table tbody').html());

                        // Style fix
                        $(win.document.body).find('table')
                            .css('border-collapse', 'collapse')
                            .css('width', '100%');
                        $(win.document.body).find('table th, table td')
                            .css('border', '1px solid black')
                            .css('padding', '5px')
                            .css('text-align', 'center');
                        $(win.document.body).css('width', '100%');

                        const css = `
                            body {
                                font-size: 20px !important;;
                            }
                            table {
                                width: 100% !important;
                                border-collapse: collapse !important;
                            }
                            table th, table td {
                                font-size: 20pt !important;
                                text-align: left !important;
                                white-space: nowrap !important;
                                padding: 15px !important;
                            }
                            .text-right {
                                text-align: right !important;
                            }
                        `;
                        const style = win.document.createElement('style');
                        style.innerHTML = css;
                        win.document.head.appendChild(style);
                         // Apply right alignment to td/th in columns from 6 onward (zero-based index)
                         $(win.document.body).find('table').find('tr').each(function() {
                            $(this).find('th:gt(4), td:gt(4)').addClass('text-right'); // Columns 5 onwards (6th col and up)
                        });
                    },
                    autoPrint: true
                }
            ],
            columnDefs: [
            {
                targets: [1], // Replace with the actual index of the Admission Number column (zero-based)
                className: 'text-right'
            }
        ],
            paging: false,
            ordering: false,
            scrollX: true
        });
    });
</script>
