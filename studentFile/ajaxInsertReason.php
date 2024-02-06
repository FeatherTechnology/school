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
                echo "Student cannot be deleted. Student fees are pending for the academic year.";
            
            }else{
                // Update the student status to mark it as deleted
                $updateQuery = "UPDATE student_creation SET reason = '$reason', status = 1 WHERE student_id = '$student_id' ";
                $updateResult = $mysqli->query($updateQuery);

                if ($updateResult) {
                    $insertquery = "INSERT INTO `deleted_student_creation`( `student_id`, `status`) 
                    VALUES('".strip_tags($student_id)."','0')";
                    $insresult = $mysqli->query($insertquery);
                    echo "Student deleted successfully.";
            
                } else {
                    echo "Error deleting student: " . $mysqli->error;
                }
            }
        }else {
        echo "Student name not found. Please make sure the student has paid fees.";
    }

?>


<!-- // $query = "SELECT * FROM pay_fees WHERE student_id = $student_id"; 
// $result = $mysqli->query($query);

// if ($result) {  
//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $grp_particulars = explode(",", $row['grp_particulars']);
//             $extra_particulars = explode(",", $row['extra_particulars']);
//             $amenity_particulars = explode(",", $row['amenity_particulars']);
//             $amount_balance = explode(",", $row['amount_balance']);
//             $extra_amount_balance = explode(",", $row['extra_amount_balance']);
//             $amenity_amount_balance = explode(",", $row['amenity_amount_balance']);

//             $isDeletable = true;

//             $filteredAmountBalance = array_filter($amount_balance, function($value) {
//                 return !empty($value);
//             });
//             $filteredExtraAmountBalance = array_filter($extra_amount_balance, function($value) {
//                 return !empty($value);
//             });
//             $filteredAmenityAmountBalance = array_filter($amenity_amount_balance, function($value) {
//                 return !empty($value);
//             });

//             if ($filteredAmountBalance || $filteredExtraAmountBalance || $filteredAmenityAmountBalance) {
//                 echo "Student cannot be deleted. Student fees are pending for the academic year.";
//             } else {
//                 $student_id = $row['student_id'];

//                 // Update the student status to mark it as deleted
//                 $updateQuery = "UPDATE student_creation SET reason = '$reason', status = 1 WHERE student_id = '$student_id' ";
//                 $updateResult = $mysqli->query($updateQuery);

//                 if ($updateResult) {
//                     $insertquery = "INSERT INTO `deleted_student_creation`( `student_id`, `status`) 
//                     VALUES('".strip_tags($student_id)."','0')";

//                     $insresult = $mysqli->query($insertquery);
//                     echo "Student deleted successfully.";
            
//                 } else {
//                     echo "Error deleting student: " . $mysqli->error;
//                 }
//             }
//         }
//     } else {
//         echo "Student name not found. Please make sure the student has paid fees.";
//     }
// } else {
//     echo "Error executing query: " . $mysqli->error;
// } -->