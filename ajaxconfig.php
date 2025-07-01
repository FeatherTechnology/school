<?php
// Set time zone
$timeZoneQry = "SET time_zone = '+5:30'";

// MySQLi connection
$mysqli = mysqli_connect("localhost", "root", "", "akv_school") or die("Error in database connection: " . mysqli_error($mysqli));
mysqli_set_charset($mysqli, "utf8");
$mysqli->query($timeZoneQry);

// PDO connection
try {
    $connect = new PDO("mysql:host=localhost;dbname=akv_school;charset=utf8", "root", "");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect->exec($timeZoneQry);
} catch (PDOException $e) {
    die("Error in PDO connection: " . $e->getMessage());
}
?>