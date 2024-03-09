<?php
include "../../ajaxconfig.php";

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
?>

<table class="table table-bordered" id="show_student_allPending_list">
    <thead>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">Admission Number</th>
            <th rowspan="2">Student Name</th>
            <th rowspan="2">Standard & Section</th>
            <th rowspan="2">Last Year Pending</th>
            <th colspan="3">Pending Fees</th>
            <th rowspan="2">Book</th>
            <th colspan="3">Transport Fees</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>Term I</th>
            <th>Term II</th>
            <th>Term III</th>
            <th>Term I</th>
            <th>Term II</th>
            <th>Term III</th>
        </tr>
    </thead>
    <tbody>

<?php
$getStudentListQry = $connect->query("SELECT sc.student_id, sc.admission_number, sc.student_name, std.standard, sc.section, sc.extra_curricular, sc.transportarearefid, sc.studentstype 
FROM `student_creation` sc 
JOIN standard_creation std ON sc.standard = std.standard_id
WHERE sc.year_id = '$academicyear' && sc.medium = '$stdMedium' && sc.standard = '$stdStandard' && sc.section = '$stdSection' && sc.status = '0' ");
$i=1;
while($studentList = $getStudentListQry->fetchObject()){
    $getLastYearPending = $connect->query("SELECT SUM(pending) as total_balance_tobe_paid
    FROM (
        (SELECT ( (SELECT SUM(gcf.grp_amount) FROM group_course_fee gcf WHERE gcf.fee_master_id = afd.fees_master_id ) ) - ( (SUM(afd.fee_received) + SUM(afd.scholarship) ) ) AS pending 
        FROM admission_fees af 
        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
        WHERE af.admission_id = '$studentList->student_id' 
        AND af.academic_year = '$lastyear' 
        AND afd.fees_table_name = 'grptable' 
        AND afd.fee_received > 0
        ORDER BY af.id ASC)
    UNION 
        (SELECT ( (SELECT SUM(ecaf.extra_amount) FROM  extra_curricular_activities_fee ecaf WHERE ecaf.fee_master_id = afd.fees_master_id ) ) - ( (SUM(afd.fee_received) + SUM(afd.scholarship) ) ) AS pending
        FROM admission_fees af 
        JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
        WHERE af.admission_id = '$studentList->student_id' 
        AND af.academic_year = '$lastyear' 
        AND afd.fees_table_name = 'extratable' 
        AND afd.fee_received > 0
        ORDER BY af.id ASC)
    UNION 
        (SELECT ( (SELECT SUM(af.amenity_amount) FROM amenity_fee af WHERE af.fee_master_id = afd.fees_master_id ) ) - ( (SUM(afd.fee_received) + SUM(afd.scholarship) ) ) AS pending
        FROM admission_fees afs 
        JOIN admission_fees_details afd ON afs.id = afd.admission_fees_ref_id 
        WHERE afs.admission_id = '$studentList->student_id' 
        AND afs.academic_year = '$lastyear' 
        AND afd.fees_table_name = 'amenitytable' 
        ORDER BY afs.id ASC)
    ) as total_balance ");
    $lastyearpending = $getLastYearPending->fetchObject();
    $lsPending = $lastyearpending->total_balance_tobe_paid;

    $getTermPendingQry = $connect->query("SELECT ( gcf.grp_amount - (SELECT (SUM(afd.fee_received) + SUM(afd.scholarship)) FROM admission_fees_details afd JOIN admission_fees af ON afd.admission_fees_ref_id = af.id WHERE afd.fees_id = gcf.grp_course_id AND afd.fees_table_name = 'grptable' AND af.admission_id = '$studentList->student_id') ) AS termPending  FROM fees_master fm JOIN group_course_fee gcf ON fm.fees_id = gcf.fee_master_id WHERE fm.academic_year = '$academicyear' && fm.medium = '$stdMedium' && fm.student_type = '$studentList->studentstype' && fm.standard = '$stdStandard' ORDER BY gcf.grp_course_id ASC");
    $term_pending = array();
    while($termPendingInfo = $getTermPendingQry->fetch()){
        $term_pending[] = $termPendingInfo['termPending'];
    }
    
    $extra_id = ($studentList->extra_curricular) ? $studentList->extra_curricular : '0';
    $getBookPendingQry = $connect->query("SELECT COALESCE(( ecaf.extra_amount - (SELECT (COALESCE(SUM(afd.fee_received), 0) + COALESCE(SUM(afd.scholarship), 0)) FROM admission_fees_details afd JOIN admission_fees af ON afd.admission_fees_ref_id = af.id WHERE afd.fees_id = ecaf.extra_fee_id AND afd.fees_table_name = 'extratable' AND af.admission_id = '$studentList->student_id') ), 0) AS bookPending FROM extra_curricular_activities_fee ecaf WHERE FIND_IN_SET('$extra_id', ecaf.extra_fee_id)");
    if($getBookPendingQry->rowCount() > 0){
        $book_pending = $getBookPendingQry->fetch()['bookPending'];
    }else{
        $book_pending = '0';
    }

    $transport_id = ($studentList->transportarearefid) ? $studentList->transportarearefid : '0';
    $getTransportPendingQry = $connect->query("SELECT ( acp.due_amount - (SELECT (SUM(tafd.fee_received) + SUM(tafd.scholarship)) FROM transport_admission_fees_details tafd JOIN transport_admission_fees taf WHERE tafd.area_creation_particulars_id = acp.particulars_id AND taf.admission_id = '$studentList->student_id') ) AS transport_pending from area_creation ac JOIN area_creation_particulars acp ON ac.area_id = acp.area_creation_id WHERE ac.area_id = '$transport_id' ORDER BY acp.particulars_id ASC ");
    $transport_pending = array();
    while($transportPendingInfo = $getTransportPendingQry->fetch()){
        $transport_pending[] = $transportPendingInfo['transport_pending'];
    }

?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard.' - '.$studentList->section; ?></td>
        <td><?php echo ($lsPending > 0 ) ? $lsPending : '0'; ?></td>
        <td><?php echo ($term_pending) ? $term_pending[0] : '0'; ?></td>
        <td><?php echo ($term_pending) ? $term_pending[1] : '0'; ?></td>
        <td><?php echo ($term_pending) ? $term_pending[2] : '0'; ?></td>
        <td><?php echo $book_pending; ?></td>
        <td><?php echo ($transport_pending) ? $transport_pending[0] : '0'; ?></td>
        <td><?php echo ($transport_pending) ? $transport_pending[1] : '0'; ?></td>
        <td><?php echo ($transport_pending) ? $transport_pending[2] : '0'; ?></td>
        <td></td>
    </tr>
<?php } ?>
    </tbody>
    </table>

<script>
    $(document).ready(function(){
        $('#show_student_allPending_list').DataTable({
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