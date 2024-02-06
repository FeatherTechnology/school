<?php
include '../ajaxconfig.php';

$selectpo=$mysqli->query("SELECT ponumber FROM purchaseorder");
if($selectpo->num_rows>0){
	$poavailable=$mysqli->query("SELECT ponumber FROM purchaseorder ORDER BY purchaseid DESC LIMIT 1");
	while ($row=$poavailable->fetch_assoc()) {
		$ponum2=$row["ponumber"];
	}
	$ponum1 = ltrim(strstr($ponum2, 'O'), 'O')+1;
	$ponum="PO".$ponum1;
}else{
	$initialponum=1001;
	$ponum="PO".$initialponum;
}
echo json_encode($ponum);
?>