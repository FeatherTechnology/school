<?php
include '../ajaxconfig.php';
//The receipt no is in continues when insert pay_fees and temp_admission_fees so finding which receipt no is max and then increment the no.
$getPayFeesQry = $mysqli->query("SELECT receipt_number FROM pay_fees WHERE receipt_number != '' ORDER BY pay_fees_id DESC LIMIT 1 ");
if ($getPayFeesQry->num_rows > 0) {
    $row = $getPayFeesQry->fetch_assoc();
    $receipt_number = $row["receipt_number"];

} else {
    $receipt_number = 1;
}

$getTempPayFeesQry = $mysqli->query("SELECT ReceiptNo FROM temp_admission_fees WHERE ReceiptNo != '' ORDER BY id DESC LIMIT 1  ");
if(mysqli_num_rows($getTempPayFeesQry) > 0){
    $getdata = $getTempPayFeesQry->fetch_assoc();
    $receiptno = $getdata['ReceiptNo'];

}else{
    $receiptno = 1;
}
$maxReceiptNo = max($receipt_number, $receiptno);
$newReceiptNo = $maxReceiptNo + 1;

echo json_encode($newReceiptNo);
?>