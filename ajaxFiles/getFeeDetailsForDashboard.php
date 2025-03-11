<?php 
include "../ajaxconfig.php";
@session_start();
if(isset($_SESSION['academic_year'])){
    $academicyear = $_SESSION['academic_year'];
}
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}

///////////////////////////////////Total fee START///////////////////////////////////////
$totalamount=0;
$getgrpFeeTotalQry = $connect->query("SELECT COALESCE(SUM(gcf.grp_amount) * (SELECT COUNT(*) from student_creation where standard=fm.standard AND studentstype= fm.student_type AND medium=fm.medium AND year_id=fm.academic_year AND leaving_term!=1 AND leaving_term!=5 ),0) AS totalgrpamnt 
FROM `fees_master` fm 
JOIN group_course_fee gcf ON gcf.fee_master_id = fm.fees_id 
WHERE fm.academic_year='$academicyear' && fm.status=0 && fm.school_id = '$school_id' && gcf.status=1 
GROUP BY 
fm.standard,
fm.medium,
fm.student_type");
while($grpFeeInfo = $getgrpFeeTotalQry->fetchObject()){
    $totalamount += $grpFeeInfo->totalgrpamnt;
}

$getExtraFeeTotalQry = $connect->query("SELECT COALESCE(SUM(ecaf.extra_amount),0) AS extraAmnt
FROM `fees_master` fm 
JOIN extra_curricular_activities_fee ecaf ON ecaf.fee_master_id = fm.fees_id 
JOIN student_creation sc ON FIND_IN_SET(ecaf.extra_fee_id, sc.extra_curricular)
WHERE fm.academic_year='$academicyear' && fm.status=0 && fm.school_id = '$school_id' && sc.school_id = '$school_id' && ecaf.status=1 ");
$extraFeeInfo = $getExtraFeeTotalQry->fetchObject();
    $totalamount += $extraFeeInfo->extraAmnt;


$getamenityFeeTotalQry = $connect->query("SELECT COALESCE(SUM(af.amenity_amount) * (SELECT COUNT(*) from student_creation where standard=fm.standard AND studentstype= fm.student_type AND medium=fm.medium AND year_id=fm.academic_year AND  leaving_term!=1 AND leaving_term!=5 ),0) AS totalAmenityamnt 
FROM `fees_master` fm 
JOIN amenity_fee af ON af.fee_master_id = fm.fees_id 
WHERE fm.academic_year='$academicyear' && fm.status=0 && fm.school_id = '$school_id' && af.status=1 
GROUP BY 
fm.standard,
fm.medium,
fm.student_type");
while($amenityFeeInfo = $getamenityFeeTotalQry->fetchObject()){
    $totalamount += $amenityFeeInfo->totalAmenityamnt;
}
///////////////////////////// Total Fee END ///////////////////////////////////


/////////////////////Total fee collected START //////////////////////////////

$getPaidFeeCount = $connect->query("SELECT COALESCE( (SUM(afd.fee_received) + SUM(afd.scholarship)),0) AS paidFee FROM admission_fees_details afd JOIN admission_fees af ON afd.admission_fees_ref_id = af.id WHERE af.academic_year = '$academicyear' && af.school_id = '$school_id' ");
$paidFeeInfo = $getPaidFeeCount->fetchObject();
/////////////////// Total fee collected END ///////////////////////////////////

///////////////////// Today's Collection START //////////////////////////////
$getTodayFeeCount = $connect->query("SELECT COALESCE( (SUM(afd.fee_received) + SUM(afd.scholarship)),0) AS todayFeecollected FROM admission_fees_details afd JOIN admission_fees af ON afd.admission_fees_ref_id = af.id WHERE af.academic_year = '$academicyear' && af.receipt_date=CURDATE() && af.school_id = '$school_id' ");
$todayFeeInfo = $getTodayFeeCount->fetchObject();
///////////////////// Today's Collection END////////////////////////////////

$getCountArr = array("totalFee"=>$totalamount, "paidFee"=> $paidFeeInfo->paidFee, "todayscollection"=> $todayFeeInfo->todayFeecollected);

echo json_encode($getCountArr);
?>