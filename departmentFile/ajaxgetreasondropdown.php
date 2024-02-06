<?php 
include('../ajaxconfig.php');
$departmentarr = array();
$result=$mysqli->query("SELECT * FROM department_creation where 1 and status=0");
while( $row = $result->fetch_assoc()){
      $department_id = $row['department_id'];
      $department_name = $row['department_name'];
      $departmentarr[] = array("department_id" => $department_id, "department_name" => $department_name);
   }
echo json_encode($departmentarr);
?>