<?php
require "../ajaxconfig.php";

$year_id = $_POST['year_id'];
$academic_year = $_POST['academic_year'];
try {
    $qry = $connect->query("SELECT * FROM admission_fees WHERE academic_year = '$academic_year' ");
    if ($qry->rowCount() == 1) { //If Only one count of kyc for the customer then restrict to delete.
        $result = '0';
    } else {
        $qry = $connect->prepare("DELETE FROM `academic_year` WHERE `year_id` = :year_id");
        $qry->bindParam(':year_id', $year_id, PDO::PARAM_INT);
        if ($qry->execute()) {
            $result = 1; // Deleted.
        } else {
            throw new Exception();
        }
    }
} catch (Exception $e) {
    $result = 2; // Handle general exceptions
}

echo json_encode($result);