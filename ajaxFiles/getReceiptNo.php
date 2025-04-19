<?php
include '../ajaxconfig.php';
@session_start();

// The receipt number continues when inserting admission_fees and temp_admission_fees,
// so we find the maximum receipt number and then increment it.
if (isset($_SESSION["userid"])) {
    $academic_year = $_SESSION["academic_year"];
}
$getPayFeesQry = $mysqli->query("SELECT receipt_no FROM admission_fees WHERE receipt_no != '' AND academic_year = '$academic_year' ORDER BY id DESC LIMIT 1");
if ($getPayFeesQry->num_rows > 0) {
    $row = $getPayFeesQry->fetch_assoc();
    $receipt_number = $row["receipt_no"];
} else {
    $receipt_number = "GPR/$academic_year/0"; // Corrected the variable parsing
}

$getTempPayFeesQry = $mysqli->query("SELECT ReceiptNo FROM temp_admission_fees WHERE ReceiptNo != '' ORDER BY id DESC LIMIT 1");
if ($getTempPayFeesQry->num_rows > 0) {
    $getdata = $getTempPayFeesQry->fetch_assoc();
    $receiptno = $getdata['ReceiptNo'];
} else {
    $receiptno = "GPR/$academic_year/0"; // Corrected the variable parsing
}

// Extract the last numeric part from both receipt numbers
$receipt_number_parts = explode('/', $receipt_number);
$receiptno_parts = explode('/', $receiptno);

// Get only the last part (numeric value)
$last_number1 = intval(end($receipt_number_parts));
$last_number2 = intval(end($receiptno_parts));

// Get the max number and increment it
$new_number = max($last_number1, $last_number2) + 1;

// Construct the new receipt number
$newReceiptNo = "GPR/$academic_year/" . $new_number;

echo json_encode($newReceiptNo);
?>
