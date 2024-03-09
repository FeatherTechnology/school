<?php
//Also using in student_transport_list.js
include "../../ajaxconfig.php";
@session_start();
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}
if(isset($_POST['academicYear'])){
    $academic_year = $_POST['academicYear'];
}
if(isset($_POST['medium'])){
    $medium = $_POST['medium'];
}
if(isset($_POST['standardID'])){
    $standardID = $_POST['standardID'];
}

    $getSectionQry = $connect->query("SELECT section FROM student_creation WHERE medium = '$medium' AND standard = '$standardID' AND school_id='$school_id' AND year_id = '$academic_year' AND status = 0 GROUP BY section");

    $sectionNameArr = array();
    if($getSectionQry->rowCount() > 0){
        while($sectionInfo = $getSectionQry->fetch()) {
            $sectionNameArr[] = $sectionInfo['section']; 
        }
    }


    echo json_encode($sectionNameArr);

?>