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
// if(isset($_POST['studentType'])){
//     $studentType = $_POST['studentType'];
// }
?>

<table class="table table-bordered" id="show_student_allPending_list" style="text-align: left;">
    <thead>
        <tr>
            <th rowspan="2">Class</th>
            <th rowspan="2">Last Year Pending</th>
            <th rowspan="2">Admission</th>
            <th rowspan="2">Uniform</th>
            <th rowspan="2">Book</th>
            <th colspan="3">Pending Fees</th>
            <th colspan="3">Transport Fees</th>
            <th rowspan="2">Extra</th>
            <th rowspan="2">Scholarship</th>
            <th rowspan="2">Grand Total</th>
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
        $getStandardListQry = $connect->query("SELECT std.standard_id, std.standard
FROM standard_creation std
WHERE std.status = '0' ");
        $i = 1;
        $grand_term1 = 0;
        $grand_term2 = 0;
        $grand_term3 = 0;
        $grand_book = 0;
        $grand_last = 0;
        $grand_admission = 0;
        $grand_uniform = 0;
        $grand_extra = 0;
        $grand_transport_term1 = 0;
        $grand_transport_term2 = 0;
        $grand_transport_term3 = 0;
        $grand_concession = 0;
        $grand_overall_total = 0;
        while ($standardList = $getStandardListQry->fetchObject()) {
            
    $getLastYearPendingQry = $connect->query("
    SELECT SUM(pending_amount) AS total_pending_fees FROM (

    -- Term Fee Pending
    SELECT (
        (
            COALESCE(gcf.grp_amount, 0) *
            (
                SELECT COUNT(DISTINCT sh.student_id)
                FROM student_creation sc
                LEFT JOIN student_history sh ON sc.student_id = sh.student_id
                WHERE
                    sh.standard = '$standardList->standard_id'
                    AND sh.academic_year = '$lastyear'
                    AND sc.leaving_term NOT IN (1, 5)
                    AND sc.school_id = '$school_id'
                    AND sc.status = 0
            )
        ) -
        (
            SELECT COALESCE(SUM(afd.fee_received + afd.scholarship), 0)
            FROM admission_fees_details afd
            JOIN admission_fees af ON afd.admission_fees_ref_id = af.id
            JOIN student_creation sc ON sc.student_id = af.admission_id
            LEFT JOIN student_history sh ON sc.student_id = sh.student_id
            WHERE
                afd.fees_id = gcf.grp_course_id
                AND afd.fees_table_name = 'grptable'
                AND sh.standard = '$standardList->standard_id'
                AND sh.academic_year = '$lastyear'
                AND sc.school_id = '$school_id'
                AND sc.status = 0
        )
    ) AS pending_amount
    FROM fees_master fm
    JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id
    WHERE
        fm.academic_year = '$lastyear'
        AND fm.medium = '$stdMedium'
        AND fm.standard = '$standardList->standard_id'
        AND fm.school_id = '$school_id'

    UNION ALL

    -- Amenity Fee Pending
    SELECT (
        (
            COALESCE(af.amenity_amount, 0) *
            (
                SELECT COUNT(DISTINCT sh.student_id)
                FROM student_creation sc
                LEFT JOIN student_history sh ON sc.student_id = sh.student_id
                WHERE
                    sh.standard = '$standardList->standard_id'
                    AND sh.academic_year = '$lastyear'
                    AND sc.leaving_term NOT IN (1, 5)
                    AND sc.school_id = '$school_id'
                    AND sc.status = 0
            )
        ) -
        (
            SELECT COALESCE(SUM(afd.fee_received + afd.scholarship), 0)
            FROM admission_fees_details afd
            JOIN admission_fees af2 ON afd.admission_fees_ref_id = af2.id
            JOIN student_creation sc ON sc.student_id = af2.admission_id
            JOIN student_history sh ON sh.student_id = sc.student_id
            WHERE
                afd.fees_id = af.amenity_fee_id
                AND afd.fees_table_name = 'amenitytable'
                AND sh.standard = '$standardList->standard_id'
                AND sh.academic_year = '$lastyear'
                AND sc.status = 0
        )
    ) AS pending_amount
    FROM fees_master fm
    JOIN amenity_fee af ON fm.fees_id = af.fee_master_id
    WHERE
        fm.academic_year = '$lastyear'
        AND fm.medium = '$stdMedium'
        AND fm.standard = '$standardList->standard_id'
        AND fm.school_id = '$school_id'

    UNION ALL

    -- Extra Curricular Fee Pending
    SELECT (
        (
            ecaf.extra_amount * COUNT(DISTINCT sh.student_id)
        ) -
        (
            (
                SELECT COALESCE(SUM(afd.fee_received + afd.scholarship), 0)
                FROM admission_fees_details afd
                JOIN admission_fees af ON afd.admission_fees_ref_id = af.id
                JOIN student_creation sc2 ON sc2.student_id = af.admission_id
                JOIN student_history sh2 ON sh2.student_id = sc2.student_id
                WHERE
                    FIND_IN_SET(ecaf.extra_fee_id, sh2.extra_curricular) > 0
                    AND afd.fees_id = ecaf.extra_fee_id
                    AND afd.fees_table_name = 'extratable'
                    AND sh2.standard = '$standardList->standard_id'
                    AND sh2.academic_year = '$lastyear'
                    AND sc2.leaving_term NOT IN (1, 5)
                    AND sc2.status = 0
            ) +
            (
                SELECT COALESCE(SUM(fc.scholarship_amount), 0)
                FROM fees_concession fc
                JOIN student_creation sc3 ON sc3.student_id = fc.student_id
                JOIN student_history sh3 ON sh3.student_id = sc3.student_id
                WHERE
                    FIND_IN_SET(ecaf.extra_fee_id, sh3.extra_curricular) > 0
                    AND fc.fees_id = ecaf.extra_fee_id
                    AND fc.fees_table_name = 'extratable'
                    AND sh3.standard = '$standardList->standard_id'
                    AND sh3.academic_year = '$lastyear'
                    AND sc3.leaving_term NOT IN (1, 5)
                    AND sc3.status = 0
            )
        )
    ) AS pending_amount
    FROM student_history sh
    JOIN student_creation sc ON sc.student_id = sh.student_id
    JOIN extra_curricular_activities_fee ecaf ON FIND_IN_SET(ecaf.extra_fee_id, sh.extra_curricular) > 0
    WHERE
        sh.academic_year = '$lastyear'
        AND sh.standard = '$standardList->standard_id'
        AND sc.leaving_term NOT IN (1, 5)
        AND sc.status = 0
    GROUP BY ecaf.extra_fee_id

    UNION ALL

    -- Transport Fee Pending
    SELECT (
        SUM(CASE WHEN is_min = 1 THEN transport_pending ELSE 0 END) +
        SUM(CASE WHEN is_max = 1 THEN transport_pending ELSE 0 END) +
        SUM(CASE WHEN is_middle = 1 THEN transport_pending ELSE 0 END)
    ) AS pending_amount
    FROM (
        SELECT 
            acp.particulars_id,
            ac.area_id,
            acp.due_amount,
            (
                COALESCE(acp.due_amount, 0) * COALESCE(sc.student_count, 0)
            ) - (
                SELECT COALESCE(SUM(tafd.fee_received + tafd.scholarship), 0)
                FROM transport_admission_fees taf
                JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id
                JOIN student_creation sc2 ON sc2.student_id = taf.admission_id
                JOIN student_history sh2 ON sc2.student_id = sh2.student_id
                WHERE 
                    tafd.area_creation_particulars_id = acp.particulars_id 
                    AND sh2.standard = '$standardList->standard_id'
                    AND sh2.academic_year = '$lastyear'
                    AND sc2.school_id = '$school_id'
                    AND sc2.leaving_term NOT IN (1, 5)
                    AND sc2.status = 0
            ) AS transport_pending,

            CASE 
                WHEN acp.particulars_id = (
                    SELECT MIN(acp1.particulars_id) 
                    FROM area_creation_particulars acp1 
                    WHERE acp1.area_creation_id = ac.area_id
                ) THEN 1 ELSE 0 
            END AS is_min,

            CASE 
                WHEN acp.particulars_id = (
                    SELECT MAX(acp1.particulars_id) 
                    FROM area_creation_particulars acp1 
                    WHERE acp1.area_creation_id = ac.area_id
                ) THEN 1 ELSE 0 
            END AS is_max,

            CASE 
                WHEN acp.particulars_id NOT IN (
                    SELECT MIN(acp1.particulars_id) 
                    FROM area_creation_particulars acp1 
                    WHERE acp1.area_creation_id = ac.area_id
                ) 
                AND acp.particulars_id NOT IN (
                    SELECT MAX(acp1.particulars_id) 
                    FROM area_creation_particulars acp1 
                    WHERE acp1.area_creation_id = ac.area_id
                ) THEN 1 ELSE 0 
            END AS is_middle

        FROM area_creation ac
        JOIN area_creation_particulars acp ON ac.area_id = acp.area_creation_id
        LEFT JOIN (
            SELECT 
                sh.transportarearefid AS area_id,
                COUNT(DISTINCT sh.student_id) AS student_count
            FROM student_creation sc
            JOIN student_history sh ON sc.student_id = sh.student_id
            WHERE 
                sh.standard = '$standardList->standard_id'
                AND sh.academic_year = '$lastyear'
                AND sc.leaving_term NOT IN (1, 5)
                AND sc.school_id = '$school_id'
                AND sc.status = 0
            GROUP BY sh.transportarearefid
        ) sc ON ac.area_id = sc.area_id
        WHERE ac.year_id = '$lastyear'
    ) AS categorized_particulars

) AS total_pending_table;


");


$lastyearpending = $getLastYearPendingQry->fetch();
$lastPending = $lastyearpending['total_pending_fees'] ?? 0;

$lastyr_grpfeeQry = $connect->query("
    SELECT SUM(lyfd.fee_received) AS paid_grp_amount 
    FROM last_year_fees lyf 
    JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id 
    JOIN group_course_fee gcf ON lyfd.fees_id = gcf.grp_course_id 
    JOIN student_creation sc ON lyf.admission_id = sc.student_id
    JOIN student_history sh ON sc.student_id = sh.student_id
    WHERE lyf.academic_year = '$academicyear' 
        AND sh.standard = '$standardList->standard_id'
          AND sh.academic_year = '$lastyear'
        AND sc.status = 0
        AND sc.leaving_term NOT IN (1, 5)
");

if ($lastyr_grpfeeQry->rowCount() > 0) {
    $lastyr_grp_amount = $lastyr_grpfeeQry->fetch()['paid_grp_amount'];
} else {
    $lastyr_grp_amount = '0';
}


// 🔚 Final Last Year Pending (after reducing paid group fee)
$lsPending = $lastPending - $lastyr_grp_amount;

            $getTermPendingQry = $connect->query("SELECT
    (
        COALESCE(gcf.grp_amount, 0) *(
        SELECT
         COUNT(sh.student_id) AS student_count
        FROM
            student_creation sc
     LEFT JOIN student_history sh ON sc.student_id = sh.student_id
        WHERE
           sh.standard = '$standardList->standard_id' AND sh.academic_year = '$academicyear' AND
       sc.leaving_term!=1 AND sc.leaving_term!=5  AND sc.school_id = '$school_id' AND sc.status = 0
    )
    ) -(
    SELECT
        COALESCE( (
            SUM(afd.fee_received) + SUM(afd.scholarship)
        ),0)
    FROM
        admission_fees_details afd
    JOIN admission_fees af ON
        afd.admission_fees_ref_id = af.id
    JOIN student_creation sc ON
        sc.student_id = af.admission_id
    LEFT JOIN student_history sh ON sc.student_id = sh.student_id
    WHERE
        afd.fees_id = gcf.grp_course_id && afd.fees_table_name = 'grptable' AND sh.standard = '$standardList->standard_id' AND sc.school_id = '$school_id' AND sc.status = 0 AND sh.academic_year='$academicyear'
    ) AS termPending_for_standard
    FROM
        fees_master fm
    JOIN group_course_fee gcf ON
        fm.fees_id = gcf.fee_master_id
    WHERE
        fm.academic_year = '$academicyear' && fm.medium = '$stdMedium' && fm.standard = '$standardList->standard_id' && fm.school_id = '$school_id'
    ORDER BY gcf.grp_course_id ASC ");
            $term_pending = array();
            while ($termPendingInfo = $getTermPendingQry->fetch()) {
                $term_pending[] = $termPendingInfo['termPending_for_standard'];
            }

            $getBookPendingQry = $connect->query("SELECT ( 
        COALESCE(af.amenity_amount, 0) *(
        SELECT
         COUNT(sh.student_id) AS student_count
        FROM
            student_creation sc
     LEFT JOIN student_history sh ON sc.student_id = sh.student_id
        WHERE
           sh.standard = '$standardList->standard_id' AND sh.academic_year = '$academicyear' AND
       sc.leaving_term!=1 AND sc.leaving_term!=5  AND sc.school_id = '$school_id' AND sc.status = 0
    )
    ) - 
    (
        SELECT
             COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0)
        FROM
            admission_fees_details afd
        JOIN admission_fees af ON
            afd.admission_fees_ref_id = af.id
        JOIN student_creation sc ON
            sc.student_id = af.admission_id
        JOIN student_history sh ON sc.student_id = sh.student_id
        WHERE
            afd.fees_id = af.amenity_fee_id && afd.fees_table_name = 'amenitytable' AND sh.standard = '$standardList->standard_id'AND sc.status = 0 AND sh.academic_year='$academicyear'
        ) AS bookpending_for_standard
    FROM
        fees_master fm
    JOIN amenity_fee af ON fm.fees_id = af.fee_master_id
    WHERE fm.academic_year = '$academicyear' && fm.medium = '$stdMedium' && fm.standard = '$standardList->standard_id' && fm.school_id = '$school_id' ");
            if ($getBookPendingQry->rowCount() > 0) {
                $book_pending = $getBookPendingQry->fetch()['bookpending_for_standard'];
            } else {
                $book_pending = '0';
            }
            $extra_pending = [
                'uniform' => 0,
                'admission' => 0,
                'eca' => 0
            ];


            $getExtraPendingQry = $connect->query("
    SELECT 
        ecaf.extra_particulars,
        (
            (ecaf.extra_amount * COUNT(DISTINCT sh.student_id)) -
            (
                (
                    SELECT 
                        COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0)
                    FROM 
                        admission_fees_details afd
                    JOIN admission_fees af ON afd.admission_fees_ref_id = af.id
                    JOIN student_creation sc2 ON sc2.student_id = af.admission_id
                    JOIN student_history sh2 ON sh2.student_id = sc2.student_id
                    WHERE 
                        FIND_IN_SET(ecaf.extra_fee_id, sh2.extra_curricular) > 0
                        AND afd.fees_id = ecaf.extra_fee_id
                        AND afd.fees_table_name = 'extratable'
                        AND sh2.standard = '$standardList->standard_id'
                        AND sh2.academic_year = '$academicyear'
                        AND sc2.leaving_term NOT IN (1, 5)
                        AND sc2.status = 0
                ) +
                (
                    SELECT 
                        COALESCE(SUM(fc.scholarship_amount), 0)
                    FROM 
                        fees_concession fc
                    JOIN student_creation sc3 ON sc3.student_id = fc.student_id
                    JOIN student_history sh3 ON sh3.student_id = sc3.student_id
                    WHERE 
                        FIND_IN_SET(ecaf.extra_fee_id, sh3.extra_curricular) > 0
                        AND fc.fees_id = ecaf.extra_fee_id
                        AND fc.fees_table_name = 'extratable'
                        AND sh3.standard = '$standardList->standard_id'
                        AND sh3.academic_year = '$academicyear'
                        AND sc3.leaving_term NOT IN (1, 5)
                        AND sc3.status = 0
                )
            )
        ) AS extraPending
    FROM student_history sh
    JOIN student_creation sc ON sc.student_id = sh.student_id
    JOIN extra_curricular_activities_fee ecaf ON FIND_IN_SET(ecaf.extra_fee_id, sh.extra_curricular) > 0
    WHERE 
        sh.academic_year = '$academicyear'
        AND sh.standard = '$standardList->standard_id'
        AND sc.leaving_term NOT IN (1, 5)
        AND sc.status = 0
    GROUP BY ecaf.extra_fee_id
");

            $extra_pending[$standardList->standard_id] = [
                'uniform' => 0,
                'admission' => 0,
                'eca' => 0
            ];

            if ($getExtraPendingQry->rowCount() > 0) {
                while ($extrapendingInfo = $getExtraPendingQry->fetch()) {
                    $particular = strtolower(trim($extrapendingInfo['extra_particulars']));
                    $pending = (float)$extrapendingInfo['extraPending'];

                    if (strpos($particular, 'uniform') !== false) {
                        $extra_pending[$standardList->standard_id]['uniform'] += $pending;
                    } elseif (strpos($particular, 'admission') !== false) {
                        $extra_pending[$standardList->standard_id]['admission'] += $pending;
                    } elseif (strpos($particular, 'eca') !== false || strpos($particular, 'activity') !== false) {
                        $extra_pending[$standardList->standard_id]['eca'] += $pending;
                    }
                }
            }




            $getTransportPendingQry = $connect->query("SELECT 
    SUM(CASE WHEN is_min = 1 THEN transport_pending ELSE 0 END) AS total_transport_min,
    SUM(CASE WHEN is_max = 1 THEN transport_pending ELSE 0 END) AS total_transport_max,
    SUM(CASE WHEN is_middle = 1 THEN transport_pending ELSE 0 END) AS total_transport_middle
FROM (
    SELECT 
        acp.particulars_id,
        ac.area_id,
        acp.due_amount,
        (
            COALESCE(acp.due_amount, 0) * COALESCE(sc.student_count, 0)
        ) - (
            SELECT COALESCE(
                SUM(tafd.fee_received) + SUM(tafd.scholarship), 0
            )
            FROM transport_admission_fees taf
            JOIN transport_admission_fees_details tafd 
                ON taf.id = tafd.admission_fees_ref_id
            JOIN student_creation sc 
                ON sc.student_id = taf.admission_id
             JOIN student_history sh 
                ON sc.student_id = sh.student_id
            WHERE 
                tafd.area_creation_particulars_id = acp.particulars_id 
                AND sh.standard = '$standardList->standard_id' 
                AND sc.school_id = '$school_id' 
                AND sh.academic_year = '$academicyear' 
                AND sc.leaving_term NOT IN (1, 5) AND sc.status = 0
        ) AS transport_pending,
        CASE 
            WHEN acp.particulars_id = (SELECT MIN(acp1.particulars_id) 
                                       FROM area_creation_particulars acp1 
                                       WHERE acp1.area_creation_id = ac.area_id) 
            THEN 1 ELSE 0 
        END AS is_min,
        CASE 
            WHEN acp.particulars_id = (SELECT MAX(acp1.particulars_id) 
                                       FROM area_creation_particulars acp1 
                                       WHERE acp1.area_creation_id = ac.area_id) 
            THEN 1 ELSE 0 
        END AS is_max,
        CASE 
            WHEN acp.particulars_id NOT IN (
                SELECT MIN(acp1.particulars_id) 
                FROM area_creation_particulars acp1 
                WHERE acp1.area_creation_id = ac.area_id
            ) 
            AND acp.particulars_id NOT IN (
                SELECT MAX(acp1.particulars_id) 
                FROM area_creation_particulars acp1 
                WHERE acp1.area_creation_id = ac.area_id
            ) 
            THEN 1 ELSE 0 
        END AS is_middle
    FROM area_creation ac
    JOIN area_creation_particulars acp 
        ON ac.area_id = acp.area_creation_id
    LEFT JOIN (
        SELECT sh.transportarearefid AS area_id,
               COUNT(DISTINCT sh.student_id) AS student_count
        FROM student_creation sc
        JOIN student_history sh 
            ON sc.student_id = sh.student_id
        WHERE 
            sh.standard = '$standardList->standard_id' 
            AND sh.academic_year = '$academicyear' 
            AND sc.leaving_term NOT IN (1, 5) 
            AND sc.school_id = '$school_id' AND sc.status = 0
        GROUP BY sh.transportarearefid
    ) sc 
        ON ac.area_id = sc.area_id
    WHERE ac.year_id = '$academicyear'
) AS categorized_particulars;");
            $transport_pending = array();

            $transportPendingInfo = $getTransportPendingQry->fetch(PDO::FETCH_ASSOC);
            // Assign values
            $transport_term1 = isset($transportPendingInfo['total_transport_min']) ? $transportPendingInfo['total_transport_min'] : 0;
            $transport_term2 = isset($transportPendingInfo['total_transport_middle']) ? $transportPendingInfo['total_transport_middle'] : 0;
            $transport_term3 = isset($transportPendingInfo['total_transport_max']) ? $transportPendingInfo['total_transport_max'] : 0;

            // Display results

            // Calculate totals
            $term1 = isset($term_pending[0]) ? $term_pending[0] : 0;
            $term2 = isset($term_pending[1]) ? $term_pending[1] : 0;
            $term3 = isset($term_pending[2]) ? $term_pending[2] : 0;
           $getScholarshipTotalQry = $connect->query("
    SELECT (
        -- Total from fees_concession table
        COALESCE((
            SELECT SUM(fc.scholarship_amount)
            FROM fees_concession fc
            JOIN student_creation s ON fc.student_id = s.student_id
            WHERE s.standard = '$standardList->standard_id' AND fc.academic_year = '$academicyear'
        ), 0)
        +
        -- Total from admission_fees_details table
        COALESCE((
            SELECT SUM(afd.scholarship)
            FROM admission_fees_details afd
            JOIN admission_fees af ON afd.admission_fees_ref_id = af.id
            JOIN student_creation s ON af.admission_id = s.student_id
            WHERE s.standard = '$standardList->standard_id' AND af.academic_year = '$academicyear'
        ), 0)
        +
        -- Total from transport_admission_fees_details table
        COALESCE((
            SELECT SUM(tafd.scholarship)
            FROM transport_admission_fees_details tafd
            JOIN transport_admission_fees taf ON tafd.admission_fees_ref_id = taf.id
            JOIN student_creation s ON taf.admission_id = s.student_id
            WHERE s.standard = '$standardList->standard_id' AND taf.academic_year = '$academicyear'
        ), 0)
        +
        -- Total from last year table
        COALESCE((
            SELECT SUM(lfd.scholarship)
            FROM last_year_fees lf
            JOIN last_year_fees_details lfd ON lfd.admission_fees_ref_id = lf.id
            JOIN student_creation s ON lf.admission_id = s.student_id
            WHERE s.standard = '$standardList->standard_id' AND lf.academic_year = '$academicyear'
        ), 0)
    ) AS totalScholarship
");

              $scholarshipRow = $getScholarshipTotalQry->fetch();
            $scholarship = $scholarshipRow['totalScholarship'] ?? 0;
            $admission = $extra_pending[$standardList->standard_id]['admission'] ?? 0;
            $uniform = $extra_pending[$standardList->standard_id]['uniform'] ?? 0;
            $eca = $extra_pending[$standardList->standard_id]['eca'] ?? 0;

        ?>
            <tr>
                <td><?php echo $standardList->standard; ?></td>
                  <td class="text-right"><?php echo $lsPending; ?></td>
                <td class="text-right"><?php echo  $extra_pending[$standardList->standard_id]['admission'] ?? 0; ?></td>
                <td class="text-right"><?php echo $extra_pending[$standardList->standard_id]['uniform'] ?? 0; ?></td>
                <td class="text-right"><?php echo $book_pending; ?></td>
                <td class="text-right"><?php echo $term1; ?></td>
                <td class="text-right"><?php echo $term2; ?></td>
                <td class="text-right"><?php echo $term3; ?></td>
                <td class="text-right"><?php echo $transport_term1; ?></td>
                <td class="text-right"><?php echo $transport_term2; ?></td>
                <td class="text-right"><?php echo $transport_term3; ?></td>
                <td class="text-right"><?php echo $extra_pending[$standardList->standard_id]['eca'] ?? 0; ?></td>
                <td class="text-right"><?php echo $scholarship ?></td>

                <?php
                $grand_total = $lsPending + $admission + $uniform + $eca + $term1 + $term2 + $term3 + $book_pending + $transport_term1 + $transport_term2 + $transport_term3 + $scholarship;
                ?>
                <td class="text-right" style="font-weight: bold;"><?php echo $grand_total; ?></td>

            </tr>
        <?php
            $grand_term1 += $term1;
            $grand_term2 += $term2;
            $grand_term3 += $term3;
            $grand_book += $book_pending;
            $grand_last += $lsPending;
            $grand_extra += $extra_pending[$standardList->standard_id]['eca'] ?? 0;
            $grand_admission += $extra_pending[$standardList->standard_id]['admission'] ?? 0;
            $grand_uniform +=  $extra_pending[$standardList->standard_id]['uniform'] ?? 0;
            $grand_transport_term1 += $transport_term1;
            $grand_transport_term2 += $transport_term2;
            $grand_concession += $scholarship ?? 0;
            $grand_overall_total += $grand_total;
        } ?>
        <tr style="font-weight: bold;">
            <td>Grand Total</td>
             <td class="text-right"><?php echo $grand_last; ?></td>
            <td class="text-right"><?php echo $grand_admission; ?></td>
            <td class="text-right"><?php echo $grand_uniform; ?></td>
            <td class="text-right"><?php echo $grand_book; ?></td>
            <td class="text-right"><?php echo $grand_term1; ?></td>
            <td class="text-right"><?php echo $grand_term2; ?></td>
            <td class="text-right"><?php echo $grand_term3; ?></td>
            <td class="text-right"><?php echo $grand_transport_term1; ?></td>
            <td class="text-right"><?php echo $grand_transport_term2; ?></td>
            <td class="text-right"><?php echo $grand_transport_term3; ?></td>
            <td class="text-right"><?php echo $grand_extra; ?></td>
            <td class="text-right"><?php echo $grand_concession; ?></td>
            <td class="text-right"><?php echo $grand_overall_total; ?></td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#show_student_allPending_list').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    text: 'Print',
                    customize: function(win) {
                        $(win.document.body).css('width', '100%'); // Ensure full-width print
                    },
                    autoPrint: true
                }
            ],
            paging: false,
            sort: false,
        });
    });
</script>