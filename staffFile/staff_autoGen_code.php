<?php
include('../ajaxconfig.php');
@session_start();
if(isset($_SESSION["userid"])){

    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
   
}
$id  = $_POST['staffId'];

if($id !=''){
    $select = $con->query("SELECT employee_no FROM staff_creation WHERE id = '$id' AND school_id='$school_id' AND year_id='$year_id'");
    // SELECT employee_no FROM staff_creation WHERE id = '$id' 
    $code = $select ->fetch_assoc();
    $employee_no = $code['employee_no'];

}else{
$myStr = "ST";
$selectIC = $con->query("SELECT employee_no FROM staff_creation WHERE employee_no != '' AND school_id='$school_id' AND year_id='$year_id' ");
if($selectIC->num_rows>0)
{
    $codeAvailable = $con->query("SELECT employee_no FROM staff_creation WHERE employee_no != '' AND school_id='$school_id' AND year_id='$year_id' ORDER BY id DESC LIMIT 1");
    while($row = $codeAvailable->fetch_assoc()){
        $ac2 = $row["employee_no"];
    }
    $appno2 = ltrim(strstr($ac2, '-'), '-'); $appno2 = $appno2+1;
    $employee_no = $myStr."-". "$appno2";
}
else
{
    $initialapp = $myStr."-101";
    $employee_no = $initialapp;
}
}
echo json_encode($employee_no);
?>