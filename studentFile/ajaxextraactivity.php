<?php
include('../ajaxconfig.php');
@session_start();

if (isset($_POST['mediums'])) {
    $mediums = $_POST['mediums']; 
} 

if (isset($_POST['standards'])) {
    $standards = $_POST['standards'];
}

if (isset($_SESSION['school_id'])) {
    $school_id = $_SESSION['school_id']; 
} 

if (isset($_SESSION['academic_year'])) {
    $year_id = $_SESSION['academic_year'];
}
if (isset($_POST['studentstype'])) {
    $studentstype = $_POST['studentstype'];
}else{
    $studentstype = '0';
}
if($mediums == '' && $standards == ''){
	$qry = "SELECT fm.fees_id, ecaf.extra_fee_id, ecaf.extra_particulars, ecaf.extra_amount  FROM `fees_master` fm JOIN `extra_curricular_activities_fee` ecaf ON fm.fees_id = ecaf.fee_master_id WHERE fm.academic_year = '$year_id' AND school_id = '$school_id' AND fm.extra_status = '1' AND fm.status = '0'"; 

}else{
    $qry = "SELECT fm.fees_id, ecaf.extra_fee_id, ecaf.extra_particulars, ecaf.extra_amount  FROM `fees_master` fm JOIN `extra_curricular_activities_fee` ecaf ON fm.fees_id = ecaf.fee_master_id WHERE 
    fm.academic_year = '$year_id' AND fm.medium = '$mediums' AND fm.student_type = '$studentstype' AND fm.standard = '$standards' AND fm.extra_status = '1' AND school_id = '$school_id' AND fm.status = '0'";
}

$res = $mysqli->query($qry) or die("Error in Get All Records: " . $mysqli->error);

$extracurArr = array();
while ($ct = $res->fetch_assoc()) {
    $extracurArr[] = array(
        "extra_fee_id"=> $ct["extra_fee_id"],
        "extra_particulars"=> $ct['extra_particulars'],
        "extra_amount"=> $ct['extra_amount']
    );
}
echo json_encode($extracurArr);
?>