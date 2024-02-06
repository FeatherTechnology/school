<?php
include '../../ajaxconfig.php';

if(isset($_POST["fees_id"])){
	$fees_id  = $_POST["fees_id"];
}

$getct = "SELECT * FROM fees_master WHERE fees_id = '".$fees_id."' AND status=0 AND extra_status = 1";
$result = $mysqli->query($getct);
while($row=$result->fetch_assoc())
{
    $extra_particulars = $row['extra_particulars'];
    $extra_amount= $row['extra_amount'];
}

$feeDetails['extra_particulars'] = $extra_particulars;
$feeDetails['extra_amount'] = $extra_amount;

echo json_encode($feeDetails);

?>