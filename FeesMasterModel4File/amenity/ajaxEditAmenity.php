<?php
include '../../ajaxconfig.php';

if(isset($_POST["fees_id"])){
	$fees_id  = $_POST["fees_id"];
}

$getct = "SELECT * FROM fees_master WHERE fees_id = '".$fees_id."' AND status=0 AND amenity_status = 1";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $amenity_particulars = $row['amenity_particulars'];
    $amenity_amount= $row['amenity_amount'];
}

$feeDetails['amenity_particulars'] = $amenity_particulars;
$feeDetails['amenity_amount'] = $amenity_amount;

echo json_encode($feeDetails);

?>