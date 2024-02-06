<?php
include '../ajaxconfig.php';
$getcostcentre=$mysqli->query("SELECT costcentrename FROM costcentre WHERE status=0 ") or die("Error :".$mysqli->error);
while ($row=$getcostcentre->fetch_assoc()) {
	$costcentrenamearray[]=$row["costcentrename"];
}
echo json_encode($costcentrenamearray);
?>