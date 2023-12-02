<?php
include '../../ajaxconfig.php';


if(isset($_POST['amenity_particulars'])){
	$amenity_particulars = $_POST['amenity_particulars'];
}
if(isset($_POST['amenity_amount'])){
	$amenity_amount = $_POST['amenity_amount'];
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

$grp_academic_year='';
$grp_medium='';
$grp_Status='';
$grp_standard = '';

$grpc_particulars = '';
$grpc_amount = '' ;

$selectClass=$con->query("SELECT * FROM fees_master WHERE academic_year = '".$academic_year."' AND medium = '".$medium."'
AND amenity_particulars = '".$amenity_particulars."' AND amenity_amount = '".$amenity_amount."' AND standard = '".$standard."' ");
while ($row=$selectClass->fetch_assoc()){

		$grp_academic_year    = $row["academic_year"];
		$grp_medium    = $row["medium"];
		$grp_standard    = $row["standard"];
		$grpc_particulars    = $row["amenity_particulars"];
		$grpc_amount    = $row["amenity_amount"];
		$grp_Status  = $row["status"];
	}
if($grp_academic_year != '' && $grp_medium != '' && $grp_standard != '' && $grpc_particulars != ''  && $grpc_amount != '' && $grp_Status == 0){ echo "1";
	$message="Amenity Fees Already Exists, Please Enter a Different Name!";
}

else if($grp_academic_year != '' && $grp_medium != '' && $grp_standard != '' && $grpc_particulars != ''  && $grpc_amount != '' && $grp_Status == 1){ echo "2";
	$updateClass=$con->query("UPDATE fees_master SET status=0 WHERE academic_year = '".$academic_year."' AND medium = '".$medium."' AND standard = '".$standard."'
	AND amenity_particulars = '".$amenity_particulars."' AND amenity_amount = '".$amenity_amount."' ");
	$message="Fees Details Added Succesfully";
}

else{ 
	if($fees_id>0){
		$updateClass=$con->query("UPDATE academic_year = '".$academic_year."' AND medium = '".$medium."' AND standard = '".$standard."'
		AND amenity_particulars = '".$amenity_particulars."' AND amenity_amount = '".$amenity_amount."' WHERE fees_id='".$fees_id."' ");
		if($updateClass == true){
		    $message="Amenity Fees Details Updated Succesfully";
	    }
    }
	else{ 
	    $insertClass=$con->query("INSERT INTO fees_master(academic_year,medium,standard,amenity_particulars,amenity_amount,insert_login_id, amenity_status) VALUES('".strip_tags($academic_year)."','".strip_tags($medium)."',
		'".strip_tags($standard)."','".strip_tags($amenity_particulars)."','".strip_tags($amenity_amount)."','".strip_tags($insert_login_id)."',1)");
	    if($insertClass == true){
		    $message="Amenity Fees Insert Succesfully";
	    }
    }
}

echo json_encode($message);
?>