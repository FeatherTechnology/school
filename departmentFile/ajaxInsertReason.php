<?php
include '../ajaxconfig.php';

if (isset($_POST['department_id'])) {
    $department_id = $_POST['department_id'];
}

if (isset($_POST['department_name'])) {
    $department_name = $_POST['department_name'];
}

$depNme='';
$depStatus='';
$selectDepartment=$con->query("SELECT * FROM department_creation WHERE department_name = '".$department_name."' ");
while ($row=$selectDepartment->fetch_assoc()){
	$depNme    = $row["department_name"];
	$depStatus  = $row["status"];
}

if($depNme != '' && $depStatus == 0){
	$message="Department Already Exists, Please Enter a Different Name!";
}
else if($depNme != '' && $depStatus == 1){
	$updateDepartment=$con->query("UPDATE department_creation SET status=0 WHERE department_name='".$department_name."' ");
	$message="Department Added Succesfully";
}
else{
	if($department_id>0){
		$updateDepartment=$con->query("UPDATE department_creation SET department_name='".$department_name."' WHERE department_id='".$department_id."' ");
		if($updateDepartment == true){
		    $message="Department Updated Succesfully";
	    }
    }
	else{
	    $insertDepartment=$con->query("INSERT INTO department_creation(department_name) VALUES('".strip_tags($department_name)."')");
	    if($insertDepartment == true){
		    $message="Department Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>