<?php
include('../ajaxconfig.php');
if(isset($_POST["purposeid"])){
	$purposeid  = $_POST["purposeid"];
}
$isdel='';
$message='';
$isavl = $mysqli->query("SELECT * FROM bankmaster WHERE purpose = '".$purposeid."' ");
while($row=$isavl->fetch_assoc()){
	$isdel = $row["purpose"];
}

if($isdel!=''){
	$message="You Don't Have Rights To Delete This Purpose";
}
else
{
	$deletepurpose=$mysqli->query("UPDATE purpose SET status = 1 WHERE purposeid='".$purposeid."' ");
	if($deletepurpose){
		$message="Purpose Inactivated Successfully";
	}
}
echo json_encode($message);
?>