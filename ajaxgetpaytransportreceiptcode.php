<?php
include 'ajaxconfig.php';

$selectIC = $con->query("SELECT receipt_number FROM pay_transport_fees WHERE receipt_number != '' ");

if($selectIC->num_rows>0)
{
    $codeAvailable = $con->query("SELECT receipt_number FROM pay_transport_fees WHERE receipt_number != '' ORDER BY pay_transport_fees_id DESC LIMIT 1");
    while($row = $codeAvailable->fetch_assoc()){
        $ac2 = $row["receipt_number"];
    }

    $appno2 = ltrim(strstr($ac2, '-'), '-');
    $appno1 = (int) substr($appno2, 0, strpos($appno2,"/"))+101;
    $receipt_number = "TARC-".$appno1;
}
else
{
    $initialapp = "TARC-101";
    $receipt_number = $initialapp;
}

echo json_encode($receipt_number);

?>