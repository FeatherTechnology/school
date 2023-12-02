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
    $studentstype = $_POST['0'];
}
if($mediums == '' && $standards == ''){
    
	$qry = "SELECT * FROM fees_master WHERE academic_year = '$year_id' AND school_id = '$school_id'  AND extra_particulars IS NOT NULL AND extra_amount IS NOT NULL AND  status = '0'"; 
   
}else{
	
        $qry = "SELECT * FROM fees_master WHERE academic_year = '$year_id' AND school_id = '$school_id'  AND extra_particulars IS NOT NULL AND extra_amount IS NOT NULL AND medium='$mediums' AND standard='$standards' AND student_type = '$studentstype' AND status = '0'";
   
}

// $qry = "SELECT * FROM fees_master WHERE academic_year = '$year_id' AND school_id = '$school_id'  AND extra_particulars IS NOT NULL AND extra_amount IS NOT NULL AND medium='$mediums' AND standard='$standards' AND status = '0'"; 
$res = $mysqli->query($qry) or die("Error in Get All Records: " . $mysqli->error);

$detailrecords = array();
$i = 1;

while ($ct = $res->fetch_assoc()) {
    $s_array = explode(",", $ct['extra_particulars']);
    $s_array1 = explode(",", $ct['extra_amount']);
    
    $record = array();
    $record['fees_id'] = $ct["fees_id"];
    $record['extra_particulars'] = $s_array[0];
	$record['extra_amount'] = $s_array1[0];
    $detailrecords[$i] = $record;
    $i++;
}

echo json_encode($detailrecords);
?>