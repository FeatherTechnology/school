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
            $totalAlreadyPaid = ($connect->query(" SELECT (COALESCE(SUM(afd.scholarship),0) + COALESCE(SUM(afd.fee_received),0)) AS  total_paid  FROM `last_year_fees` af JOIN last_year_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && afd.fees_table_name = 'grptable' AND afd.fees_id = '$feesMasterId' AND afd.admission_fees_ref_id != '$admissionFeesRefId' AND af.academic_year = '$academic_year' ")
            ->fetch(PDO::FETCH_ASSOC)['total_paid'] ?? 0);
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar ;

            $feeDetail = $connect->query("SELECT afd.fees_id, gc.grp_amount FROM last_year_fees_details afd 
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
            $totalAlreadyPaid = ($connect->query(" SELECT (COALESCE(SUM(afd.scholarship),0) + COALESCE(SUM(afd.fee_received),0))  AS  total_paid FROM `last_year_fees` af JOIN last_year_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && afd.fees_table_name = 'extratable' AND afd.fees_id = '$feesMasterId' AND afd.admission_fees_ref_id != '$admissionFeesRefId' AND af.academic_year = '$academic_year' ")
            ->fetch(PDO::FETCH_ASSOC)['total_paid'] ?? 0);
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar ;
            $feeDetail = $connect->query("SELECT afd.fees_id, ec.extra_amount FROM last_year_fees_details afd 
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

            $totalAlreadyPaid = ($connect->query(" SELECT (COALESCE(SUM(afd.scholarship),0) + COALESCE(SUM(afd.fee_received),0))  AS  total_paid  FROM `last_year_fees` af JOIN last_year_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && afd.fees_table_name = 'amenitytable' AND afd.fees_id = '$feesMasterId' AND afd.admission_fees_ref_id != '$admissionFeesRefId' AND af.academic_year = '$academic_year' ")
            ->fetch(PDO::FETCH_ASSOC)['total_paid'] ?? 0);
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar ;
            $feeDetail = $connect->query("SELECT afd.fees_id, am.amenity_amount FROM last_year_fees_details afd 
                                           JOIN amenity_fee am ON afd.fees_id = am.amenity_fee_id 
                                           WHERE afd.fees_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
            $totalFee = floatval($feeDetail['amenity_amount'] ?? 0);
            if ($newTotal > $totalFee) {
                $errors[] = "Amenity Fee: Kindly Enter Lesser Value";
            }
        }
    }
    // Transport Fees
    if (isset($_POST['transport_fees_data'])) {
        foreach ($_POST['transport_fees_data'] as $fee) {
            $feesMasterId = $fee['fees_master_id'];
            $currentReceived = floatval($fee['received']);
            $currentScholar = floatval($fee['scholarship']);
            $totalAlreadyPaid = ($connect->query(" SELECT (COALESCE(SUM(afd.scholarship),0) + COALESCE(SUM(afd.fee_received),0))  AS  total_paid  FROM `last_year_fees` af JOIN last_year_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && afd.fees_table_name = 'transport' AND afd.fees_id = '$feesMasterId' AND afd.admission_fees_ref_id != '$admissionFeesRefId' AND af.academic_year = '$academic_year' ")
            ->fetch(PDO::FETCH_ASSOC)['total_paid'] ?? 0);
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar ;

            $feeDetail = $connect->query("SELECT afd.fees_id, gc.due_amount FROM last_year_fees_details afd 
                                               JOIN area_creation_particulars gc ON afd.fees_id = gc.particulars_id 
                                               WHERE afd.fees_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
            $totalFee = floatval($feeDetail['due_amount'] ?? 0);
            if ($newTotal > $totalFee) {
                $errors[] = "Transport Fee: Kindly Enter Lesser Value";
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
