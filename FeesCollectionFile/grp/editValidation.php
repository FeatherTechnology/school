<?php
include '../../ajaxconfig.php';
@session_start();
if (isset($_SESSION["userid"])) {
    $academic_year = $_SESSION["academic_year"];
}

$errors = [];

if (isset($_POST['admission_fees_ref_id'])) {
    $admissionFeesRefId = $_POST['admission_fees_ref_id'];
    $admissionFormId = $_POST['admissionFormId'];

    // Group Fees
    if (isset($_POST['group_fees_data'])) {
        foreach ($_POST['group_fees_data'] as $fee) {
            $feesMasterId = $fee['fees_master_id'];
            $currentReceived = floatval($fee['received']);
            $currentScholar = floatval($fee['scholarship']);
            $query = $connect->query("
            SELECT 
                COALESCE(SUM(scholarship_amount), 0) AS grp_schlrshp_amnt,
                (
                    SELECT 
                        COALESCE(SUM(afd.scholarship), 0) + COALESCE(SUM(afd.fee_received), 0)
                    FROM 
                        admission_fees af 
                        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
                    WHERE 
                        af.admission_id = '$admissionFormId' 
                        AND afd.fees_table_name = 'grptable' 
                        AND afd.fees_id = '$feesMasterId' 
                        AND afd.admission_fees_ref_id != '$admissionFeesRefId' 
                        AND af.academic_year = '$academic_year'
                ) AS total_paid 
            FROM 
                fees_concession 
            WHERE 
                student_id = '$admissionFormId' 
                AND fees_table_name = 'grptable' 
                AND fees_id = '$feesMasterId' 
                AND academic_year = '$academic_year'
        ");
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $grpScholarAmt = $result['grp_schlrshp_amnt'] ?? 0;
        $totalAlreadyPaid = $result['total_paid'] ?? 0;
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar +  $grpScholarAmt;
      
            $feeDetail = $connect->query("SELECT afd.fees_id, gc.grp_amount FROM admission_fees_details afd 
                                           JOIN group_course_fee gc ON afd.fees_id = gc.grp_course_id 
                                           WHERE afd.fees_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
            $totalFee = floatval($feeDetail['grp_amount'] ?? 0);
            if ($newTotal > $totalFee) {
                $errors[] = "Group Fee: Kindly Enter Lesser Value";
            }
        }
    }

    // Extra Fees
    if (isset($_POST['extra_fees_data'])) {
        foreach ($_POST['extra_fees_data'] as $fee) {
            $feesMasterId = $fee['fees_master_id'];
            $currentReceived = floatval($fee['received']);
            $currentScholar = floatval($fee['scholarship']);
            $query = $connect->query("
            SELECT 
                COALESCE(SUM(scholarship_amount), 0) AS extra_schlrshp_amnt,
                (
                    SELECT 
                        COALESCE(SUM(afd.scholarship), 0) + COALESCE(SUM(afd.fee_received), 0)
                    FROM 
                        admission_fees af 
                        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
                    WHERE 
                        af.admission_id = '$admissionFormId' 
                        AND afd.fees_table_name = 'extratable' 
                        AND afd.fees_id = '$feesMasterId' 
                        AND afd.admission_fees_ref_id != '$admissionFeesRefId' 
                        AND af.academic_year = '$academic_year'
                ) AS total_paid 
            FROM 
                fees_concession 
            WHERE 
                student_id = '$admissionFormId' 
                AND fees_table_name = 'extratable' 
                AND fees_id = '$feesMasterId' 
                AND academic_year = '$academic_year'
        ");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $extra_schlrshp_amnt = $result['extra_schlrshp_amnt'] ?? 0;
        $totalAlreadyPaid = $result['total_paid'] ?? 0;
                       $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar +  $extra_schlrshp_amnt;
            $feeDetail = $connect->query("SELECT afd.fees_id, ec.extra_amount FROM admission_fees_details afd 
                                           JOIN extra_curricular_activities_fee ec ON afd.fees_id = ec.extra_fee_id 
                                           WHERE afd.fees_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
            $totalFee = floatval($feeDetail['extra_amount'] ?? 0);
            if ($newTotal > $totalFee) {
                $errors[] = "Extra Fee: Kindly Enter Lesser Value";
            }
        }
    }

    // Amenity Fees
    if (isset($_POST['amenity_fees_data'])) {
        foreach ($_POST['amenity_fees_data'] as $fee) {
            $feesMasterId = $fee['fees_master_id'];
            $currentReceived = floatval($fee['received']);
            $currentScholar = floatval($fee['scholarship']);
            
            $query = $connect->query("
            SELECT 
                COALESCE(SUM(scholarship_amount), 0) AS amnScholarAmt,
                (
                    SELECT 
                        COALESCE(SUM(afd.scholarship), 0) + COALESCE(SUM(afd.fee_received), 0)
                    FROM 
                        admission_fees af 
                        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
                    WHERE 
                        af.admission_id = '$admissionFormId' 
                        AND afd.fees_table_name = 'amenitytable' 
                        AND afd.fees_id = '$feesMasterId' 
                        AND afd.admission_fees_ref_id != '$admissionFeesRefId' 
                        AND af.academic_year = '$academic_year'
                ) AS total_paid 
            FROM 
                fees_concession 
            WHERE 
                student_id = '$admissionFormId' 
                AND fees_table_name = 'amenitytable' 
                AND fees_id = '$feesMasterId' 
                AND academic_year = '$academic_year'
        ");
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $amnScholarAmt = $result['amnScholarAmt'] ?? 0;
        $totalAlreadyPaid = $result['total_paid'] ?? 0;
                                  $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar + $amnScholarAmt;
            $feeDetail = $connect->query("SELECT afd.fees_id, am.amenity_amount FROM admission_fees_details afd 
                                           JOIN amenity_fee am ON afd.fees_id = am.amenity_fee_id 
                                           WHERE afd.fees_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
            $totalFee = floatval($feeDetail['amenity_amount'] ?? 0);
            if ($newTotal > $totalFee) {
                $errors[] = "Amenity Fee: Kindly Enter Lesser Value";
            }
        }
    }
}

if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'message' => implode(" ", $errors)
    ]);
} else {
    echo json_encode(['status' => 'success']);
}
?>
