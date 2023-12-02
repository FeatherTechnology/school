<?php
include '../ajaxconfig.php';


if(isset($_POST['paper_name'])){
	$paper_name = $_POST['paper_name'];
}
if(isset($_POST['max_mark'])){
	$max_mark = $_POST['max_mark'];
}
if(isset($_POST['class_id'])){
	$class_id = $_POST['class_id']; 
}
if(isset($_POST['insert_login_id'])){
	$insert_login_id = $_POST['insert_login_id']; 
} 
if(isset($_POST['subject_id'])){
	$subject_id = $_POST['subject_id']; 
} 

$subpaper_name='';
$subclass_id='';
$classStatus='';

$selectClass=$con->query("SELECT * FROM subject_details WHERE paper_name = '".$paper_name."' AND class_id = '".$class_id."' ");
while ($row=$selectClass->fetch_assoc()){
	$subpaper_name    = $row["paper_name"];
	$subclass_id    = $row["class_id"];
	$classStatus  = $row["status"];
}

if($subpaper_name != '' && $subclass_id != '' && $classStatus == 0){
	$message="Subject Already Exists, Please Enter a Different Name!";
}

else if($subpaper_name != '' && $subclass_id != '' && $classStatus == 1){
	$updateClass=$con->query("UPDATE subject_details SET status=0 WHERE paper_name='".$paper_name."' AND class_id = '".$class_id."' AND max_mark='".$max_mark."' ");
	$message="Subject Details Added Succesfully";
}

else{
	if($subject_id>0){
		$updateClass=$con->query("UPDATE subject_details SET paper_name='".$paper_name."',  class_id='".$class_id."',  max_mark='".$max_mark."' WHERE subject_id='".$subject_id."' ");
		if($updateClass == true){
		    $message="Subject Details Updated Succesfully";
	    }
    }
	else{
	    $insertClass=$con->query("INSERT INTO subject_details(paper_name,max_mark,class_id,insert_login_id) VALUES('".strip_tags($paper_name)."','".strip_tags($max_mark)."',
		'".strip_tags($class_id)."','".strip_tags($insert_login_id)."')");
	    if($insertClass == true){
		    $message="Subject Insert Succesfully";
	    }
    }
}

echo json_encode($message);
?>