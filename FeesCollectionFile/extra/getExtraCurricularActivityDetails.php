<?php
include '../../ajaxconfig.php';

if(isset($_POST['tempAdmissionFormId'])){
    $tempAdmissionFormId = $_POST['tempAdmissionFormId'];
}
if(isset($_POST['academicYear'])){
    $academicYear = $_POST['academicYear'];
}
if(isset($_POST['tempMedium'])){
    $tempMedium = $_POST['tempMedium'];
}
if(isset($_POST['tempStudentType'])){
    $tempStudentType = $_POST['tempStudentType'];
}
if(isset($_POST['tempStandard'])){
    $standardId = $_POST['tempStandard'];
}

$CheckReceiptQry = $connect->query("SELECT * FROM `temp_admission_fees` WHERE TempAdmissionId = '$tempAdmissionFormId' order by id desc limit 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    //(ecaf.extra_amount - tafd.FeeReceived) as extra_amount
    $feeDetailsQry = $connect->query("SELECT tafd.BalancetobePaid as extra_amount, tafd.FeesMasterId as fees_id, tafd.FeesId as extra_fee_id, ecaf.extra_particulars FROM `temp_admission_fees` taf JOIN temp_admissionfees_details tafd ON taf.id = tafd.TempAdmFeeRefId JOIN extra_curricular_activities_fee ecaf ON tafd.FeesId = ecaf.extra_fee_id WHERE taf.id = '$get_temp_fees_id' && tafd.FeesTableName = 'extratable' ");

}else{
    $feeDetailsQry = $connect->query("SELECT fm.fees_id, fm.academic_year, ecaf.*  FROM `fees_master` fm JOIN extra_curricular_activities_fee ecaf ON fm.fees_id = ecaf.fee_master_id where fm.academic_year = '$academicYear' && fm.medium = '$tempMedium' && fm.student_type = '$tempStudentType' && fm.standard = '$standardId' ");
}

$i=0;
while($feeDetailsInfo = $feeDetailsQry->fetch()){
?>
<tr>
    <td>
        <input type="hidden" class="form-control" name="extraFeesMasterid[]" value="<?php echo $feeDetailsInfo['fees_id']; ?>">
        <input type="hidden" class="form-control" name="extraAmntid[]" value="<?php echo $feeDetailsInfo['extra_fee_id']; ?>">
        <?php echo $feeDetailsInfo['extra_particulars']; ?> 
    </td>
    <td><input type="number" class="form-control extrafeesamnt" name="extraAmnt[]" value="<?php echo $feeDetailsInfo['extra_amount']; ?>" readonly> </td>
    <td><input type="number" class="form-control extrafeesreceived" name="extraAmntReceived[]" value="0"> </td>
    <td><input type="number" class="form-control extrafeesscholar" name="extraAmntScholarship[]" value="0"> </td>
    <td><input type="number" class="form-control extrafeesbalance" name="extraAmntBalance[]" value="<?php echo $feeDetailsInfo['extra_amount']; ?>" readonly> </td>
</tr>
<?php } ?>