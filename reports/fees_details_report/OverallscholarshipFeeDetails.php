<?php
include "../../ajaxconfig.php";
@session_start();
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}

if(isset($_POST['academicyear'])){
    $academicyear = $_POST['academicyear'];
    $splityear = explode('-',$academicyear); 
    $lastyear = intval($splityear[0]-1).'-'.intval($splityear[1]-1);
}
if(isset($_POST['stdMedium'])){
    $stdMedium = $_POST['stdMedium'];
}
if(isset($_POST['stdStandard'])){
    $stdStandard = $_POST['stdStandard'];
}
if(isset($_POST['stdSection'])){
    $stdSection = $_POST['stdSection'];
}
if(isset($_POST['feeType'])){
    $feeType = $_POST['feeType']; //1=school, 2=extra/book, 3=Lastyear, 4=Transportation
}

if($feeType == '1'){ //school
?>

<table class="table table-bordered" id="show_student_scholarship_list">
    <thead>
        <tr><th colspan='8'>School Scholarship Fee At <?php echo date('d-m-Y'); ?></th></tr>
        <tr>
            <th>S.No</th>
            <th>Admission Number</th>
            <th>Student Name</th>
            <th>Standard & Section</th>
            <th>Mobile No</th>
            <th>Concession Fee Name</th>
            <th>Concession Fee</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>

<?php
$getStudentListQry = $connect->query("SELECT sc.admission_number, sc.student_name, std.standard, sc.section, sc.sms_sent_no, fc.scholarship_amount, gcf.grp_particulars AS concession_fee_name, fc.remark
FROM `student_creation` sc 
JOIN standard_creation std ON sc.standard = std.standard_id
JOIN fees_concession fc ON sc.student_id = fc.student_id
LEFT JOIN group_course_fee gcf ON gcf.grp_course_id = fc.fees_id AND fc.fees_table_name='grptable'
WHERE fc.academic_year = '$academicyear' && sc.medium = '$stdMedium' &&  sc.standard = '$stdStandard' && ($stdSection = '0' OR sc.section = '$stdSection') && sc.status = '0' && fc.fees_table_name != 'transport' && fc.fees_table_name !='extratable' && fc.fees_table_name !='amenitytable' && sc.school_id = '$school_id' ");
$i=1;
$schoolScholarshipTotal=0;
while($studentList = $getStudentListQry->fetchObject()){    
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard.' - '.$studentList->section; ?></td>
        <td><?php echo $studentList->sms_sent_no; ?></td>
        <td><?php echo $studentList->concession_fee_name; ?></td>
        <td><?php echo $studentList->scholarship_amount; ?></td>
        <td><?php echo $studentList->remark; ?></td>
    </tr>
<?php 
$schoolScholarshipTotal += $studentList->scholarship_amount;
} ?>
<tr style="font-weight: bold;">
    <td><?php echo $i; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Grand Total</td>
    <td><?php echo $schoolScholarshipTotal; ?></td>
    <td></td>
</tr>
</tbody>
</table>

<?php }else if($feeType == '2'){ //Extra ?> 
    <table class="table table-bordered" id="show_student_scholarship_list">
    <thead>
        <tr><th colspan='8'>Extra/Book Scholarship Fee At <?php echo date('d-m-Y'); ?></th></tr>
        <tr>
            <th>S.No</th>
            <th>Admission Number</th>
            <th>Student Name</th>
            <th>Standard & Section</th>
            <th>Mobile No</th>
            <th>Concession Fee Name</th>
            <th>Concession Fee</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>

<?php
$getStudentListQry = $connect->query("SELECT sc.admission_number, sc.student_name, std.standard, sc.section, sc.sms_sent_no, fc.scholarship_amount, 
CASE 
	WHEN(fc.fees_table_name='extratable') THEN ecaf.extra_particulars 
	WHEN(fc.fees_table_name='amenitytable') THEN af.amenity_particulars 
ELSE ''
END AS concession_fee_name, fc.remark
FROM `student_creation` sc 
JOIN standard_creation std ON sc.standard = std.standard_id
JOIN fees_concession fc ON sc.student_id = fc.student_id
LEFT JOIN extra_curricular_activities_fee ecaf ON ecaf.extra_fee_id = fc.fees_id AND fc.fees_table_name = 'extratable'
LEFT JOIN amenity_fee af ON af.amenity_fee_id = fc.fees_id AND fc.fees_table_name = 'amenitytable'
WHERE fc.academic_year = '$academicyear' && sc.medium = '$stdMedium' &&  sc.standard = '$stdStandard' && ($stdSection = '0' OR sc.section = '$stdSection') && sc.status = '0' && fc.fees_table_name != 'transport' && fc.fees_table_name != 'grptable' && sc.school_id = '$school_id' ");
$i=1;
$grnd_total_amount = 0;
while($studentList = $getStudentListQry->fetchObject()){   
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard.' - '.$studentList->section; ?></td>
        <td><?php echo $studentList->sms_sent_no; ?></td>
        <td><?php echo $studentList->concession_fee_name; ?></td>
        <td><?php echo $studentList->scholarship_amount; ?></td>
        <td><?php echo $studentList->remark; ?></td>
    </tr>
<?php
$grnd_total_amount += $studentList->scholarship_amount;
} ?>
<tr style="font-weight: bold;">
    <td><?php echo $i; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Grand Total</td>
    <td><?php echo $grnd_total_amount; ?></td>
    <td></td>
</tr>
</tbody>
</table>
<?php }else if($feeType =='3'){ //Last year ?>
    <table class="table table-bordered" id="show_student_scholarship_list">
    <thead>
        <tr><th colspan='8'>Lastyear Scholarship Fee At <?php echo date('d-m-Y'); ?></th></tr>
        <tr>
            <th>S.No</th>
            <th>Admission Number</th>
            <th>Student Name</th>
            <th>Standard & Section</th>
            <th>Mobile No</th>
            <th>Concession Fee Name</th>
            <th>Concession Fee</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>

<?php
$getStudentListQry = $connect->query("SELECT sc.admission_number, sc.student_name, std.standard, sc.section, sc.sms_sent_no, fc.scholarship_amount, 
CASE 
	WHEN(fc.fees_table_name='grptable') THEN gcf.grp_particulars
	WHEN(fc.fees_table_name='extratable') THEN ecaf.extra_particulars 
	WHEN(fc.fees_table_name='amenitytable') THEN af.amenity_particulars 
    WHEN(fc.fees_table_name='transport') THEN acp.particulars
ELSE ''
END AS concession_fee_name, fc.remark
FROM `student_creation` sc 
JOIN standard_creation std ON sc.standard = std.standard_id
JOIN fees_concession fc ON sc.student_id = fc.student_id
LEFT JOIN group_course_fee gcf ON gcf.grp_course_id = fc.fees_id AND fc.fees_table_name='grptable'
LEFT JOIN extra_curricular_activities_fee ecaf ON ecaf.extra_fee_id = fc.fees_id AND fc.fees_table_name = 'extratable'
LEFT JOIN amenity_fee af ON af.amenity_fee_id = fc.fees_id AND fc.fees_table_name = 'amenitytable'
LEFT JOIN area_creation_particulars acp ON acp.particulars_id = fc.fees_id AND fc.fees_table_name = 'transport' 
WHERE fc.academic_year = '$lastyear' && sc.medium = '$stdMedium' &&  sc.standard = '$stdStandard' && ($stdSection = '0' OR sc.section = '$stdSection') && sc.status = '0' && sc.school_id = '$school_id' ");
$i=1;
$grnd_lastyr_total_fee = 0;
while($studentList = $getStudentListQry->fetchObject()){
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard.' - '.$studentList->section; ?></td>
        <td><?php echo $studentList->sms_sent_no; ?></td>
        <td><?php echo $studentList->concession_fee_name.'('.$lastyear.')'; ?></td>
        <td><?php echo $studentList->scholarship_amount; ?></td>
        <td><?php echo $studentList->remark; ?></td>
    </tr>
<?php 
$grnd_lastyr_total_fee += $studentList->scholarship_amount;
} ?>
<tr style="font-weight: bold;">
    <td><?php echo $i; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Grand Total</td>
    <td><?php echo $grnd_lastyr_total_fee; ?></td>
    <td></td>
</tr>
</tbody>
</table>

<?php }else if($feeType == '4'){//transport ?>

    <table class="table table-bordered" id="show_student_scholarship_list">
    <thead>
        <tr><th colspan='8'>Transport Scholarship Fee At <?php echo date('d-m-Y'); ?></th></tr>
        <tr>
            <th>S.No</th>
            <th>Admission Number</th>
            <th>Student Name</th>
            <th>Standard & Section</th>
            <th>Mobile No</th>
            <th>Concession Fee Name</th>
            <th>Concession Fee</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>

<?php
$getStudentListQry = $connect->query("SELECT sc.admission_number, sc.student_name, std.standard, sc.section, sc.sms_sent_no, fc.scholarship_amount, acp.particulars AS concession_fee_name, fc.remark
FROM `student_creation` sc 
JOIN standard_creation std ON sc.standard = std.standard_id
JOIN fees_concession fc ON sc.student_id = fc.student_id
LEFT JOIN area_creation_particulars acp ON acp.particulars_id = fc.fees_id AND fc.fees_table_name = 'transport'
WHERE fc.academic_year = '$academicyear' && sc.medium = '$stdMedium' &&  sc.standard = '$stdStandard' && ($stdSection = '0' OR sc.section = '$stdSection') && sc.status = '0' && fc.fees_table_name = 'transport' && sc.school_id = '$school_id' ");
$i=1;
$grnd_total_fee = 0;
while($studentList = $getStudentListQry->fetchObject()){
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard.' - '.$studentList->section; ?></td>
        <td><?php echo $studentList->sms_sent_no; ?></td>
        <td><?php echo $studentList->concession_fee_name; ?></td>
        <td><?php echo $studentList->scholarship_amount; ?></td>
        <td><?php echo $studentList->remark; ?></td>
    </tr>
<?php 
$grnd_total_fee += $studentList->scholarship_amount;
} ?>
<tr style="font-weight: bold;">
    <td><?php echo $i; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Grand Total</td>
    <td><?php echo $grnd_total_fee; ?></td>
    <td></td>
</tr>
</tbody>
</table>

<?php } ?>


<script>
    $(document).ready(function(){
        $('#show_student_scholarship_list').DataTable({
            order: [[0, "asc"]],
            columnDefs: [
                { type: 'natural', targets: 0 }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>