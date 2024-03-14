<?php 
include "../ajaxconfig.php";
@session_start();
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}

$getStudentCount = $connect->query("SELECT 
SUM(CASE WHEN gender='Male' THEN 1 ELSE 0 END) AS boysCount, 
SUM(CASE WHEN gender='Female' THEN 1 ELSE 0 END) AS girlsCount    
FROM `student_creation` WHERE status = 0 && school_id = '$school_id' ");
$studentInfo = $getStudentCount->fetchObject();


$getStaffCount = $connect->query("SELECT 
SUM(CASE WHEN designation='Teaching' THEN 1 ELSE 0 END) AS teachingstaffCount, 
SUM(CASE WHEN designation='Non-Teaching' THEN 1 ELSE 0 END) AS nonteachingstaffCount,    
SUM(CASE WHEN designation='Driver' THEN 1 ELSE 0 END) AS driverCount    
FROM `staff_creation` WHERE status = 0 && school_id = '$school_id' ");
$staffInfo = $getStaffCount->fetchObject();

$getCountArr = array("boysCount"=>$studentInfo->boysCount, "girlsCount"=>$studentInfo->girlsCount, "teachingstaffCount"=>$staffInfo->teachingstaffCount, "nonteachingstaffCount"=>$staffInfo->nonteachingstaffCount, "driverCount"=>$staffInfo->driverCount);

echo  json_encode($getCountArr);
?>