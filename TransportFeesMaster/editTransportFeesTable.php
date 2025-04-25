<?php
include '../ajaxconfig.php';

if (isset($_POST['fees_id'])) {
    $feesid = $_POST['fees_id'];

    // Fetch admission fees
    $editTransportFeesQry = $connect->query("SELECT * FROM `transport_admission_fees` WHERE `id` ='$feesid' ");
    $editTransportFees = $editTransportFeesQry->fetch(PDO::FETCH_ASSOC);

    // Fetch fee details
    $editTransportFeesDetailsQry = $connect->query("SELECT * FROM `transport_admission_fees_details` WHERE `admission_fees_ref_id` ='$feesid'");

    $transportFeesHtml = '';
    while ($feeDetail = $editTransportFeesDetailsQry->fetch(PDO::FETCH_ASSOC)) {
            $grpFee = $connect->query("SELECT * FROM area_creation_particulars WHERE particulars_id = '" . $feeDetail['area_creation_particulars_id'] . "'")->fetch(PDO::FETCH_ASSOC);
            $transportAmount = $feeDetail['fee_received'] + $feeDetail['balance_tobe_paid'] + $feeDetail['scholarship'];

            $transportFeesHtml .= '<tr>
                <td>
                    <input type="hidden" class="form-control" name="areaCreationId[]" value="' . $feeDetail['area_creation_id'] . '">
                    <input type="hidden" class="form-control" name="particularId[]" value="' . $grpFee['particulars_id'] . '">
                    ' . $grpFee['particulars'] . '
                </td>
                <td><input type="number" class="form-control transportfeesamnt" name="transportFeeAmnt[]" value="' . $transportAmount . '" readonly></td>
                <td><input type="number" class="form-control transportfeesreceived" name="transportFeeReceived[]" value="' . $feeDetail['fee_received'] . '"></td>
                <td><input type="number" class="form-control transportfeesscholarship" name="transportFeeScholarship[]" value="' . $feeDetail['scholarship'] . '"></td>
                <td><input type="number" class="form-control transportfeesbalance" name="transportFeeBalance[]" value="' . $feeDetail['balance_tobe_paid']  . '" readonly></td>
            </tr>';
        
    }
    $denomination = $connect->query("SELECT * FROM transport_admission_fees_denomination  WHERE `admission_fees_ref_id` ='$feesid'")->fetch(PDO::FETCH_ASSOC); 
    $payment_mode = $denomination['payment_mode'];
    $response = array(
        'group' => $transportFeesHtml,
        'academic_year' => $editTransportFees['academic_year'],
        'receipt_no' => $editTransportFees['receipt_no'],
        'receipt_date' => $editTransportFees['receipt_date'],
        'payment_mode' => $denomination['payment_mode'],
        'scholarship' => $editTransportFees['scholarship'],
        'fees_collected' => $editTransportFees['fees_collected'],
        'denomination' => $denomination // Add entire denomination row
    );

    echo json_encode($response);
    exit;
}
