<?php
include '../ajaxconfig.php';

if(isset($_POST["grp_classification_id "])){
	$grp_classification_id   = $_POST["grp_classification_id "];
}
$isdel = '';

$ctqry=$mysqli->query("SELECT * FROM grp_classification WHERE grp_classification_name = '".$grp_classification_id ."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["grp_classification_name"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Classification";
}
else
{ 
	$delct=$mysqli->query("UPDATE grp_classification SET status = 1 WHERE grp_classification_id  = '".$grp_classification_id ."' ");
	if($delct){
		$message="Classification Inactivated Successfully";
	}
}

echo json_encode($message);
?>