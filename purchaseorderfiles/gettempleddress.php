<?php
include '../ajaxconfig.php';

if(isset($_POST["temple_id"])){
	$temple_id=$_POST["temple_id"]; 
}

$gettemple=$con->query("SELECT * FROM temple_creation WHERE temple_id='".$temple_id."' AND status = 0");
while($row=$gettemple->fetch_assoc()){
	$temple_name=$row["temple_name"]; 
	$address1=$row["address1"];
	$address2=$row["address2"];
	$city=$row["city"];
	$state=$row["state"];
	$contact_number=$row["contact_number"];
	$office_number=$row["office_number"];
}
$templeaddress["temple_name"]=$temple_name;
$templeaddress["address1"]=$address1;
$templeaddress["address2"]=$address2;
$templeaddress["city"]=$city;
$templeaddress["state"]=$state;
$templeaddress["contact_number"]=$contact_number;
$templeaddress["office_number"]=$office_number;

echo json_encode($templeaddress);
?>