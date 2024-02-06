<?php
include '../ajaxconfig.php';

if(isset($_POST["branchid"])){
	$branchid=$_POST["branchid"];
}
$branchid1 = ltrim($branchid, 'b');
$getbranch =$mysqli->query("SELECT * FROM branch WHERE branchid='".$branchid1."' AND status = 0");
while($row=$getbranch->fetch_assoc()){
	$branchname = $row["branchname"];
	$address    = $row["address"];
	$address1   = $row["address1"];
	$address2   = $row["address2"];
	$pincode    = $row["pincode"];
	$state      = $row["state"];
	$country    = $row["country"];
	$phonenumber= $row["phonenumber"];
}
$gobranchaddress["branchname"] = $branchname;
$gobranchaddress["address"]    = $address;
$gobranchaddress["address1"]   = $address1;
$gobranchaddress["address2"]   = $address2;
$gobranchaddress["pincode"]    = $pincode;
$gobranchaddress["state"]      = $state;
$gobranchaddress["country"]    = $country;
$gobranchaddress["phonenumber"]= $phonenumber;

echo json_encode($gobranchaddress);
?>