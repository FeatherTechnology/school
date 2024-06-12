<?php
$timeZoneQry = "SET time_zone = '+5:30' ";

$mysqli =mysqli_connect("localhost", "root", "", "school") or die("Error in database connection".mysqli_error($mysqli));
mysqli_set_charset($mysqli, "utf8");
$mysqli->query($timeZoneQry);

$host = "localhost";  
$db_user = "root";  
$db_pass = "";  
$dbname = "school";  

$connect = new PDO("mysql:host=$host; dbname=$dbname", $db_user, $db_pass); 
$connect->exec($timeZoneQry);
?>