<?php
include '../ajaxconfig.php';
@session_start();

if (isset($_SESSION["userid"])) {
    $academic_year = $_SESSION["academic_year"];
}

// Get the last receipt number
$selectIC = $mysqli->query("SELECT receipt_no FROM transport_admission_fees 
                            WHERE receipt_no != '' AND academic_year = '$academic_year' 
                            ORDER BY id DESC LIMIT 1");

if ($selectIC->num_rows > 0) {
    $r_no = $selectIC->fetch_assoc()["receipt_no"];
    $splited = explode('/', $r_no);

    // Extract only the last numeric part
    $last_number = intval(end($splited));

    // Increment the last number
    $new_number = $last_number + 1;

    // Construct the new receipt number
    $receipt_number = "TARC/$academic_year/" . $new_number;
} else {
    $receipt_number = "TARC/$academic_year/1"; // Start from 1 if no previous records
}

echo json_encode($receipt_number);
?>
