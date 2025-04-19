<?php
include '../../ajaxconfig.php';
@session_start();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
}

$feesid = $_POST['fees_id'] ?? '';
$reason = $_POST['reason'] ?? '';
$feeType = $_POST['fee_type'] ?? '';

$response = [];

if (!empty($feesid) && !empty($reason) && !empty($feeType)) {

    // Map fee type to table
    $table = '';
    switch ($feeType) {
        case 'admission':
            $table = 'admission_fees';
            break;
        case 'transport':
            $table = 'transport_admission_fees';
            break;
        case 'last_year':
            $table = 'last_year_fees'; // ✅ your assumed table name
            break;
    }

    if ($table != '') {
        $updateQuery = "UPDATE $table 
                        SET reason = '$reason', update_login_id = '$userid', updated_on = NOW() 
                        WHERE id = '$feesid'";

        $updateResult = $mysqli->query($updateQuery);

        if ($updateResult) {
            $response['status'] = 1;
            $response['table'] = $table;
            $response['message'] = ucfirst($feeType) . " fee reason updated.";
        } else {
            $response['status'] = 0;
            $response['message'] = "Update failed.";
        }
    } else {
        $response['status'] = 0;
        $response['message'] = "Unknown fee type.";
    }
} else {
    $response['status'] = 0;
    $response['message'] = "Invalid data provided.";
}

echo json_encode($response);
?>
