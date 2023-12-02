
<?php
include 'ajaxconfig.php';
@session_start();
		
		if(isset($_SESSION["school_id"])){
			$school_id = $_SESSION["school_id"];
		 }
		 if(isset($_SESSION["academic_year"])){
			$year_id = $_SESSION["academic_year"];
		 }
		if (isset($_POST['standard'])) {
			$standard = $_POST["standard"];
		}
		if (isset($_POST['currentYear'])) {
			$currentYear = $_POST["currentYear"];
		}
		if (isset($_POST['medium'])) {
			$medium = $_POST["medium"];
		}

$bankavailable=$con->query("SELECT temp_no FROM temp_admission_student WHERE school_id = '$school_id' AND year_id = '$year_id' AND temp_medium = '$medium' AND temp_no LIKE '%$standard%' ORDER BY temp_admission_id desc limit 1");
// print_r($bankavailable);
if($bankavailable->num_rows>0){
	//$bankavailable=$con->query("SELECT temp_no FROM temp_admission_student WHERE temp_no LIKE '%$standard%' ORDER BY temp_admission_id");
	$row=$bankavailable->fetch_assoc();
		$temp_no = $row["temp_no"];
        // print_r($temp_no);
	
    
	// $temp_no1 = ltrim(strstr($temp_no2, '-'), '-')+1;
	// $temp_no="2023".$temp_no1;
}else{

	$temp_no = $standard.'-'.$currentYear."-0";
	
	
}

echo json_encode($temp_no);
?>