<?php
include '../../ajaxconfig.php';

if(isset($_POST['admissionFormId'])){
    $admissionFormId = $_POST['admissionFormId'];
}
if(isset($_POST['academicYear'])){
    $academicYear = $_POST['academicYear'];
}
if(isset($_POST['medium'])){
    $medium = $_POST['medium'];
}
if(isset($_POST['studentType'])){
    $studentType = $_POST['studentType'];
}
if(isset($_POST['standard'])){
    $standardId = $_POST['standard'];
}

$CheckReceiptQry = $connect->query("SELECT af.id FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id WHERE af.admission_id = '$admissionFormId' && af.academic_year = '$academicYear' && afd.fees_table_name = 'grptable' ORDER BY af.id DESC LIMIT 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    $feeDetailsQry = $connect->query("SELECT afd.balance_tobe_paid as grp_amount, afd.fees_master_id as fees_id, afd.fees_id as grp_course_id, gcf.grp_particulars FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id JOIN group_course_fee gcf ON afd.fees_id = gcf.grp_course_id WHERE af.id = '$get_temp_fees_id' && af.academic_year = '$academicYear' && afd.fees_table_name = 'grptable' ");

}else{
    $feeDetailsQry = $connect->query("SELECT fm.fees_id, fm.academic_year, gcf.*  FROM `fees_master` fm JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id where fm.academic_year = '$academicYear' && fm.medium = '$medium' && fm.student_type = '$studentType' && fm.standard = '$standardId' ");

}

$i=0;
while($grpfeeDetailsInfo = $feeDetailsQry->fetch()){
    $grpConcessionQry = $connect->query("SELECT SUM(scholarship_amount) as grpTotalScholarshipAmnt FROM `fees_concession` WHERE `student_id`='$admissionFormId' && `fees_table_name`='grptable' && `fees_id` = '".$grpfeeDetailsInfo['grp_course_id']."' ");
    $grpTotalScholarshipAmnt = '0';
    if($grpConcessionQry->rowCount() > 0){
        $grpTotalScholarshipAmnt = $grpConcessionQry->fetch()['grpTotalScholarshipAmnt'];
    }
    $grpAmount = $grpfeeDetailsInfo['grp_amount'] - $grpTotalScholarshipAmnt;
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