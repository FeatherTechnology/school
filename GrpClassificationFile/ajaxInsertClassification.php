<?php
include '../ajaxconfig.php';

if (isset($_POST['grp_classification_id'])) {
    $grp_classification_id  = $_POST['grp_classification_id'];
}

if (isset($_POST['grp_classification_name'])) {
    $grp_classification_name = $_POST['grp_classification_name'];
}

$depNme='';
$depStatus='';
$selectDepartment=$mysqli->query("SELECT * FROM grp_classification WHERE grp_classification_name = '".$grp_classification_name."' ");
while ($row=$selectDepartment->fetch_assoc()){
	$depNme    = $row["grp_classification_name"];
	$depStatus  = $row["status"];
}

if($depNme != '' && $depStatus == 0){
	$message="Classification Already Exists, Please Enter a Different Name!";
}
else if($depNme != '' && $depStatus == 1){
	$updateDepartment=$mysqli->query("UPDATE grp_classification SET status=0 WHERE grp_classification_name='".$grp_classification_name."' ");
	$message="Classification Added Succesfully";
}
else{
	if($grp_classification_id >0){
		$updateDepartment=$mysqli->query("UPDATE grp_classification SET grp_classification_name='".$grp_classification_name."' WHERE grp_classification_id ='".$grp_classification_id ."' ");
		if($updateDepartment == true){
		    $message="Classification Updated Succesfully";
	    }
    }
	else{
	    $insertDepartment=$mysqli->query("INSERT INTO grp_classification(grp_classification_name) VALUES('".strip_tags($grp_classification_name)."')");
	    if($insertDepartment == true){
		    $message="Classification Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>