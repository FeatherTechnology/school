<?php
include '../../ajaxconfig.php';

if(isset($_POST['admissionFormId'])){
    $admissionFormId = $_POST['admissionFormId'];
}
if(isset($_POST['academicYear'])){
    $academicYear = $_POST['academicYear'];
}
// Split the academic year string by the '-' character
$acdmcyear = explode('-', $academicYear);

// Increment the first and second part of the academic year for the new academic year
$nextAcademicYear = ($acdmcyear[0] + 1) . '-' . ($acdmcyear[1] + 1);
if(isset($_POST['medium'])){
    $medium = $_POST['medium'];
}
if(isset($_POST['studentType'])){
    $studentType = $_POST['studentType'];
}
if(isset($_POST['standard'])){
    $standardId = $_POST['standard'];
}

if($studentType =="1" || $studentType =="2"){
    $student_type_cndtn = "(fm.student_type = '$studentType' || fm.student_type = '4')";
    
}else{
    $student_type_cndtn = "(fm.student_type = '$studentType')";

}

$CheckReceiptQry = $connect->query("SELECT af.id FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && af.academic_year = '$academicYear' && afd.fees_table_name = 'grptable' ORDER BY af.id DESC LIMIT 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    $feeDetailsQry = $connect->query("SELECT afd.balance_tobe_paid as grp_amount, afd.fees_master_id as fees_id, afd.fees_id as grp_course_id, gcf.grp_particulars,gcf.grp_amount  AS ovrlAllGrpAmnt FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id WHERE af.id = '$get_temp_fees_id' && af.academic_year = '$academicYear' && afd.fees_table_name = 'grptable' && gcf.status ='1' ");

}else{
    $feeDetailsQry = $connect->query("SELECT fm.fees_id, fm.academic_year, gcf.*,gcf.grp_amount AS ovrlAllGrpAmnt  FROM `fees_master` fm JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id where fm.academic_year = '$academicYear' && fm.medium = '$medium' && $student_type_cndtn && fm.standard = '$standardId' && gcf.status ='1' ");

}

$CheckLastReceiptQry = $connect->query("SELECT lf.id FROM `last_year_fees` lf JOIN last_year_fees_details lfd ON lf.id = lfd.admission_fees_ref_id WHERE lf.admission_id = '$admissionFormId' && lf.academic_year = '$nextAcademicYear' && lfd.fees_table_name = 'grptable' ORDER BY lf.id DESC LIMIT 1");
if($CheckLastReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckLastReceiptQry->fetch()['id'];
    $lastfeeDetailsQry = $connect->query("SELECT lfd.balance_tobe_paid as grp_amount, lfd.fees_master_id as fees_id, lfd.fees_id as grp_course_id, gcf.grp_particulars,gcf.grp_amount  AS ovrlAllGrpAmnt FROM `last_year_fees` lf JOIN last_year_fees_details lfd ON lf.id = lfd.admission_fees_ref_id JOIN group_course_fee gcf ON lfd.fees_id = gcf.grp_course_id WHERE lf.id = '$get_temp_fees_id' && lf.academic_year = '$nextAcademicYear' && lfd.fees_table_name = 'grptable' && gcf.status ='1' ");

}
$feeQueryToUse = ($CheckLastReceiptQry->rowCount() > 0) ? $lastfeeDetailsQry : $feeDetailsQry;
$i=0;
while($grpfeeDetailsInfo = $feeQueryToUse->fetch()){  
    $grpConcessionQry = $connect->query("SELECT COALESCE(SUM(scholarship_amount),0) as grp_schlrshp_amnt, (SELECT COALESCE(SUM(afd.scholarship),0) + COALESCE(SUM(afd.fee_received),0)  FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && afd.fees_table_name = 'grptable' && afd.fees_id = '".$grpfeeDetailsInfo['grp_course_id']."' && af.academic_year ='$academicYear') AS grp_amnt FROM `fees_concession` WHERE `student_id`='$admissionFormId' && `fees_table_name`='grptable' && `fees_id` = '".$grpfeeDetailsInfo['grp_course_id']."' && academic_year ='$academicYear' ");
    $grpConcessionInfo = $grpConcessionQry->fetch();
    $grpTotalScholarshipAmnt = $grpConcessionInfo['grp_schlrshp_amnt'];
    $totalGrpAmnt = $grpConcessionInfo['grp_amnt'];
    $grpLastConcessionQry = $connect->query("SELECT COALESCE(SUM(lfd.scholarship),0) + COALESCE(SUM(lfd.fee_received),0) AS grp_amnt FROM `last_year_fees` lf JOIN last_year_fees_details lfd ON lf.id = lfd.admission_fees_ref_id WHERE lf.admission_id = '$admissionFormId' && lfd.fees_table_name = 'grptable' && lfd.fees_id = '".$grpfeeDetailsInfo['grp_course_id']."' && lf.academic_year ='$nextAcademicYear' ");
    $grpLastConcessionInfo = $grpLastConcessionQry->fetch();
    $totallastGrpAmnt = $grpLastConcessionInfo['grp_amnt'];
    $grpAmount = ($grpfeeDetailsInfo['grp_amount'] != '0') ? $grpfeeDetailsInfo['ovrlAllGrpAmnt'] - $grpTotalScholarshipAmnt - $totalGrpAmnt - $totallastGrpAmnt : $grpfeeDetailsInfo['grp_amount'];
    
?>
<tr>
    <td>
        <input type="hidden" class="form-control" name="feesMasterid[]" value="<?php echo $grpfeeDetailsInfo['fees_id']; ?>">
        <input type="hidden" class="form-control" name="grpid[]" value="<?php echo $grpfeeDetailsInfo['grp_course_id']; ?>">
        <?php echo $grpfeeDetailsInfo['grp_particulars']; ?> 
    </td>
    <td><input type="number" class="form-control grpfeesamnt" name="grpFeeAmnt[]" value="<?php echo $grpAmount; ?>" readonly> </td>
    <td><input type="number" class="form-control grpfeesreceived" name="grpFeeReceived[]" value="0"> </td>
    <td><input type="number" class="form-control grpfeesscholarship" name="grpFeeScholarship[]" value="0"> </td>
    <td><input type="number" class="form-control grpfeesbalance" name="grpFeeBalance[]" value="<?php echo $grpAmount; ?>" readonly> </td>
</tr>
<?php } ?>