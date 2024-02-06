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

$CheckReceiptQry = $connect->query("SELECT * FROM `admission_fees` WHERE admission_id = '$admissionFormId' && academic_year = '$academicYear' order by id desc limit 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    //(af.amenity_amount - afd.FeeReceived) as amenity_amount
    $feeDetailsQry = $connect->query("SELECT afd.balance_tobe_paid as amenity_amount, afd.fees_master_id as fees_id, afd.fees_id as amenity_fee_id, af.amenity_particulars FROM `admission_fees` afs JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id JOIN amenity_fee af ON afd.fees_id = af.amenity_fee_id WHERE afs.id = '$get_temp_fees_id' && afs.academic_year = '$academicYear' && afd.fees_table_name = 'amenitytable' ");

}else{
    $feeDetailsQry = $connect->query("SELECT fm.fees_id, fm.academic_year, af.*  FROM `fees_master` fm JOIN amenity_fee af ON fm.fees_id = af.fee_master_id where fm.academic_year = '$academicYear' && fm.medium = '$medium' && fm.student_type = '$studentType' && fm.standard = '$standardId' ");
}

$i=0;
while($feeDetailsInfo = $feeDetailsQry->fetch()){
?>
<tr>
    <td>
        <input type="hidden" class="form-control" name="amenityFeesMasterid[]" value="<?php echo $feeDetailsInfo['fees_id']; ?>" readonly>
        <input type="hidden" class="form-control" name="amenityAmntid[]" value="<?php echo $feeDetailsInfo['amenity_fee_id']; ?>" readonly>
        <?php echo $feeDetailsInfo['amenity_particulars']; ?> 
    </td>
    <td><input type="number" class="form-control amenityfees" name="amenityAmnt[]" value="<?php echo $feeDetailsInfo['amenity_amount']; ?>" readonly> </td>
    <td><input type="number" class="form-control amenityfeesreceived" name="amenityAmntReceived[]" value="0"> </td>
    <td><input type="number" class="form-control amenityfeesscholar" name="amenityAmntScholarship[]" value="0"> </td>
    <td><input type="number" class="form-control amenityfeesbalance" name="amenityAmntBalance[]" value="<?php echo $feeDetailsInfo['amenity_amount']; ?>" readonly> </td>
</tr>
<?php } ?>