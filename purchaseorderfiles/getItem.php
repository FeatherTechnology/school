<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}
if(isset($_POST["vendorid"])){
	$vendorid = $_POST["vendorid"];
}

$account1id = array();
$item_id = array();
$item_code = array();
$description   = array();
$itemname2   = array();
$rate   = array();


	$getitem1 = $con->query("SELECT * FROM item_creation WHERE status = 0 GROUP BY item_id ") or die("Error :".$con->error);
	while ($row=$getitem1->fetch_assoc()){
		// $account1id[] = $row["account1id"];
		$item_id[] = $row["item_id"];
		$description[]   = $row["description"];
		$item_code[]   = $row["item_code"];
		$rate[]   = $row["rate"];
	}


// $item["account1id"] = $account1id
$item["item_id"] = $item_id;
$item["description"] = $description;
$item["item_code"] = $item_code;
$item["rate"] = $rate;

echo json_encode($item);
?>