<?php
include '../ajaxconfig.php';

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

$CheckReceiptQry = $connect->query("SELECT * FROM `transport_admission_fees` WHERE admission_id = '$admissionFormId' && academic_year = '$academicYear' order by id desc limit 1");
if($CheckReceiptQry->rowCount() > 0){
    $get_temp_fees_id = $CheckReceiptQry->fetch()['id'];
    //(gcf.grp_amount - afd.FeeReceived) as grp_amount
    $feeDetailsQry = $connect->query("SELECT tafd.balance_tobe_paid as due_amount, tafd.area_creation_id as fees_id, tafd.area_creation_particulars_id as particulars_id, ac.area_name, acp.particulars 
    FROM `transport_admission_fees` taf 
    JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id 
    JOIN area_creation ac ON tafd.area_creation_id = ac.area_id
    JOIN area_creation_particulars acp ON tafd.area_creation_particulars_id = acp.particulars_id 
    WHERE taf.id = '$get_temp_fees_id' && taf.academic_year = '$academicYear' ");

echo 'aaaa';
}else{
    echo 'bbbb';
    $feeDetailsQry = $connect->query("SELECT ac.area_id as fees_id, acp.particulars_id as particulars_id, ac.area_name, acp.particulars, acp.due_amount  
    FROM student_creation sc
    JOIN area_creation ac ON sc.transportarearefid = ac.area_id
    JOIN area_creation_particulars acp ON ac.area_id = acp.area_creation_id
    WHERE sc.student_id = '$admissionFormId' ");

}

$i=0;
while($feeDetailsInfo = $feeDetailsQry->fetch()){
?>
<tr>
    <td>
        <input type="hidden" class="form-control" name="areaCreationId[]" value="<?php echo $feeDetailsInfo['fees_id']; ?>">
        <input type="hidden" class="form-control" name="particularId[]" value="<?php echo $feeDetailsInfo['particulars_id']; ?>">
        <?php echo $feeDetailsInfo['particulars']; ?> 
    </td>
    <td><input type="number" class="form-control transportfeesamnt" name="transportFeeAmnt[]" value="<?php echo $feeDetailsInfo['due_amount']; ?>" readonly> </td>
    <td><input type="number" class="form-control transportfeesreceived" name="transportFeeReceived[]" value="0"> </td>
    <td><input type="number" class="form-control transportfeesscholarship" name="transportFeeScholarship[]" value="0"> </td>
    <td><input type="number" class="form-control transportfeesbalance" name="transportFeeBalance[]" value="<?php echo $feeDetailsInfo['due_amount']; ?>" readonly> </td>
</tr>
<?php } ?>