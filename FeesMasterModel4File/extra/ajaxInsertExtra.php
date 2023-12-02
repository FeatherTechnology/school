<?php
include '../../ajaxconfig.php';


if(isset($_POST['extra_particulars'])){
	$extra_particulars = $_POST['extra_particulars'];
}
if(isset($_POST['extra_amount'])){
	$extra_amount = $_POST['extra_amount'];
}

if(isset($_POST['academic_year'])){
	$academic_year = $_POST['academic_year']; 
}
if(isset($_POST['medium'])){
	$medium = $_POST['medium']; 
}
if(isset($_POST['standard'])){
	$standard = $_POST['standard']; 
}

if(isset($_POST['insert_login_id'])){
	$insert_login_id = $_POST['insert_login_id']; 
}
 
if(isset($_POST['fees_id'])){
	$fees_id = $_POST['fees_id']; 
} 

$extra_academic_year='';
$extra_medium='';
$extra_Status='';
$extra_standard = '';


$extrac_particulars = '';
$extrac_amount = '' ;

$selectClass=$con->query("SELECT * FROM fees_master WHERE academic_year = '".$academic_year."' AND medium = '".$medium."'
AND extra_particulars = '".$extra_particulars."' AND extra_amount = '".$extra_amount."' AND standard = '".$standard."' ");
while ($row=$selectClass->fetch_assoc()){

		$extra_academic_year    = $row["academic_year"];
		$extra_medium    = $row["medium"];
		$extra_standard    = $row["standard"];
		$extrac_particulars    = $row["extra_particulars"];
		$extrac_amount    = $row["extra_amount"];
		$extra_Status  = $row["status"];
	}
if($extra_academic_year != '' && $extra_medium != '' && $extra_standard != '' && $extrac_particulars != '' && $extra_Status == 0){ ;
	$message="Fees Already Exists, Please Enter a Different Name!";
}

else if($extra_academic_year != '' && $extra_medium != '' && $extra_standard != '' && $extrac_particulars != ''  && $extrac_amount != '' && $extrac_date != '' && $extra_Status == 1){ ;
	$updateClass=$con->query("UPDATE fees_master SET status=0 WHERE academic_year = '".$academic_year."' AND medium = '".$medium."' AND standard = '".$standard."'
	AND extra_particulars = '".$extra_particulars."' AND extra_amount = '".$extra_amount."' ");
	$message="Fees Details Added Succesfully";
}

else{ 
	if($fees_id>0){
		$updateClass=$con->query("UPDATE academic_year = '".$academic_year."' AND medium = '".$medium."' AND standard = '".$standard."'
		AND extra_particulars = '".$extra_particulars."' AND extra_amount = '".$extra_amount."' WHERE fees_id='".$fees_id."' ");
		if($updateClass == true){
		    $message="Fees Details Updated Succesfully";
	    }
    }
	else{ ;
	    $insertClass=$con->query("INSERT INTO fees_master(academic_year,medium,standard,extra_particulars,extra_amount,insert_login_id,extra_status) VALUES('".strip_tags($academic_year)."','".strip_tags($medium)."',
		'".strip_tags($standard)."','".strip_tags($extra_particulars)."','".strip_tags($extra_amount)."','".strip_tags($insert_login_id)."',1)");
	    if($insertClass == true){
		    $message="Fees Insert Succesfully";
	    }
    }
}

echo json_encode($message);
?>