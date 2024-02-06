<?php
include '../ajaxconfig.php';

if(isset($_POST["rejectponum"])){
	$rejectponum = $_POST["rejectponum"];
}
if(isset($_POST["rejectreason"])){
	$rejectreason = $_POST["rejectreason"];
}
$rejectqry=$mysqli->query("UPDATE purchaseorder SET rejectreason = '".$rejectreason."', approvedstatus = 2 WHERE ponumber = '".$rejectponum."' ") OR die("Error");
if($rejectqry){
	$message="updated";
}
else{
	$message = "error";
}
echo json_encode($message);
?>