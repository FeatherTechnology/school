<?php
include '../../ajaxconfig.php';

if(isset($_POST["fees_id"])){
	$fees_id  = $_POST["fees_id"];
}

$getct = "SELECT * FROM fees_master WHERE fees_id = '".$fees_id."' AND status=0 AND grp_status = 1";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $grp_particulars = $row['grp_particulars'];
    $grp_amount= $row['grp_amount'];
    $grp_ledger_name= $row['grp_ledger_name'];
}

$feeDetails['grp_particulars'] = $grp_particulars;
$feeDetails['grp_amount'] = $grp_amount;
$feeDetails['grp_ledger_name'] = $grp_ledger_name;

echo json_encode($feeDetails);

?>