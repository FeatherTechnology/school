<?php
include "../../ajaxconfig.php";

if(isset($_POST['student_id'])){ 
    $student_id = $_POST['student_id'];
}

$getStudentDetailsQry = $connect->query("SELECT stdc.student_name, stdc.`admission_number`, stdc.studentrollno, stdc.medium, stdc.studentstype, stdc.standard, sc.standard as standard_name, stdc.section, stdc.year_id, stdc.school_id, stdc.facility 
FROM `student_creation` stdc 
JOIN standard_creation sc ON stdc.standard = sc.standard_id 
WHERE stdc.student_id = '$student_id'");
$studentInfo = $getStudentDetailsQry ->fetch();

$student_name = $studentInfo['student_name'];
$admission_number = $studentInfo['admission_number'];
$studentrollno = $studentInfo['studentrollno'];
$medium = $studentInfo['medium'];
$studentstype = $studentInfo['studentstype'];
$standard = $studentInfo['standard'];
$standard_name = $studentInfo['standard_name'];
$section = $studentInfo['section'];
$academic_year = $studentInfo['year_id'];
$school_id = $studentInfo['school_id'];
$transportFacility = $studentInfo['facility'];

//Fee Details /// Gross Payable/// Group / extracurricular / amenity / transport/
$getGrpFeesMasterDetailsQry = $connect->query("SELECT SUM(gcf.grp_amount) as OverallGrpAmount 
FROM fees_master fm 
JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id
JOIN student_creation stdc ON fm.standard = stdc.standard 
WHERE fm.academic_year = '$academic_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND gcf.status = 1 AND fm.school_id = '$school_id' AND stdc.student_id = '$student_id' ");
if($getGrpFeesMasterDetailsQry->rowCount()>0){
    $overallGrpAmount = $getGrpFeesMasterDetailsQry->fetch()['OverallGrpAmount'];
}else{
    $overallGrpAmount = '0';
}
//Close DB connection
$getGrpFeesMasterDetailsQry->closeCursor(); 

$getExtraCurFeesMasterDetailsQry = $connect->query("SELECT SUM(ecaf.extra_amount) as OverallExtraCurAmount 
FROM fees_master fm 
JOIN extra_curricular_activities_fee ecaf ON fm.fees_id = ecaf.fee_master_id 
JOIN student_creation stdc ON fm.standard = stdc.standard
WHERE fm.academic_year = '$academic_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND ecaf.status = '1' AND fm.school_id ='$school_id' AND stdc.student_id = '$student_id' "); 
if($getExtraCurFeesMasterDetailsQry->rowCount() > 0){
    $overallExtraCurAmount = $getExtraCurFeesMasterDetailsQry->fetch()['OverallExtraCurAmount'];
}else{
    $overallExtraCurAmount = '0';
}
//Close DB connection
$getExtraCurFeesMasterDetailsQry->closeCursor(); 

$getAmenityFeesMasterDetailsQry = $connect->query("SELECT SUM(af.amenity_amount) as OverallAmenityAmount 
FROM fees_master fm 
JOIN amenity_fee af ON fm.fees_id = af.fee_master_id 
JOIN student_creation stdc ON fm.standard = stdc.standard
WHERE fm.academic_year = '$academic_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND af.status = '1' AND fm.school_id ='$school_id' AND stdc.student_id = '$student_id' ");
if($getAmenityFeesMasterDetailsQry->rowCount() > 0){
    $overallAmenityAmount = $getAmenityFeesMasterDetailsQry->fetch()['OverallAmenityAmount'];
}else{
    $overallAmenityAmount = '0';
}
//Close DB connection
$getAmenityFeesMasterDetailsQry->closeCursor(); 

$getAreaMasterDetailsQry = $connect->query("SELECT SUM(acp.due_amount) as OverallTransportAmount  
FROM student_creation sc
JOIN area_creation ac ON sc.transportarearefid = ac.area_id
JOIN area_creation_particulars acp ON ac.area_id = acp.area_creation_id
WHERE sc.student_id = '$student_id'");
if($getAreaMasterDetailsQry->rowCount() > 0){
    $overallTransportAmount = $getAreaMasterDetailsQry->fetch()['OverallTransportAmount'];
}else{
    $overallTransportAmount = '0';
}
//Close DB connection
$getAreaMasterDetailsQry->closeCursor(); 
//Fee Details /// Gross Payable/// Group / extracurricular / amenity / transport/  ////////////END////////////////////////////////////////////////////////////

//Fee Details /// Gross Payable/// Last year fees//////////////////////
$split_academic_year = explode('-', $academic_year);
$last_year = (($split_academic_year[0] - 1) .'-'. ($split_academic_year[1]-1));
//Group fees
$getLastYearGrpFeesQry = $connect->query("SELECT SUM(gcf.grp_amount) as OverallGrpAmount 
FROM fees_master fm 
JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id 
JOIN student_creation stdc ON fm.standard = stdc.standard
WHERE fm.academic_year = '$last_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND gcf.status = 1 AND fm.school_id = '$school_id' AND stdc.student_id = '$student_id' ");
if($getLastYearGrpFeesQry->rowCount()>0){
    $overallLastYearGrpAmount = $getLastYearGrpFeesQry->fetch()['OverallGrpAmount'];
}else{
    $overallLastYearGrpAmount = '0';
}
//Close DB connection
$getLastYearGrpFeesQry->closeCursor(); 

//Extra curricular activities
$getLastYearExtraCurFeesQry = $connect->query("SELECT SUM(ecaf.extra_amount) as OverallExtraCurAmount 
FROM fees_master fm 
JOIN extra_curricular_activities_fee ecaf ON fm.fees_id = ecaf.fee_master_id
JOIN student_creation stdc ON fm.standard = stdc.standard 
WHERE fm.academic_year = '$last_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND ecaf.status = '1' AND fm.school_id ='$school_id' AND stdc.student_id = '$student_id' "); 
if($getLastYearExtraCurFeesQry->rowCount()>0){
    $overallLastYearExtraCurAmount = $getLastYearExtraCurFeesQry->fetch()['OverallExtraCurAmount'];
}else{
    $overallLastYearExtraCurAmount = '0';
}

//Close DB connection
$getLastYearExtraCurFeesQry->closeCursor(); 

//Amenity fees
$getLastYearAmenityFeesQry = $connect->query("SELECT SUM(af.amenity_amount) as OverallAmenityAmount 
FROM fees_master fm 
JOIN amenity_fee af ON fm.fees_id = af.fee_master_id 
JOIN student_creation stdc ON fm.standard = stdc.standard
WHERE fm.academic_year = '$last_year' AND fm.medium = '$medium' AND fm.student_type = '$studentstype' AND fm.standard = '$standard' AND af.status = '1' AND fm.school_id ='$school_id' AND stdc.student_id = '$student_id' "); 
if($getLastYearAmenityFeesQry->rowCount()>0){
    $overallLastYearAmenityAmount = $getLastYearAmenityFeesQry->fetch()['OverallAmenityAmount'];
}else{
    $overallLastYearAmenityAmount = '0';
}

//Close DB connection
$getLastYearAmenityFeesQry->closeCursor(); 

$overallLastYearFees = intval($overallLastYearGrpAmount + $overallLastYearExtraCurAmount + $overallLastYearAmenityAmount);
//Fee Details /// Gross Payable/// Last year fees/ ///////////////////////////////END /////////////////////////////////////////////////////////////////////


//Fee Details /// Amount Paid///  Group / extra cur/ amenity / transport/
$CheckReceiptQry = $connect->query("SELECT id FROM `admission_fees` WHERE admission_id = '$student_id' && academic_year = '$academic_year' order by id desc limit 1");
$overallpaid_grp_amount = 0;
$overallpaid_extra_cur_amount = 0;
$overallpaid_amenity_amount = 0;
if($CheckReceiptQry->rowCount() > 0){
    $get_fees_id = $CheckReceiptQry->fetch()['id'];
    $grpfeeDetailsQry = $connect->query("SELECT (SUM(gcf.grp_amount) - SUM(afd.balance_tobe_paid))  as paid_grp_amount 
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id 
    WHERE af.id = '$get_fees_id' && afd.fees_table_name = 'grptable' ");
    if($grpfeeDetailsQry->rowCount() > 0){
        $overallpaid_grp_amount = $grpfeeDetailsQry->fetch()['paid_grp_amount'];
    }else{
        $overallpaid_grp_amount = '0';
    }
    //Close DB connection
    $grpfeeDetailsQry->closeCursor(); 

    $extraFeeDetailsQry = $connect->query("SELECT (SUM(ecaf.extra_amount) - SUM(afd.balance_tobe_paid)) as paid_extra_cur_amount 
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
    WHERE af.id = '$get_fees_id' && afd.fees_table_name = 'extratable' ");
    if($extraFeeDetailsQry->rowCount() > 0){
        $overallpaid_extra_cur_amount = $extraFeeDetailsQry->fetch()['paid_extra_cur_amount'];
    }else{
        $overallpaid_extra_cur_amount = '0';
    }
    //Close DB connection
    $extraFeeDetailsQry->closeCursor(); 

    $amenityFeeDetailsQry = $connect->query("SELECT (SUM(af.amenity_amount) - SUM(afd.balance_tobe_paid)) as paid_amenity_amount 
    FROM `admission_fees` afs 
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id 
    JOIN amenity_fee af ON afd.fees_id = af.amenity_fee_id 
    WHERE afs.id = '$get_fees_id' && afd.fees_table_name = 'amenitytable' ");
    if($amenityFeeDetailsQry->rowCount() > 0){
        $overallpaid_amenity_amount = $amenityFeeDetailsQry->fetch()['paid_amenity_amount'];
    }else{
        $overallpaid_amenity_amount = '0';
    }
    //Close DB connection
    $amenityFeeDetailsQry->closeCursor(); 

    //Close DB connection
    $CheckReceiptQry->closeCursor(); 
}//admission fee if END

$CheckTransportReceiptQry = $connect->query("SELECT id FROM `transport_admission_fees` WHERE admission_id = '$student_id' && academic_year = '$academic_year' order by id desc limit 1");
$overallpaid_transport_amount = '0';
if($CheckTransportReceiptQry->rowCount() > 0){
    $get_transportfees_id = $CheckTransportReceiptQry->fetch()['id'];
    $transportfeeDetailsQry = $connect->query("SELECT (SUM(acp.due_amount) - SUM(tafd.balance_tobe_paid)) as paid_transport_amount
    FROM `transport_admission_fees` taf 
    JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
    JOIN area_creation ac ON tafd.area_creation_id = ac.area_id
    JOIN area_creation_particulars acp ON tafd.area_creation_particulars_id = acp.particulars_id 
    WHERE taf.id = '$get_transportfees_id' ");
    if($transportfeeDetailsQry->rowCount() > 0){
        $overallpaid_transport_amount = $transportfeeDetailsQry->fetch()['paid_transport_amount'];
    }else{
        $overallpaid_transport_amount = '0';
    }
    //Close DB connection
    $transportfeeDetailsQry->closeCursor(); 

    //Close DB connection
    $CheckTransportReceiptQry->closeCursor(); 
}//transport if END

//Fee Details /// Amount Paid/// Group / extra cur/ amenity / transport/ ////////////////////////////END//////////////////////////////////////////////


//Fee Details /// Amount Paid///  Last year ////////////////////////////////////////////////////////
$CheckLastyrReceiptQry = $connect->query("SELECT id FROM `admission_fees` WHERE admission_id = '$student_id' && academic_year = '$last_year' order by id desc limit 1");
$lastyr_overallpaid_amount = 0;
if($CheckLastyrReceiptQry->rowCount() > 0){
    $get_lastyr_fees_id = $CheckLastyrReceiptQry->fetch()['id'];
    $lastyr_grpfeeDetailsQry = $connect->query("SELECT (SUM(gcf.grp_amount) - SUM(afd.balance_tobe_paid))  as paid_grp_amount 
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id 
    WHERE af.id = '$get_lastyr_fees_id' && afd.fees_table_name = 'grptable' ");
    if($lastyr_grpfeeDetailsQry->rowCount() > 0){
        $lastyr_overallpaid_grp_amount = $lastyr_grpfeeDetailsQry->fetch()['paid_grp_amount'];
    }else{
        $lastyr_overallpaid_grp_amount = '0';
    }
    //Close DB connection
    $lastyr_grpfeeDetailsQry->closeCursor(); 

    $lastyr_extraFeeDetailsQry = $connect->query("SELECT (SUM(ecaf.extra_amount) - SUM(afd.balance_tobe_paid)) as paid_extra_cur_amount 
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
    WHERE af.id = '$get_lastyr_fees_id' && afd.fees_table_name = 'extratable' ");
    if($lastyr_extraFeeDetailsQry->rowCount() > 0){
        $lastyr_overallpaid_extra_cur_amount = $lastyr_extraFeeDetailsQry->fetch()['paid_extra_cur_amount'];
    }else{
        $lastyr_overallpaid_extra_cur_amount = '0';
    }
    //Close DB connection
    $lastyr_extraFeeDetailsQry->closeCursor(); 

    $lastyr_amenityFeeDetailsQry = $connect->query("SELECT (SUM(af.amenity_amount) - SUM(afd.balance_tobe_paid)) as paid_amenity_amount 
    FROM `admission_fees` afs 
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id 
    JOIN amenity_fee af ON afd.fees_id = af.amenity_fee_id 
    WHERE afs.id = '$get_lastyr_fees_id' && afd.fees_table_name = 'amenitytable' ");
    if($lastyr_amenityFeeDetailsQry->rowCount() > 0){
        $lastyr_overallpaid_amenity_amount = $lastyr_amenityFeeDetailsQry->fetch()['paid_amenity_amount'];
    }else{
        $lastyr_overallpaid_amenity_amount = '0';
    }
    //Close DB connection
    $lastyr_amenityFeeDetailsQry->closeCursor(); 

    $lastyr_overallpaid_amount = $lastyr_overallpaid_grp_amount + $lastyr_overallpaid_extra_cur_amount + $lastyr_overallpaid_amenity_amount;

    //Close DB connection
    $CheckLastyrReceiptQry->closeCursor(); 
}//Last year admission fee if END

//Fee Details /// Amount Paid///  Last year////////////////////////////END/////////////////////////////////////////////////////////////////////////////////


//Fee Details /// Concession///  Group/ extra cur/ amenity/  transport/ Last year/
$CheckConcessionReceiptQry = $connect->query("SELECT id FROM `admission_fees` WHERE admission_id = '$student_id' && academic_year = '$academic_year' order by id desc limit 1");
$overall_grp_concession_amount = 0;
$overall_extra_cur_concession_amount = 0;
$overall_amenity_concession_amount = 0;
if($CheckConcessionReceiptQry->rowCount() > 0){
    $get_concession_fees_id = $CheckConcessionReceiptQry->fetch()['id'];
    $grpfeeConcessionDetailsQry = $connect->query("SELECT SUM(afd.scholarship) as grp_concession_amount  
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id 
    WHERE af.id = '$get_concession_fees_id' && afd.fees_table_name = 'grptable' ");
    if($grpfeeConcessionDetailsQry->rowCount() > 0){
        $overall_grp_concession_amount = $grpfeeConcessionDetailsQry->fetch()['grp_concession_amount'];
    }else{
        $overall_grp_concession_amount = '0';
    }
    //Close DB connection
    $grpfeeConcessionDetailsQry->closeCursor(); 

    $extraFeeConcessionDetailsQry = $connect->query("SELECT SUM(afd.scholarship) as extra_cur_concession_amount 
    FROM `admission_fees` af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
    JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id 
    WHERE af.id = '$get_concession_fees_id' && afd.fees_table_name = 'extratable' ");
    if($extraFeeConcessionDetailsQry->rowCount() > 0){
        $overall_extra_cur_concession_amount = $extraFeeConcessionDetailsQry->fetch()['extra_cur_concession_amount'];
    }else{
        $overall_extra_cur_concession_amount = '0';
    }
    //Close DB connection
    $extraFeeConcessionDetailsQry->closeCursor(); 

    $amenityFeeConcessionDetailsQry = $connect->query("SELECT SUM(afd.scholarship) as amenity_concession_amount 
    FROM `admission_fees` afs 
    JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id 
    JOIN amenity_fee af ON afd.fees_id = af.amenity_fee_id 
    WHERE afs.id = '$get_concession_fees_id' && afd.fees_table_name = 'amenitytable' ");
    if($amenityFeeConcessionDetailsQry->rowCount() > 0){
        $overall_amenity_concession_amount = $amenityFeeConcessionDetailsQry->fetch()['amenity_concession_amount'];
    }else{
        $overall_amenity_concession_amount = '0';
    }
    //Close DB connection
    $amenityFeeConcessionDetailsQry->closeCursor(); 

    //Close DB connection
    $CheckConcessionReceiptQry->closeCursor(); 
}//admission fee Concession if END

$CheckTransportConcessionReceiptQry = $connect->query("SELECT SUM(scholarship) as overall_transport_concession FROM `transport_admission_fees` WHERE admission_id = '$student_id' && academic_year = '$academic_year' ");
    if($CheckTransportConcessionReceiptQry->rowCount() > 0){
        $overall_transport_concession_amount = $CheckTransportConcessionReceiptQry->fetch()['overall_transport_concession'];
    }else{
        $overall_transport_concession_amount = '0';
    }
    //Close DB connection
    $CheckTransportConcessionReceiptQry->closeCursor(); 

$CheckLastyrConcessionReceiptQry = $connect->query("SELECT SUM(scholarship) as overall_lastyr_concession FROM `admission_fees` WHERE admission_id = '$student_id' && academic_year = '$last_year' ");
if($CheckLastyrConcessionReceiptQry->rowCount() > 0){
    $overall_lastyr_concession_amount = $CheckLastyrConcessionReceiptQry->fetch()['overall_lastyr_concession'];
}else{
    $overall_lastyr_concession_amount = '0';
}
//Close DB connection
$CheckLastyrConcessionReceiptQry->closeCursor(); 

//Fee Details /// Concession///  Group/ extra cur/ amenity/ transport/ Last year/ ////////////////////////////END////////////////////////////////////////////////////////


// $studentFeesCollectionDetails = array("student_name"=>$student_name, "admission_number"=>$admission_number, "studentrollno"=>$studentrollno, "medium"=>$medium, "studentstype"=>$studentstype, "standard_name"=>$standard_name, "section"=>$section, "academic_year"=>$academic_year, "school_id"=>$school_id, "transportFacility"=>$transportFacility, "overallGrpAmount"=>$overallGrpAmount, "overallExtraCurAmount"=>$overallExtraCurAmount, "overallAmenityAmount"=> $overallAmenityAmount, "overallTransportAmount"=> $overallTransportAmount, "overallLastYearFees"=>$overallLastYearFees, "overallpaid_grp_amount"=>$overallpaid_grp_amount,  "overallpaid_extra_cur_amount"=>$overallpaid_extra_cur_amount, "overallpaid_amenity_amount"=>$overallpaid_amenity_amount, "overallpaid_transport_amount"=>$overallpaid_transport_amount,"lastyr_overallpaid_amount"=>$lastyr_overallpaid_amount, "overall_grp_concession_amount"=>$overall_grp_concession_amount,"overall_extra_cur_concession_amount"=>$overall_extra_cur_concession_amount, "overall_amenity_concession_amount"=>$overall_amenity_concession_amount,"overall_transport_concession_amount"=>$overall_transport_concession_amount, "overall_lastyr_concession_amount"=>$overall_lastyr_concession_amount
// );

$netPaySchoolFees = (($overallGrpAmount) - ($overallpaid_grp_amount + $overall_grp_concession_amount));
$netPayExtraCurFees = (($overallExtraCurAmount) - ($overallpaid_extra_cur_amount + $overall_extra_cur_concession_amount));
$netPayAmenityFees = (($overallAmenityAmount) - ($overallpaid_amenity_amount + $overall_amenity_concession_amount));
$netPayTransportFees = (($overallTransportAmount) - ($overallpaid_transport_amount + $overall_transport_concession_amount));
$netPayLastYearFees = (($overallLastYearFees) - ($lastyr_overallpaid_amount + $overall_lastyr_concession_amount));

$studentFeesCollectionDetails =array();
$studentFeesCollectionDetails["student_name"] = ($student_name) ? $student_name : '-';
$studentFeesCollectionDetails["admission_number"] = ($admission_number) ? $admission_number : '-'; 
$studentFeesCollectionDetails["studentrollno"] = ($studentrollno) ? $studentrollno : '-';
$studentFeesCollectionDetails["medium"] = ($medium) ? $medium : '-';
$studentFeesCollectionDetails["studentstype"] = ($studentstype) ? $studentstype : '-';
$studentFeesCollectionDetails["standard_name"] = ($standard_name) ? $standard_name : '-';
$studentFeesCollectionDetails["section"] = ($section) ? $section : '-';
$studentFeesCollectionDetails["academic_year"] = ($academic_year) ? $academic_year : '-';
$studentFeesCollectionDetails["school_id"] = ($school_id) ? $school_id : '-';
$studentFeesCollectionDetails["transportFacility"] = ($transportFacility) ? $transportFacility : '-';

$studentFeesCollectionDetails["overallGrpAmount"] = ($overallGrpAmount) ? $overallGrpAmount : '0';
$studentFeesCollectionDetails["overallExtraCurAmount"] = ($overallExtraCurAmount) ? $overallExtraCurAmount : '0';
$studentFeesCollectionDetails["overallAmenityAmount"] =  ($overallAmenityAmount) ? $overallAmenityAmount : '0';
$studentFeesCollectionDetails["overallTransportAmount"] =  ($overallTransportAmount) ? $overallTransportAmount : '0';
$studentFeesCollectionDetails["overallLastYearFees"] = ($overallLastYearFees) ? $overallLastYearFees : '0';

$studentFeesCollectionDetails["overallpaid_grp_amount"] = ($overallpaid_grp_amount) ? $overallpaid_grp_amount : '0';
$studentFeesCollectionDetails["overallpaid_extra_cur_amount"] = ($overallpaid_extra_cur_amount) ? $overallpaid_extra_cur_amount : '0';
$studentFeesCollectionDetails["overallpaid_amenity_amount"] = ($overallpaid_amenity_amount) ? $overallpaid_amenity_amount : '0';
$studentFeesCollectionDetails["overallpaid_transport_amount"] = ($overallpaid_transport_amount) ? $overallpaid_transport_amount : '0';
$studentFeesCollectionDetails["lastyr_overallpaid_amount"] = ($lastyr_overallpaid_amount) ? $lastyr_overallpaid_amount : '0';

$studentFeesCollectionDetails["overall_grp_concession_amount"] = ($overall_grp_concession_amount) ? $overall_grp_concession_amount : '0';
$studentFeesCollectionDetails["overall_extra_cur_concession_amount"] = ($overall_extra_cur_concession_amount) ? $overall_extra_cur_concession_amount : '0';
$studentFeesCollectionDetails["overall_amenity_concession_amount"] = ($overall_amenity_concession_amount) ? $overall_amenity_concession_amount : '0';
$studentFeesCollectionDetails["overall_transport_concession_amount"] = ($overall_transport_concession_amount) ? $overall_transport_concession_amount : '0';
$studentFeesCollectionDetails["overall_lastyr_concession_amount"] = ($overall_lastyr_concession_amount) ? $overall_lastyr_concession_amount : '0';

$studentFeesCollectionDetails["netPaySchoolFees"] = ($netPaySchoolFees) ? $netPaySchoolFees : '0';
$studentFeesCollectionDetails["netPayExtraCurFees"] = ($netPayExtraCurFees) ? $netPayExtraCurFees : '0';
$studentFeesCollectionDetails["netPayAmenityFees"] = ($netPayAmenityFees) ? $netPayAmenityFees : '0';
$studentFeesCollectionDetails["netPayTransportFees"] = ($netPayTransportFees) ? $netPayTransportFees : '0';
$studentFeesCollectionDetails["netPayLastYearFees"] = ($netPayLastYearFees) ? $netPayLastYearFees : '0';


echo json_encode($studentFeesCollectionDetails);
?>