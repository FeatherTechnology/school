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

$CheckReceiptQry = $connect->query("SELECT id FROM `admission_fees` WHERE admission_id = '$admissionFormId' order by id desc limit 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    //(ecaf.extra_amount - afd.FeeReceived) as extra_amount
    $feeDetailsQry = $connect->query("SELECT afd.balance_tobe_paid as extra_amount, afd.fees_master_id as fees_id, afd.fees_id as extra_fee_id, ecaf.extra_particulars FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id WHERE af.id = '$get_temp_fees_id' && afd.fees_table_name = 'extratable' ");

}else{
    $feeDetailsQry = $connect->query("SELECT fm.fees_id, fm.academic_year, ecaf.*  FROM `fees_master` fm JOIN extra_curricular_activities_fee ecaf ON fm.fees_id = ecaf.fee_master_id where fm.academic_year = '$academicYear' && fm.medium = '$medium' && fm.student_type = '$studentType' && fm.standard = '$standardId' ");
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