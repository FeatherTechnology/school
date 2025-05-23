<?php
include "../../ajaxconfig.php";
@session_start();
if (isset($_SESSION['school_id'])) {
    $school_id = $_SESSION['school_id'];
}

if (isset($_POST['feesFromDate'])) {
    $feesFromDate = new DateTime($_POST['feesFromDate']);
    $startdate = clone $feesFromDate;
}
if (isset($_POST['feesToDate'])) {
    $feesToDate = new DateTime($_POST['feesToDate']);
    $to_date = $feesToDate->format('Y-m-d');
}
?>

<table class="table table-bordered" id="show_student_fees_summary_list" style="text-align: left;">
    <thead>
        <tr>
            <th colspan='20' class="report-title">Fees Summary Report From <?php echo $feesFromDate->format('d-m-Y'); ?> To <?php echo $feesToDate->format('d-m-Y'); ?> </th>
        </tr>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">Date</th>
            <th rowspan="2">Receipt No</th>
            <th rowspan="2">Admission No</th>
            <th rowspan="2">Student Name</th>
            <th rowspan="2">Standard - Section</th>
            <th rowspan="2">Last Year Fee </th>
            <th rowspan="2">Admission</th>
            <th rowspan="2">Uniform</th>
            <th rowspan="2">Books</th>
            <th colspan="3">Group Fees</th>
            <th colspan="3">Transport Fees</th>
            <th rowspan="2">ECA</th>
            <th rowspan="2">Bank</th>
            <th rowspan="2">Cash </th>
            <th rowspan="2">Total Amount</th>
        </tr>
        <tr>
            <th>Term I</th>
            <th>Term II</th>
            <th>Term III</th>
            <th>Term I</th>
            <th>Term II</th>
            <th>Term III</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $admissionfee_total = 0;
        $extra_total = 0;
        $transportfee3_total = 0;
        $schoolfee3_total = 0;
        $schoolfee2_total = 0;
        $schoolfee1_total = 0;
        $bookfee_total = 0;
        $transportfee1_total = 0;
        $transportfee2_total = 0;
        $lastyear_total = 0;
        $uniformfee_total = 0;
        $cash_total = 0;
        $bank_total = 0;
        $total = 0;

        $a = 1;
        while ($startdate <= $feesToDate) {
            $from_date = $startdate->format('Y-m-d');

            // $getFeeCollectionQry = $connect->query("SELECT af.receipt_no, sc.admission_number, sc.student_name, std.standard, sc.section, 
            // SUM(CASE WHEN afd.fees_table_name = 'grptable' THEN afd.fee_received ELSE 0 END) AS grp_fee,
            // SUM(CASE WHEN afd.fees_table_name = 'amenitytable' THEN afd.fee_received ELSE 0 END) AS extra_fee,
            // 0 AS transportFees,
            // 0 AS lastyearFees
            // FROM `admission_fees` af 
            // JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
            // JOIN student_creation sc ON af.admission_id = sc.student_id 
            // JOIN standard_creation std ON sc.standard = std.standard_id 
            // WHERE af.receipt_date ='$from_date' AND afd.fee_received > 0 AND sc.school_id = '$school_id'
            // GROUP BY 
            //     af.receipt_no, 
            //     sc.admission_number, 
            //     sc.student_name, 
            //     std.standard, 
            //     sc.section

            // UNION 

            // SELECT taf.receipt_no, sc.admission_number, sc.student_name, std.standard, sc.section, 0 AS grp_fee, 0 AS extra_fee, tafd.fee_received AS transportFees, 0 AS lastyearFees 
            // FROM `transport_admission_fees` taf 
            // JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
            // JOIN student_creation sc ON taf.admission_id = sc.student_id 
            // JOIN standard_creation std ON sc.standard = std.standard_id 
            // WHERE taf.receipt_date ='$from_date' AND tafd.fee_received > 0 AND sc.school_id = '$school_id'

            // UNION

            // SELECT lyf.receipt_no, sc.admission_number, sc.student_name, std.standard, sc.section, 
            // 0 AS grp_fee,
            // 0 AS extra_fee,
            // 0 AS transportFees,
            // SUM(lyfd.fee_received) AS lastyearFees
            // FROM last_year_fees lyf 
            // JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id 
            // JOIN student_creation sc ON lyf.admission_id = sc.student_id 
            // JOIN standard_creation std ON sc.standard = std.standard_id 
            // WHERE lyf.receipt_date ='$from_date' AND lyfd.fee_received > 0  AND sc.school_id = '$school_id' HAVING lastyearFees > 0 ");


            $getFeeCollectionQry = $connect->query("SELECT 
            receipt_no,
            admission_number,
            student_name,
            standard,
            section,
            SUM(grp_fee_t1) AS grp_fee_t1,
            SUM(grp_fee_t2) AS grp_fee_t2,
            SUM(grp_fee_t3) AS grp_fee_t3,
            SUM(book_fees) AS book_fees,
            SUM(uniform_fees) AS uniform_fees,
            SUM(admission_fees) AS admission_fees,
            SUM(extra_fees) AS extra_fees,
            SUM(transport_fee_t1) AS transport_fee_t1,
            SUM(transport_fee_t2) AS transport_fee_t2,
            SUM(transport_fee_t3) AS transport_fee_t3,
            SUM(lastyearFees) AS lastyearFees,
            SUM(cash_balance) AS cash_balance,
            SUM(bank_balance) AS bank_balance,
            SUM(cash_balance + bank_balance) AS total_fee_received
        FROM (
            SELECT
            *
        FROM
            (
            SELECT
            af.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section,
            
            -- Group Fee Terms
            SUM(
                CASE 
                    WHEN afd.fees_table_name = 'grptable' 
                     AND gcf.grp_particulars LIKE '%I%' 
                     AND gcf.grp_particulars NOT LIKE '%II%' 
                     AND gcf.grp_particulars NOT LIKE '%III%' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS grp_fee_t1,
        
            SUM(
                CASE 
                    WHEN afd.fees_table_name = 'grptable' 
                     AND gcf.grp_particulars LIKE '%II%' 
                     AND gcf.grp_particulars NOT LIKE '%III%' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS grp_fee_t2,
        
            SUM(
                CASE 
                    WHEN afd.fees_table_name = 'grptable' 
                     AND gcf.grp_particulars LIKE '%III%' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS grp_fee_t3,
        
            -- Extra fee
            SUM(
                CASE 
                    WHEN afd.fees_table_name = 'amenitytable' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS book_fees,
        0 AS uniform_fees,
        0 AS admission_fees,
        0 AS extra_fees,
            -- Transport fee placeholders
            0 AS transport_fee_t1,
            0 AS transport_fee_t2,
            0 AS transport_fee_t3,
        
            -- Last year fee placeholder
            0 AS lastyearFees,
              SUM(
                CASE 
                    WHEN afd_deno.payment_mode = 'cash_payment' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS cash_balance,
        
            -- Bank Balance
            SUM(
                CASE 
                    WHEN afd_deno.payment_mode != 'cash_payment' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS bank_balance
        
        FROM admission_fees af
        JOIN admission_fees_details afd 
            ON af.id = afd.admission_fees_ref_id
        JOIN admission_fees_denomination afd_deno 
            ON af.id = afd_deno.admission_fees_ref_id
        JOIN student_creation sc 
            ON af.admission_id = sc.student_id
        JOIN student_history sh 
            ON sh.student_id = sc.student_id 
            AND af.academic_year = sh.academic_year
        JOIN standard_creation std 
            ON sh.standard = std.standard_id
        JOIN group_course_fee gcf 
            ON afd.fees_id = gcf.grp_course_id
        WHERE af.receipt_date = '$from_date' AND afd.fees_table_name != 'extratable'
            AND afd.fee_received > 0 
            AND sc.school_id = '$school_id' 
            AND sc.status = 0
        
        GROUP BY
            af.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section
        UNION ALL
        SELECT
            af.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section,
              0 AS grp_fee_t1,
            0 AS grp_fee_t2,
            0 AS grp_fee_t3,
            0 AS book_fees,
              SUM(
                CASE 
                    WHEN afd.fees_table_name = 'extratable' 
                     AND ecaf.extra_particulars LIKE '%uniform%'  
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS uniform_fees,
                SUM(
                CASE 
                    WHEN afd.fees_table_name = 'extratable' 
                     AND ecaf.extra_particulars LIKE '%admission%'  
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS admission_fees,
                SUM(
                CASE 
                    WHEN afd.fees_table_name = 'extratable' 
                     AND ecaf.extra_particulars LIKE '%eca%'  
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS extra_fees,
            -- Transport fee placeholders
            0 AS transport_fee_t1,
            0 AS transport_fee_t2,
            0 AS transport_fee_t3,
        
            -- Last year fee placeholder
            0 AS lastyearFees,
              SUM(
                CASE 
                    WHEN afd_deno.payment_mode = 'cash_payment' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS cash_balance,
        
            -- Bank Balance
            SUM(
                CASE 
                    WHEN afd_deno.payment_mode != 'cash_payment' 
                    THEN afd.fee_received 
                    ELSE 0 
                END
            ) AS bank_balance
        
        FROM admission_fees af
        JOIN admission_fees_details afd 
            ON af.id = afd.admission_fees_ref_id
        JOIN admission_fees_denomination afd_deno 
            ON af.id = afd_deno.admission_fees_ref_id
        JOIN student_creation sc 
            ON af.admission_id = sc.student_id
        JOIN student_history sh 
            ON sh.student_id = sc.student_id 
            AND af.academic_year = sh.academic_year
        JOIN standard_creation std 
            ON sh.standard = std.standard_id
         JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
        
        WHERE af.receipt_date = '$from_date' AND afd.fees_table_name = 'extratable'
            AND afd.fee_received > 0 
            AND sc.school_id = '$school_id' 
            AND sc.status = 0
        
        GROUP BY
            af.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section
        UNION ALL
        SELECT
            taf.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section,
            0 AS grp_fee_t1,
            0 AS grp_fee_t2,
            0 AS grp_fee_t3,
            0 AS book_fees,
            0 AS uniform_fees,
        0 AS admission_fees,
        0 AS extra_fees,
        SUM(CASE WHEN acp.particulars LIKE '%I%' AND acp.particulars NOT LIKE '%II%' AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received ELSE 0 END) AS transport_fee_t1,
        SUM(CASE WHEN acp.particulars LIKE '%II%' AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received ELSE 0 END) AS transport_fee_t2,
        SUM(CASE WHEN acp.particulars LIKE '%III%' THEN tafd.fee_received ELSE 0 END) AS transport_fee_t3,
            0 AS lastyearFees,
              SUM(
                CASE 
                    WHEN tafd_deno.payment_mode = 'cash_payment' 
                    THEN tafd.fee_received
                    ELSE 0 
                END
            ) AS cash_balance,
        
            -- Bank Balance
            SUM(
                CASE 
                    WHEN tafd_deno.payment_mode != 'cash_payment' 
                    THEN tafd.fee_received 
                    ELSE 0 
                END
            ) AS bank_balance
        FROM
            transport_admission_fees taf
        JOIN transport_admission_fees_details tafd 
            ON taf.id = tafd.admission_fees_ref_id
            JOIN transport_admission_fees_denomination tafd_deno 
            ON taf.id = tafd_deno.admission_fees_ref_id
        JOIN student_creation sc 
            ON taf.admission_id = sc.student_id
        JOIN student_history sh 
            ON sh.student_id = sc.student_id AND taf.academic_year = sh.academic_year
        JOIN standard_creation std 
            ON sh.standard = std.standard_id
        JOIN area_creation ac 
            ON sh.transportarearefid = ac.area_id
        JOIN area_creation_particulars acp 
            ON tafd.area_creation_particulars_id = acp.particulars_id
        WHERE
            taf.receipt_date = '$from_date' 
            AND tafd.fee_received > 0 
            AND sc.school_id = '$school_id' 
            AND sc.status = 0
        GROUP BY
            taf.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section
        
        UNION ALL
        SELECT
            lyf.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section,
            0 AS grp_fee_t1,
            0 AS grp_fee_t2,
            0 AS grp_fee_t3,
            0 AS book_fees,
            0 AS uniform_fees,
        0 AS admission_fees,
        0 AS extra_fees,
            0 AS transport_fee_t1,
            0 AS transport_fee_t2,
            0 AS transport_fee_t3,
            SUM(lyfd.fee_received) AS lastyearFees,
              SUM(
                CASE 
                    WHEN lyfd_deno.payment_mode = 'cash_payment' 
                    THEN lyfd.fee_received
                    ELSE 0 
                END
            ) AS cash_balance,
        
            -- Bank Balance
            SUM(
                CASE 
                    WHEN lyfd_deno.payment_mode != 'cash_payment' 
                    THEN lyfd.fee_received
                    ELSE 0 
                END
            ) AS bank_balance
        FROM
            last_year_fees lyf
        JOIN last_year_fees_details lyfd ON
            lyf.id = lyfd.admission_fees_ref_id
        JOIN last_year_fees_denomination lyfd_deno ON
            lyf.id = lyfd_deno.admission_fees_ref_id
        JOIN student_creation sc ON
            lyf.admission_id = sc.student_id
        JOIN student_history sh ON
            sh.student_id = sc.student_id AND lyf.academic_year = sh.academic_year
        JOIN standard_creation STD ON
            sh.standard = std.standard_id
        WHERE
            lyf.receipt_date = '$from_date' AND lyfd.fee_received > 0 AND sc.school_id = '$school_id' AND sc.status = 0
        GROUP BY
                lyfd.id,
            lyf.receipt_no,
            sc.admission_number,
            sc.student_name,
            std.standard,
            sh.section
        ) AS combined_result
        ORDER BY
            CAST(
                SUBSTRING(
                    receipt_no,
                    LOCATE('-', receipt_no) + 1
                ) AS UNSIGNED
            )
        ) AS combined_result
        GROUP BY receipt_no, admission_number, student_name, standard, section
        ORDER BY CAST( SUBSTRING( receipt_no, LOCATE('-', receipt_no) + 1 ) AS UNSIGNED ) ");

            while ($feeCollection = $getFeeCollectionQry->fetchObject()) {
        ?>

                <tr>
                    <td style="text-align: center;"><?php echo $a++; ?></td>
                    <td style="text-align: right;"><?php echo date('d-m-Y', strtotime($from_date)); ?></td>
                    <td style="text-align: left;"><?php echo $feeCollection->receipt_no; ?></td>
                    <td style="text-align: left;"><?php echo $feeCollection->admission_number; ?></td>
                    <td style="text-align: left;"><?php echo $feeCollection->student_name; ?></td>
                    <td style="text-align: left;"><?php echo $feeCollection->standard . ' - ' . $feeCollection->section; ?></td>
                    <td class="text-right"><?php echo $feeCollection->lastyearFees; ?></td>
                    <td class="text-right"><?php echo $feeCollection->admission_fees; ?></td>
                    <td class="text-right"><?php echo $feeCollection->uniform_fees; ?></td>
                    <td class="text-right"><?php echo $feeCollection->book_fees; ?></td>
                    <td class="text-right"><?php echo $feeCollection->grp_fee_t1; ?></td>
                    <td class="text-right"><?php echo $feeCollection->grp_fee_t2; ?></td>
                    <td class="text-right"><?php echo $feeCollection->grp_fee_t3; ?></td>
                    <td class="text-right"><?php echo $feeCollection->transport_fee_t1; ?></td>
                    <td class="text-right"><?php echo $feeCollection->transport_fee_t2; ?></td>
                    <td class="text-right"><?php echo $feeCollection->transport_fee_t3; ?></td>
                    <td class="text-right"><?php echo $feeCollection->extra_fees; ?></td>
                    <td class="text-right"><?php echo $feeCollection->bank_balance; ?></td>
                    <td class="text-right"><?php echo $feeCollection->cash_balance; ?></td>



                    <td class="text-right"><?php echo $totalAmnt = $feeCollection->grp_fee_t1 + $feeCollection->grp_fee_t2  + $feeCollection->grp_fee_t3 + $feeCollection->book_fees + $feeCollection->admission_fees + $feeCollection->uniform_fees + $feeCollection->extra_fees + $feeCollection->transport_fee_t1 + $feeCollection->transport_fee_t2 + $feeCollection->transport_fee_t3 + $feeCollection->lastyearFees; ?></td>
                </tr>

        <?php
                $admissionfee_total += $feeCollection->admission_fees;
                $uniformfee_total += $feeCollection->uniform_fees;
                $bookfee_total += $feeCollection->book_fees;
                $schoolfee1_total += $feeCollection->grp_fee_t1;
                $schoolfee2_total += $feeCollection->grp_fee_t2;
                $schoolfee3_total += $feeCollection->grp_fee_t3;
                $extra_total += $feeCollection->extra_fees;
                $transportfee1_total += $feeCollection->transport_fee_t1;
                $transportfee2_total += $feeCollection->transport_fee_t2;
                $transportfee3_total += $feeCollection->transport_fee_t3;
                $lastyear_total += $feeCollection->lastyearFees;
                $bank_total += $feeCollection->bank_balance;
                $cash_total += $feeCollection->cash_balance;
                $total += $totalAmnt;
            }

            $startdate->modify('+1 day');
        } //End of While loop for getting dates from start to end date. 
        ?>
        <tr style="font-weight: bold;">
            <td><?php echo $a; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Grand Total</td>
            <td class="text-right"><?php echo $lastyear_total; ?></td>
            <td class="text-right"><?php echo $admissionfee_total; ?></td>
            <td class="text-right"><?php echo $uniformfee_total; ?></td>
            <td class="text-right"><?php echo $bookfee_total; ?></td>
            <td class="text-right"><?php echo $schoolfee1_total; ?></td>
            <td class="text-right"><?php echo $schoolfee2_total; ?></td>
            <td class="text-right"><?php echo $schoolfee3_total; ?></td>
            <td class="text-right"><?php echo $transportfee1_total; ?></td>
            <td class="text-right"><?php echo $transportfee2_total; ?></td>
            <td class="text-right"><?php echo $transportfee3_total; ?></td>
            <td class="text-right"><?php echo $extra_total; ?></td>
            <td class="text-right"><?php echo $bank_total; ?></td>
            <td class="text-right"><?php echo $cash_total; ?></td>
            <td class="text-right"><?php echo $total; ?></td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#show_student_fees_summary_list').DataTable({
            order: [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    text: 'Print',
                    customize: function(win) {
                        var thead = '<thead>' +
                            '<tr>' +
                            '<th rowspan="2">S.No</th>' +
                            '<th rowspan="2">Date</th>' +
                            '<th rowspan="2">Receipt No</th>' +
                            '<th rowspan="2">Admission No</th>' +
                            '<th rowspan="2">Student Name</th>' +
                            '<th rowspan="2">Standard - Section</th>' +
                            '<th rowspan="2">Last Year Fee</th>' +
                            '<th rowspan="2">Admission</th>' +
                            '<th rowspan="2">Uniform</th>' +
                            '<th rowspan="2">Books</th>' +
                            '<th colspan="3">Group Fees</th>' +
                            '<th colspan="3">Transport Fees</th>' +
                            '<th rowspan="2">ECA</th>' +
                            '<th rowspan="2">Bank</th>' +
                            '<th rowspan="2">Cash</th>' +
                            '<th rowspan="2">Total Amount</th>' +
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

                        $(win.document.body).css('width', '100%');

                        const css = `
                            body {
                                font-size: 12px;
                            }
                            table {
                                width: 100% !important;
                                border-collapse: collapse !important;
                            }
                            table th, table td {
                               font-size: 20pt !important;
                                text-align: left !important;
                                white-space: nowrap !important;
                                padding: 10px !important;
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
            paging: false,
            ordering: false,
        });
    });
</script>