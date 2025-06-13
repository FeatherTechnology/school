<?php
include "../../ajaxconfig.php";
@session_start();
if (isset($_SESSION['school_id'])) {
    $school_id = $_SESSION['school_id'];
}

if (isset($_POST['feeType'])) {
    $feeType = $_POST['feeType'];
}
if (isset($_POST['dateSelect'])) {
    $dateSelect = $_POST['dateSelect'];
}
if (isset($_POST['singleDate'])) {
    $singleDate = $_POST['singleDate'];
}
if (isset($_POST['feesFromDate'])) {
    $feesFromDate = new DateTime($_POST['feesFromDate']);
    $startdate = clone $feesFromDate;
}
if (isset($_POST['feesToDate'])) {
    $feesToDate = new DateTime($_POST['feesToDate']);
    $to_date = $feesToDate->format('Y-m-d');
}

if ($dateSelect == 'singledate') {

    if ($feeType == 'grptable' || $feeType == 'extratable' || $feeType == 'amenitytable') {
        // School fees: grouped by term
        $Qry = "SELECT 
            af.receipt_no, 
            sc.admission_number, 
            sc.student_name, 
            std.standard, 
            sh.section, 

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%I%'     AND gcf.grp_particulars NOT LIKE '%II%' 
                AND gcf.grp_particulars NOT LIKE '%III%' THEN afd.fee_received 
                ELSE 0 
            END) AS first_term_grp_fee,

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%II%'   AND gcf.grp_particulars NOT LIKE '%III%'  THEN afd.fee_received 
                ELSE 0 
            END) AS second_term_grp_fee,

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%III%' THEN afd.fee_received 
                ELSE 0 
            END) AS third_term_grp_fee,

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
            SUM(CASE WHEN afd.fees_table_name = 'amenitytable' THEN afd.fee_received ELSE 0 END) AS amenity_fee

        FROM admission_fees af 
        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
       LEFT  JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id
       LEFT  JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
        JOIN student_creation sc ON af.admission_id = sc.student_id 
        JOIN student_history sh ON sh.student_id = sc.student_id AND af.academic_year = sh.academic_year
        JOIN standard_creation std ON sh.standard = std.standard_id 

        WHERE af.receipt_date = '$singleDate' AND afd.fees_table_name = '$feeType'
            AND afd.fee_received > 0 
            AND sc.school_id = '$school_id' 
            AND sc.status = 0

        GROUP BY af.id
        ORDER BY CAST(SUBSTRING(af.receipt_no, LOCATE('-', af.receipt_no) + 1) AS UNSIGNED)";
    } else if ($feeType == 'lastyear') {
        $Qry = "SELECT 
            lyf.receipt_no, 
            sc.admission_number, 
            sc.student_name, 
            std.standard, 
            sh.section, 
            lyf.receipt_date,
            (CASE WHEN lyfd.fees_table_name = 'grptable' THEN lyfd.fee_received ELSE 0 END) AS group_fees,
            (CASE WHEN lyfd.fees_table_name = 'transport' THEN lyfd.fee_received ELSE 0 END) AS transport_fees,
            (CASE WHEN lyfd.fees_table_name = 'amenitytable' THEN lyfd.fee_received ELSE 0 END) AS amenity_fees

        FROM last_year_fees lyf 
        JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id 
        JOIN student_creation sc ON lyf.admission_id = sc.student_id
        JOIN student_history sh ON sh.student_id = sc.student_id AND lyf.academic_year = sh.academic_year 
        JOIN standard_creation std ON sh.standard = std.standard_id 

        WHERE lyf.receipt_date = '$singleDate' 
            AND lyfd.fee_received > 0 
            AND sc.school_id = '$school_id' 
            AND sc.status = 0 

        ORDER BY CAST(SUBSTRING(lyf.receipt_no, LOCATE('-', lyf.receipt_no) + 1) AS UNSIGNED)";
    } else if ($feeType == 'transport') {
        $Qry = "SELECT 
        taf.receipt_no, 
        sc.admission_number, 
        sc.student_name, 
        std.standard, 
        sh.section, 
        SUM(CASE 
            WHEN acp.particulars LIKE '%I%' 
            AND acp.particulars NOT LIKE '%II%' 
            AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term1,

        SUM(CASE 
            WHEN acp.particulars LIKE '%II%' 
            AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term2,

        SUM(CASE 
            WHEN acp.particulars LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term3

    FROM transport_admission_fees taf 
    JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
    JOIN area_creation_particulars acp ON tafd.area_creation_particulars_id = acp.particulars_id
    JOIN student_creation sc ON taf.admission_id = sc.student_id 
    JOIN student_history sh ON sh.student_id = sc.student_id AND taf.academic_year = sh.academic_year 
    JOIN standard_creation std ON sh.standard = std.standard_id 

    WHERE taf.receipt_date ='$singleDate' 
        AND tafd.fee_received > 0 
        AND sc.school_id = '$school_id' 
        AND sc.status = 0 

    GROUP BY taf.id
    ORDER BY CAST(SUBSTRING(taf.receipt_no, LOCATE('-', taf.receipt_no) + 1) AS UNSIGNED)";
    }
    // HTML Rendering
?>

    <table class="table table-bordered" id="show_dayend_report_list">
        <thead>
            <tr>
                <th colspan='<?php echo ($feeType == "amenitytable") ? "7" : "9"; ?>'>
                    Day End Report At <?php echo date('d-m-Y', strtotime($singleDate)); ?>
                </th>
            </tr>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Receipt No</th>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Standard & Section</th>

                <?php if ($feeType == 'lastyear') { ?>
                    <th>Group Fee</th>
                    <th>Amenity Fee</th>
                    <th>Transport Fee</th>

                <?php } elseif ($feeType == 'grptable' || $feeType == 'transport') { ?>
                    <th>Term I</th>
                    <th>Term II</th>
                    <th>Term III</th>

                <?php } elseif ($feeType == 'extratable') { ?>
                    <th>Uniform Fee</th>
                    <th>Admission Fee</th>
                    <th>ECA Fee</th>

                <?php } else { ?>
                    <th>Collected Fee</th>
                <?php } ?>
            </tr>

        </thead>
        <tbody>
            <?php
            $a = 1;
            $single_total = 0;
            $single_total2 = 0;
            $single_total3 = 0;
            $term1_total = 0;
            $term2_total = 0;
            $term3_total = 0;

            $getFeeCollectionQry = $connect->query($Qry);
            while ($feeCollection = $getFeeCollectionQry->fetchObject()) {
            ?>
                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($singleDate)); ?></td>
                    <td><?php echo $feeCollection->receipt_no; ?></td>
                    <td><?php echo $feeCollection->admission_number; ?></td>
                    <td><?php echo $feeCollection->student_name; ?></td>
                    <td><?php echo $feeCollection->standard . '-' . $feeCollection->section; ?></td>

                    <?php
                    if ($feeType == 'lastyear') {
                        echo "<td class='text-right'>{$feeCollection->group_fees}</td>";
                        echo "<td class='text-right'>{$feeCollection->amenity_fees}</td>";
                        echo "<td class='text-right'>{$feeCollection->transport_fees}</td>";

                        $single_total += $feeCollection->group_fees;
                        $single_total2 += $feeCollection->amenity_fees;
                        $single_total3 += $feeCollection->transport_fees;
                    } else if ($feeType == 'grptable') {
                        echo "<td class='text-right'>{$feeCollection->first_term_grp_fee}</td>";
                        echo "<td class='text-right'>{$feeCollection->second_term_grp_fee}</td>";
                        echo "<td class='text-right'>{$feeCollection->third_term_grp_fee}</td>";

                        $term1_total += $feeCollection->first_term_grp_fee;
                        $term2_total += $feeCollection->second_term_grp_fee;
                        $term3_total += $feeCollection->third_term_grp_fee;

                        $single_total += $feeCollection->first_term_grp_fee + $feeCollection->second_term_grp_fee + $feeCollection->third_term_grp_fee;
                    } else if ($feeType == 'transport') {
                        echo "<td class='text-right'>{$feeCollection->transport_term1}</td>";
                        echo "<td class='text-right'>{$feeCollection->transport_term2}</td>";
                        echo "<td class='text-right'>{$feeCollection->transport_term3}</td>";

                        $term1_total += $feeCollection->transport_term1;
                        $term2_total += $feeCollection->transport_term2;
                        $term3_total += $feeCollection->transport_term3;
                    } else if ($feeType == 'extratable') {
                        echo "<td class='text-right'>{$feeCollection->uniform_fees}</td>";
                        echo "<td class='text-right'>{$feeCollection->admission_fees}</td>";
                        echo "<td class='text-right'>{$feeCollection->extra_fees}</td>";
                        $single_total += $feeCollection->uniform_fees;
                        $single_total2 += $feeCollection->admission_fees;
                        $single_total3 += $feeCollection->extra_fees;
                    } else if ($feeType == 'amenitytable') {
                        echo "<td class='text-right'>{$feeCollection->amenity_fee}</td>";
                        $single_total += $feeCollection->amenity_fee;
                    } else {
                        echo "<td></td>";
                    }
                    ?>
                </tr>

            <?php } ?>


            <tr style="font-weight: bold;">
                <td><?php echo $a; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Grand Total</td>
                <?php
                if ($feeType == 'lastyear' || $feeType == 'extratable') {
                    echo "<td class='text-right'>{$single_total}</td>";
                    echo "<td class='text-right'>{$single_total2}</td>";
                    echo "<td class='text-right'>{$single_total3}</td>";
                } else if ($feeType == 'grptable' || $feeType == 'transport') {
                    echo "<td class='text-right'>{$term1_total}</td>";
                    echo "<td class='text-right'>{$term2_total}</td>";
                    echo "<td class='text-right'>{$term3_total}</td>";
                } else {
                    echo "<td class='text-right'>{$single_total}</td>";
                }
                ?>
            </tr>

        </tbody>
    </table>


<?php } else if ($dateSelect == 'multipledate') { ?>

    <table class="table table-bordered" id="show_dayend_report_list">
        <thead>
            <tr>
                <th colspan='<?php echo ($feeType == "amenitytable") ? "7" : "9"; ?>'>
                    Day End Report From <?php echo $feesFromDate->format('d-m-Y'); ?> To <?php echo $feesToDate->format('d-m-Y'); ?>
                </th>
            </tr>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Receipt No</th>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Standard & Section</th>

                <?php if ($feeType == 'lastyear') { ?>
                    <th>Group Fee</th>
                    <th>Amenity Fee</th>
                    <th>Transport Fee</th>

                <?php } elseif ($feeType == 'grptable' || $feeType == 'transport') { ?>
                    <th>Term I</th>
                    <th>Term II</th>
                    <th>Term III</th>

                <?php } elseif ($feeType == 'extratable') { ?>
                    <th>Uniform Fee</th>
                    <th>Admission Fee</th>
                    <th>ECA Fee</th>

                <?php } else { ?>
                    <th>Collected Fee</th>
                <?php } ?>
            </tr>


        </thead>
        <tbody>
            <?php
            $multiple_total = 0;
            $multiple_total2 = 0;
            $multiple_total3 = 0;
            $term1_total = 0;
            $term2_total = 0;
            $term3_total = 0;
            $a = 1;
            while ($startdate <= $feesToDate) {
                $from_date = $startdate->format('Y-m-d');

                if ($feeType == 'grptable' || $feeType == 'extratable' || $feeType == 'amenitytable') { //school
                    $Qry = "SELECT 
            af.receipt_no, 
            sc.admission_number, 
            sc.student_name, 
            std.standard, 
            sh.section, 

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%I%' AND gcf.grp_particulars NOT LIKE '%II%' 
                AND gcf.grp_particulars NOT LIKE '%III%' THEN afd.fee_received 
                ELSE 0 
            END) AS first_term_grp_fee,

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%II%'   AND gcf.grp_particulars NOT LIKE '%III%'  THEN afd.fee_received 
                ELSE 0 
            END) AS second_term_grp_fee,

            SUM(CASE 
                WHEN afd.fees_table_name = 'grptable' AND gcf.grp_particulars LIKE '%III%' THEN afd.fee_received 
                ELSE 0 
            END) AS third_term_grp_fee,

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
            SUM(CASE WHEN afd.fees_table_name = 'amenitytable' THEN afd.fee_received ELSE 0 END) AS amenity_fee

        FROM admission_fees af 
        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
        JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id
        LEFT  JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
        JOIN student_creation sc ON af.admission_id = sc.student_id 
        JOIN student_history sh ON sh.student_id = sc.student_id AND af.academic_year = sh.academic_year
        JOIN standard_creation std ON sh.standard = std.standard_id 
        WHERE af.receipt_date ='$from_date' AND afd.fee_received > 0 AND afd.fees_table_name = '$feeType' AND sc.school_id = '$school_id' AND sc.status = 0
        GROUP BY 
            af.id ORDER BY CAST(SUBSTRING(receipt_no, LOCATE('-', receipt_no) + 1) AS UNSIGNED)";
                } else if ($feeType == 'lastyear') { //Last Year
                    $Qry = "SELECT 
    lyf.receipt_no, 
    sc.admission_number, 
    sc.student_name, 
    std.standard, 
    sh.section, 
    lyf.receipt_date,
    (CASE WHEN lyfd.fees_table_name = 'grptable' THEN lyfd.fee_received ELSE 0 END) AS group_fees,
    (CASE WHEN lyfd.fees_table_name = 'transport' THEN lyfd.fee_received ELSE 0 END) AS transport_fees,
    (CASE WHEN lyfd.fees_table_name = 'amenitytable' THEN lyfd.fee_received ELSE 0 END) AS amenity_fees
FROM last_year_fees lyf 
JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id 
JOIN student_creation sc ON lyf.admission_id = sc.student_id
JOIN student_history sh ON sh.student_id = sc.student_id AND lyf.academic_year = sh.academic_year 
JOIN standard_creation std ON sh.standard = std.standard_id 

WHERE 
    lyf.receipt_date = '$from_date' 
    AND lyfd.fee_received > 0 
    AND sc.school_id = '$school_id' 
    AND sc.status = 0 
ORDER BY 
    CAST(SUBSTRING(lyf.receipt_no, LOCATE('-', lyf.receipt_no) + 1) AS UNSIGNED)";
                } else if ($feeType == 'transport') { //Transport
                    $Qry = "SELECT 
        taf.receipt_no, 
        sc.admission_number, 
        sc.student_name, 
        std.standard, 
        sh.section, 

        SUM(CASE 
            WHEN acp.particulars LIKE '%I%' 
            AND acp.particulars NOT LIKE '%II%' 
            AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term1,

        SUM(CASE 
            WHEN acp.particulars LIKE '%II%' 
            AND acp.particulars NOT LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term2,

        SUM(CASE 
            WHEN acp.particulars LIKE '%III%' THEN tafd.fee_received 
            ELSE 0 
        END) AS transport_term3

    FROM transport_admission_fees taf 
    JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
    JOIN area_creation_particulars acp ON tafd.area_creation_particulars_id = acp.particulars_id
    JOIN student_creation sc ON taf.admission_id = sc.student_id 
    JOIN student_history sh ON sh.student_id = sc.student_id AND taf.academic_year = sh.academic_year 
    JOIN standard_creation std ON sh.standard = std.standard_id 
        WHERE taf.receipt_date ='$from_date' AND tafd.fee_received > 0 AND sc.school_id = '$school_id' AND sc.status = 0 GROUP BY 
        taf.id ORDER BY CAST(SUBSTRING(receipt_no, LOCATE('-', receipt_no) + 1) AS UNSIGNED)";
                }

                $getFeeCollectionQry = $connect->query("$Qry");
                while ($feeCollection = $getFeeCollectionQry->fetchObject()) {
            ?>
                    <tr>
                        <td><?php echo $a++; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($from_date)); ?></td>
                        <td><?php echo $feeCollection->receipt_no; ?></td>
                        <td><?php echo $feeCollection->admission_number; ?></td>
                        <td><?php echo $feeCollection->student_name; ?></td>
                        <td><?php echo $feeCollection->standard . '-' . $feeCollection->section; ?></td>
                        <?php
                        if ($feeType == 'lastyear') {
                            echo "<td class='text-right'>{$feeCollection->group_fees}</td>";
                            echo "<td class='text-right'>{$feeCollection->amenity_fees}</td>";
                            echo "<td class='text-right'>{$feeCollection->transport_fees}</td>";

                            $multiple_total += $feeCollection->group_fees;
                            $multiple_total2 += $feeCollection->amenity_fees;
                            $multiple_total3 += $feeCollection->transport_fees;
                        } else if ($feeType == 'grptable') {
                            echo "<td class='text-right' >{$feeCollection->first_term_grp_fee}</td>";
                            echo "<td class='text-right'>{$feeCollection->second_term_grp_fee}</td>";
                            echo "<td class='text-right'>{$feeCollection->third_term_grp_fee}</td>";

                            $term1_total += $feeCollection->first_term_grp_fee;
                            $term2_total += $feeCollection->second_term_grp_fee;
                            $term3_total += $feeCollection->third_term_grp_fee;
                        } else if ($feeType == 'transport') {
                            echo "<td class='text-right'>{$feeCollection->transport_term1}</td>";
                            echo "<td class='text-right'>{$feeCollection->transport_term2}</td>";
                            echo "<td class='text-right'>{$feeCollection->transport_term3}</td>";

                            $term1_total += $feeCollection->transport_term1;
                            $term2_total += $feeCollection->transport_term2;
                            $term3_total += $feeCollection->transport_term3;
                        } else if ($feeType == 'extratable') {
                            echo "<td class='text-right'>{$feeCollection->uniform_fees}</td>";
                            echo "<td class='text-right'>{$feeCollection->admission_fees}</td>";
                            echo "<td class='text-right'>{$feeCollection->extra_fees}</td>";
                            $multiple_total += $feeCollection->uniform_fees;
                            $multiple_total2 += $feeCollection->admission_fees;
                            $multiple_total3 += $feeCollection->extra_fees;
                        } else if ($feeType == 'amenitytable') {
                            echo "<td class='text-right'>{$feeCollection->amenity_fee}</td>";
                            $multiple_total += $feeCollection->amenity_fee;
                        } else {
                            echo "<td></td>";
                        }
                        ?>
                    </tr>
            <?php
                }

                $startdate->modify('+1 day');
            }
            ?>
            <tr style="font-weight: bold;">
                <td><?php echo $a; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Grand Total</td>
                <?php
                if ($feeType == 'lastyear' || $feeType == 'extratable') {
                    echo "<td class='text-right'>{$multiple_total}</td>";
                    echo "<td class='text-right'>{$multiple_total2}</td>";
                    echo "<td class='text-right'>{$multiple_total3}</td>";
                } else if ($feeType == 'grptable' || $feeType == 'transport') {
                    echo "<td class='text-right'>{$term1_total}</td>";
                    echo "<td class='text-right'>{$term2_total}</td>";
                    echo "<td class='text-right'>{$term3_total}</td>";
                } else {
                    echo "<td class='text-right'>{$multiple_total}</td>";
                }
                ?>
            </tr>
        </tbody>
    </table>

<?php
} ?>

<script>
    $(document).ready(function() {

        var table = $('#show_dayend_report_list').DataTable({
            order: [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    text: 'Print',
                    title: '',
                    customize: function(win) {
                        const css = `
                             table td {
                                text-align: right !important;
                            }
                        `;
                        const style = win.document.createElement('style');
                        style.innerHTML = css;
                        win.document.head.appendChild(style);
                        var originalThead = $('#show_dayend_report_list thead').clone();
                        $(win.document.body).find('table thead').replaceWith(originalThead);

                    }
                }
            ],
            paging: false
        });
    });
</script>