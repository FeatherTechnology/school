<?php
include '../ajaxconfig.php';

if(isset($_POST["ponum"])){
	$ponum=$_POST["ponum"];
}
$getpo = $mysqli->query("SELECT vendor FROM purchaseorder WHERE ponumber = '".$ponum."' ");
while ($row = $getpo->fetch_assoc()) {
	$vendor = $row["vendor"];
}

$getvendor = $mysqli->query("SELECT contact FROM vendor WHERE vendorid = '".$vendor."' ");
while ($row = $getvendor->fetch_assoc()) {
	$contact = $row["contact"];
}

echo json_encode($contact);
?>