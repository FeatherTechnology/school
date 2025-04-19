<?php
include '../ajaxconfig.php';
@session_start();
if (isset($_SESSION["userid"])) {
    $academic_year = $_SESSION["academic_year"];
}

$errors = [];

if (isset($_POST['admission_fees_ref_id'])) {
    $admissionFeesRefId = $_POST['admission_fees_ref_id'];
    $admissionFormId = $_POST['admissionFormId'];

    // Transport Fees
    if (isset($_POST['transport_fees_data'])) {
        foreach ($_POST['transport_fees_data'] as $fee) {
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
                        transport_admission_fees af 
                        JOIN transport_admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
                    WHERE 
                        af.admission_id = '$admissionFormId' 
                        AND afd.area_creation_particulars_id = '$feesMasterId' 
                        AND afd.admission_fees_ref_id != '$admissionFeesRefId' 
                        AND af.academic_year = '$academic_year'
                ) AS total_paid 
            FROM 
                fees_concession 
            WHERE 
                student_id = '$admissionFormId' 
                AND fees_table_name = 'transport' 
                AND fees_id = '$feesMasterId' 
                AND academic_year = '$academic_year'
        ");
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $grpScholarAmt = $result['grp_schlrshp_amnt'] ?? 0;
        $totalAlreadyPaid = $result['total_paid'] ?? 0;
            $newTotal = $totalAlreadyPaid + $currentReceived + $currentScholar +  $grpScholarAmt;
      
            $feeDetail = $connect->query("SELECT afd.area_creation_particulars_id, gc.due_amount FROM transport_admission_fees_details afd 
                                           JOIN area_creation_particulars gc ON afd.area_creation_particulars_id = gc.particulars_id 
                                           WHERE afd.area_creation_particulars_id = '$feesMasterId'")->fetch(PDO::FETCH_ASSOC);
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
?>
