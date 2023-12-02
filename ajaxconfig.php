<?php
 $con =mysqli_connect("mysql8001.site4now.net", "a87bfa_school", "school@123", "db_a87bfa_school") or die("Error in database connection".mysqli_error($mysqli));
 $host = "mysql8001.site4now.net";  
 $db_user = "a87bfa_school";  
 $db_pass = "school@123";  
 $dbname = "db_a87bfa_school";  

 $connect = new PDO("mysql:host=$host; dbname=$dbname", $db_user, $db_pass); 
 $mysqli=mysqli_connect("mysql8001.site4now.net","a87bfa_school","school@123","db_a87bfa_school");
?>