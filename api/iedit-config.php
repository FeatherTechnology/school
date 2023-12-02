<?php
$mysqli = mysqli_connect("mysql8001.site4now.net", "a87bfa_school", "school@123", "db_a87bfa_school") or die("Error in database connection".mysqli_error($mysqli));
mysqli_set_charset($mysqli,"utf8");
$timeZoneQry = "set time_zone = '+5:30' ";
$mysqli->query($timeZoneQry );
?>
