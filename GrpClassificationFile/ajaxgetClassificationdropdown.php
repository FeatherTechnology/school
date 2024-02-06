<?php 
include('../ajaxconfig.php');
$departmentarr = array();
$result=$mysqli->query("SELECT * FROM grp_classification WHERE 1 AND status=0");
while( $row = $result->fetch_assoc()){
      $grp_classification_id  = $row['grp_classification_id']; 
      $grp_classification_name = $row['grp_classification_name'];
      $departmentarr[] = array("grp_classification_id" => $grp_classification_id , "grp_classification_name" => $grp_classification_name);
   }
echo json_encode($departmentarr);
?>