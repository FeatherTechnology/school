<?php
include '../../ajaxconfig.php';

if (isset($_POST['fees_id'])) {
    $feesid = $_POST['fees_id'];
    // Fetch admission fees
    $editAdmissionFeesQry = $connect->query("SELECT * FROM `admission_fees` WHERE `id` ='$feesid' ");
    $editAdmissionFees = $editAdmissionFeesQry->fetch(PDO::FETCH_ASSOC);
    // Fetch fee details
    $editAdmissionFeesDetailsQry = $connect->query("SELECT * FROM `admission_fees_details` WHERE `admission_fees_ref_id` ='$feesid'");
    $groupFeesHtml = '';
    $extraFeesHtml = '';
    $amenityFeesHtml = '';
    while ($feeDetail = $editAdmissionFeesDetailsQry->fetch(PDO::FETCH_ASSOC)) {
        $feesTable = $feeDetail['fees_table_name'];
        if ($feesTable == 'grptable') {
            $grpFee = $connect->query("SELECT * FROM group_course_fee WHERE grp_course_id = '" . $feeDetail['fees_id'] . "'")->fetch(PDO::FETCH_ASSOC);
            $grpAmount = $feeDetail['fee_received'] + $feeDetail['balance_tobe_paid'] + $feeDetail['scholarship'] ;
            $groupFeesHtml .= '<tr>
                <td>
                    <input type="hidden" name="feesMasterid[]" value="' . $feeDetail['fees_master_id'] . '">
                    <input type="hidden" name="grpid[]" value="' . $grpFee['grp_course_id'] . '">
                    ' . $grpFee['grp_particulars'] . '
                </td>
                <td><input type="number" class="form-control grpfeesamnt" name="grpFeeAmnt[]" value="' . $grpAmount . '" readonly></td>
                <td><input type="number" class="form-control grpfeesreceived" name="grpFeeReceived[]" value="' . $feeDetail['fee_received'] . '"></td>
                <td><input type="number" class="form-control grpfeesscholarship" name="grpFeeScholarship[]" value="' . $feeDetail['scholarship'] . '"></td>
                <td><input type="number" class="form-control grpfeesbalance" name="grpFeeBalance[]" value="' . $feeDetail['balance_tobe_paid'] . '" readonly></td>
            </tr>';
        } elseif ($feesTable == 'extratable') {
            $extraFee = $connect->query("SELECT * FROM extra_curricular_activities_fee WHERE extra_fee_id = '" . $feeDetail['fees_id'] . "'")->fetch(PDO::FETCH_ASSOC);
            $extraAmount = $feeDetail['fee_received'] + $feeDetail['balance_tobe_paid'] + $feeDetail['scholarship'];
            $extraFeesHtml .= '<tr>
                <td>
                    <input type="hidden" name="extraFeesMasterid[]" value="' . $feeDetail['fees_master_id'] . '">
                    <input type="hidden" name="extraAmntid[]" value="' . $extraFee['extra_fee_id'] . '">
                    ' . $extraFee['extra_particulars'] . '
                </td>
                <td><input type="number" class="form-control extrafeesamnt" name="extraAmnt[]" value="' . $extraAmount . '" readonly></td>
                <td><input type="number" class="form-control extrafeesreceived" name="extraAmntReceived[]" value="' . $feeDetail['fee_received'] . '"></td>
                <td><input type="number" class="form-control extrafeesscholar" name="extraAmntScholarship[]" value="' . $feeDetail['scholarship'] . '"></td>
                <td><input type="number" class="form-control extrafeesbalance" name="extraAmntBalance[]" value="' . $feeDetail['balance_tobe_paid'] . '" readonly></td>
            </tr>';
        } elseif ($feesTable == 'amenitytable') {
            $amenityFee = $connect->query("SELECT * FROM amenity_fee WHERE amenity_fee_id = '" . $feeDetail['fees_id'] . "'")->fetch(PDO::FETCH_ASSOC);
            $amenityAmount = $feeDetail['fee_received'] + $feeDetail['balance_tobe_paid'] + $feeDetail['scholarship'];

            $amenityFeesHtml .= '<tr>
<td>
    <input type="hidden" name="amenityFeesMasterid[]" value="' . $feeDetail['fees_master_id'] . '">
    <input type="hidden" name="amenityAmntid[]" value="' . $amenityFee['amenity_fee_id'] . '">
    ' . $amenityFee['amenity_particulars'] . '
</td>
<td><input type="number" class="form-control amenityfees" name="amenityAmnt[]" value="' . $amenityAmount . '" readonly></td>
<td><input type="number" class="form-control amenityfeesreceived" name="amenityAmntReceived[]" value="' . $feeDetail['fee_received'] . '"></td>
<td><input type="number" class="form-control amenityfeesscholar" name="amenityAmntScholarship[]" value="' . $feeDetail['scholarship'] . '"></td>
<td><input type="number" class="form-control amenityfeesbalance" name="amenityAmntBalance[]" value="' . $feeDetail['balance_tobe_paid'] . '" readonly></td>
</tr>';
        }
    }

    $denomination = $connect->query("SELECT * FROM admission_fees_denomination  WHERE `admission_fees_ref_id` ='$feesid'")->fetch(PDO::FETCH_ASSOC); 
    $payment_mode = $denomination['payment_mode'];
    $response = array(
        'group' => $groupFeesHtml,
        'extra' => $extraFeesHtml,
        'amenity' => $amenityFeesHtml,
        'academic_year' => $editAdmissionFees['academic_year'],
        'receipt_no' => $editAdmissionFees['receipt_no'],
        'receipt_date' => $editAdmissionFees['receipt_date'],
        'payment_mode' => $denomination['payment_mode'],
        'scholarship' => $editAdmissionFees['scholarship'],
        'fees_collected' => $editAdmissionFees['fees_collected'],
        'denomination' => $denomination // Add entire denomination row

    );
    echo json_encode($response);
    exit;
}
