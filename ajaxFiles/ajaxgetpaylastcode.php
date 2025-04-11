<?php
include '../ajaxconfig.php';
@session_start();

if (isset($_SESSION["userid"])) {
    $academic_year = $_SESSION["academic_year"];
}
$codeAvailable = $mysqli->query("SELECT receipt_no FROM last_year_fees WHERE receipt_no != '' AND academic_year = '$academic_year'  ORDER BY id DESC LIMIT 1 ");

if($codeAvailable->num_rows>0)
{
    $row = $codeAvailable->fetch_assoc();
    $ac2 = $row["receipt_no"];
    // $appno1 = ltrim(strstr($ac2, 'T'), 'T')+1;
	// $receipt_no="LAST".$appno1;
    $splited = explode('/', $ac2);
     // Extract only the last numeric part
     $last_number = intval(end($splited));


    $rnosplit1 =  $last_number + 1;
    $receipt_no = "LAST/$academic_year/". $rnosplit1;

}else{
    $receipt_no = "LAST/$academic_year/1";
}

echo json_encode($receipt_no, JSON_UNESCAPED_SLASHES);

?>



