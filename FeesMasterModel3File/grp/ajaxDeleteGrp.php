<?php
include '../../ajaxconfig.php';

if(isset($_POST["fees_id"])){
	$fees_id  = $_POST["fees_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM fees_master WHERE grp_particulars = '".$fees_id."' ");
while($row=$ctqry->fetch_assoc()){

	$isdel=$row["grp_particulars"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Fees";
}
else
{ 
	$delct=$con->query("UPDATE fees_master SET status = 1 WHERE fees_id = '".$fees_id."' ");
	if($delct){
		$message="Fees Inactivated Successfully";
	}
}

echo json_encode($message);
?>