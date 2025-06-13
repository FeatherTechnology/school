<?php
include "../../ajaxconfig.php";
@session_start();
if (isset($_SESSION['school_id'])) {
    $school_id = $_SESSION['school_id'];
}

if (isset($_POST['academicyear'])) {
    $academicyear = $_POST['academicyear'];
}
if (isset($_POST['stdMedium'])) {
    $stdMedium = $_POST['stdMedium'];
}
if (isset($_POST['stdStandard'])) {
    $stdStandard = $_POST['stdStandard'];
}
if (isset($_POST['stdSection'])) {
    $stdSection = $_POST['stdSection'];
}
?>

<table class="table table-bordered" id="new_student_list">
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
        $conditions = [];
        $conditions[] = "sh.academic_year = '$academicyear'";
        $conditions[] = "sc.medium = '$stdMedium'";
        $conditions[] = "sc.status = '0'";
        $conditions[] = "sc.school_id = '$school_id'";
        $conditions[] = "sc.created_date BETWEEN ay.period_from AND ay.period_to";

        // Standard condition (only if not 'all')
        if ($stdStandard != 'all') {
            $conditions[] = "sh.standard = '$stdStandard'";
        }

        // Section condition (only if not 'all')
        if ($stdSection != 'all') {
            $conditions[] = "sh.section = '$stdSection'";
        }

        // Combine all conditions
        $whereClause = implode(" AND ", $conditions);

        // Final query
        $getStudentListQry = $connect->query("
    SELECT 
        sc.student_name, std.standard, sh.section, sc.father_name, sc.mother_name, 
        sc.admission_number, sc.gender, sc.date_of_birth, sc.aadhar_number, 
        sc.flat_no, sc.street, sc.area_locatlity, sc.district, sc.pincode, sc.sms_sent_no 
    FROM 
        student_creation sc 
    JOIN 
        student_history sh ON sh.student_id = sc.student_id 
    JOIN 
        standard_creation std ON sh.standard = std.standard_id 
    JOIN 
        academic_year ay ON ay.academic_year = '$academicyear'
    WHERE 
        $whereClause
    ORDER BY 
        sc.standard ASC
");

$i=1;
        while ($studentList = $getStudentListQry->fetchObject()) {
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
                <td><?php echo $studentList->flat_no . ', ' . $studentList->street . ', ' . $studentList->area_locatlity . ', ' . $studentList->district . ', ' . $studentList->pincode; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#new_student_list').DataTable({
             order: [[0, "asc"]],
            columnDefs: [{
                type: 'natural',
                targets: 0
            }],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             ordering: false
        });
    });
</script>