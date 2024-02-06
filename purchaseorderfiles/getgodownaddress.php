<?php
include '../ajaxconfig.php';

if(isset($_POST["godownid"])){
	$godownid = $_POST["godownid"];
}
$godownid1 = ltrim($godownid, 'g');
$getgodown=$mysqli->query("SELECT * FROM godown WHERE godownid='".$godownid1."' AND status = 0");
while($row=$getgodown->fetch_assoc()){
	$godownname = $row["godownname"];
	$address    = $row["address"];
	$address1   = $row["address1"];
	$address2   = $row["address2"];
	$pincode    = $row["pincode"];
	$state      = $row["state"];
	$country    = $row["country"];
	$phonenumber= $row["phonenumber"];
}
$godownaddress["godownname"] = $godownname;
$godownaddress["address"]    = $address;
$godownaddress["address1"]   = $address1;
$godownaddress["address2"]   = $address2;
$godownaddress["pincode"]    = $pincode;
$godownaddress["state"]      = $state;
$godownaddress["country"]    = $country;
$godownaddress["phonenumber"]= $phonenumber;

echo json_encode($godownaddress);
?>