<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_POST["item_id"])){
	$item_id=$_POST["item_id"];
}

$itemdetarray = array();

$getTable = $con->query("SELECT * FROM item_creation WHERE item_id = '".$item_id."' ") or die("Error");
if($getTable->num_rows>0){
	
	$getitemdetails=$con->query("SELECT * FROM item_creation WHERE item_id='".$item_id."' ");
	while($row=$getitemdetails->fetch_assoc()){
	$itemdetarray["description"]     =  $row["description"];
	$itemdetarray["rate"]      =  $row["rate"];
    }

}

echo json_encode($itemdetarray);
?>