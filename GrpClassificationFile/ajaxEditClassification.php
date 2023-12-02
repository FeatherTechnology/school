<?php
include '../ajaxconfig.php';

if(isset($_POST["grp_classification_id"])){
	$grp_classification_id = $_POST["grp_classification_id"]; 
}

$getct = "SELECT * FROM grp_classification WHERE grp_classification_id = '".$grp_classification_id ."' AND status=0"; 
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $grp_classification_name = $row['grp_classification_name']; 
} 

echo $grp_classification_name; 
?>