<?php
include '../ajaxconfig.php';

if (isset($_GET['upd'])) {
    $upd = $_GET['upd'];
  
    // Update the student status to mark it as restored
    $updateQuery = "UPDATE student_creation SET deleted_student = 1 WHERE student_id = '$upd' "; 
    $updateResult = $con->query($updateQuery); 

    if ($updateResult) {
        echo 'success';
    } else {
        echo 'Error restoring student: ' . $con->error;
    }
} else {
    echo 'Invalid request';
}
?>
