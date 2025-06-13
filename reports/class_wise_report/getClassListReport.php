<?php
include "../../ajaxconfig.php";
@session_start();
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}

if(isset($_POST['academicyear'])){
    $academicyear = $_POST['academicyear'];
}
if(isset($_POST['stdMedium'])){
    $stdMedium = $_POST['stdMedium'];
}
// Add standard condition if not 'all'
if(isset($_POST['stdStandard'])){
    $stdStandard = $_POST['stdStandard'];
    if ($stdStandard != 'all') {
        $conditions[] = "sh.standard = '$stdStandard'";
    }
}

// Add section condition if not 'all'
if(isset($_POST['stdSection'])){
    $stdSection = $_POST['stdSection'];
    if ($stdSection != 'all') {
        $conditions[] = "sh.section = '$stdSection'";
    }
}  

$whereClause = "";
if (!empty($conditions)) {
    $whereClause = " AND " . implode(" AND ", $conditions);
}
// Dynamic ORDER BY clause
if ($stdStandard == 'all') {
    $orderBy = " ORDER BY std.standard ASC";
} else {
    $orderBy = " ORDER BY sc.student_name ASC";
}

?>

<table class="table table-bordered" id="show_student_classwise_list">
    <thead>
        <th>S.No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Standard</th>
        <th>Section</th>
        <th>Date of Birth</th>
        <th>Aadhar Number</th>
        <th>Gender</th>
        <th>Father Name</th>
        <th>Mother Name</th>
        <th>Mobile No</th>
        <th>Address</th>
    </thead>
    <tbody>

<?php
$i=1;
$getStudentListQry = $connect->query("
    SELECT 
        sc.student_name, std.standard, sh.section, sc.date_of_birth, 
        sc.aadhar_number, sc.father_name, sc.mother_name, sc.admission_number, 
        sc.gender, sc.flat_no, sc.street, sc.area_locatlity, sc.district, 
        sc.pincode, sc.sms_sent_no 
    FROM student_creation sc 
    JOIN student_history sh ON sh.student_id = sc.student_id 
    JOIN standard_creation std ON sh.standard = std.standard_id 
    WHERE 
        sh.academic_year = '$academicyear' 
        AND sc.medium = '$stdMedium' 
        AND sc.status = '0' 
        AND sc.school_id = '$school_id' 
        $whereClause
   $orderBy
");
while($studentList = $getStudentListQry->fetchObject()){
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $studentList->admission_number; ?></td>
        <td><?php echo $studentList->student_name; ?></td>
        <td><?php echo $studentList->standard; ?></td>
        <td><?php echo $studentList->section; ?></td>
        <td><?php echo date("d-m-Y", strtotime($studentList->date_of_birth)); ?></td>
        <td><?php echo $studentList->aadhar_number; ?></td>
         <td><?php echo $studentList->gender; ?></td>
        <td><?php echo $studentList->father_name; ?></td>
        <td><?php echo $studentList->mother_name; ?></td>
        <td><?php echo $studentList->sms_sent_no; ?></td>
        <td><?php echo $studentList->flat_no.', '.$studentList->street.', '.$studentList->area_locatlity.', '.$studentList->district.', '.$studentList->pincode; ?></td>
    </tr>
<?php } ?>
    </tbody>
    </table>

<script>
    $(document).ready(function(){
        $('#show_student_classwise_list').DataTable({
            order: [[0, "asc"]],
            columnDefs: [
                { type: 'natural', targets: 0 }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
              ordering: false
        });
    });
</script>