<?php
include '../ajaxconfig.php';

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id']; 
} 

if (isset($_POST['reason'])) {
    $reason = $_POST['reason'];
}


$query = "SELECT af.balance_tobe_paid FROM `admission_fees` af JOIN admission_fees_denomination afd ON af.id = afd.admission_fees_ref_id JOIN admission_fees_details afds ON af.id = afds.admission_fees_ref_id WHERE af.admission_id = '$student_id' ORDER BY af.id DESC LIMIT 1 "; 
$result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_object();
            if ($row->balance_tobe_paid > 0){
                echo "Student cannot be deleted. Student fees are Pending for the academic year.";
            
            }else{
                echo deleteStudentCreation($mysqli, $reason, $student_id);
            }
        }else {
                echo deleteStudentCreation($mysqli, $reason, $student_id);
        // echo "Student name not found. Please make sure the student has paid fees.";
    }

    function deleteStudentCreation($mysqli, $reason, $student_id){
        // Update the student status to mark it as deleted
        $updateQuery = "UPDATE student_creation SET reason = '$reason', status = 1, deleted_student = 1 WHERE student_id = '$student_id' ";
        $updateResult = $mysqli->query($updateQuery);

        if ($updateResult) {
            $insertquery = "INSERT INTO `deleted_student_creation`( `student_id`, `status`) 
            VALUES('".strip_tags($student_id)."','0')";
            $insresult = $mysqli->query($insertquery);
            return "Student deleted Successfully.";
    
        } else {
            return "Error deleting student: " . $mysqli->error;
        }
    }
?>