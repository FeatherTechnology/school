<?php
include 'ajaxconfig.php';

$selectIC = $con->query("SELECT receipt_number FROM pay_last_year_fees WHERE receipt_number != '' ");

if($selectIC->num_rows>0)
{
    $codeAvailable = $con->query("SELECT receipt_number FROM pay_last_year_fees WHERE receipt_number != '' ORDER BY pay_last_year_fees_id DESC LIMIT 1");
    while($row = $codeAvailable->fetch_assoc()){
        $ac2 = $row["receipt_number"];
    }

    $appno1 = ltrim(strstr($ac2, 'T'), 'T')+1;
	$receipt_number="LAST".$appno1;
}
else
{
    $initialgrno=1001;
	$receipt_number="LAST".$initialgrno;
}


echo json_encode($receipt_number);

?>