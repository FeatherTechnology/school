<?php
include "../../ajaxconfig.php";
@session_start();
if(isset($_SESSION['school_id'])){
    $school_id = $_SESSION['school_id'];
}

if(isset($_POST['feesFromDate'])){
    $feesFromDate = new DateTime($_POST['feesFromDate']);
    $startdate = clone $feesFromDate;
}
if(isset($_POST['feesToDate'])){
    $feesToDate = new DateTime($_POST['feesToDate']);
    $to_date = $feesToDate->format('Y-m-d');
}
?>

<table class="table table-bordered" id="show_monthwise_fees_summary"  style="text-align: left;">
    <thead>
        <tr><th colspan='13' class="report-title">Fees Summary Report From <?php echo $feesFromDate->format('M-Y'); ?>  To  <?php echo $feesToDate->format('M-Y'); ?> </th></tr>
        <tr>
        <th>S.No</th>
            <th>Date</th>
            <th>Admission Fee</th>
            <th>Uniform Fee</th>
            <th>Book Fee</th>
            <th>School Fee</th>
            <th>Transport Fee</th>
            <th>Last year Fee</th>
            <th>ECA Fee</th>
            <th>Bank</th>
            <th>Cash</th>
            <th>Scholarship</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $i=1;
    $admissionfee_total = 0;
        $schoolfee_total = 0;
        $bookfee_total = 0;
        $eca_total = 0;
        $scholar_total = 0;
        $uniformfee_total = 0;
        $transportfee_total = 0;
        $lastyear_total = 0;
        $bank_total = 0;
        $cash_total = 0;
        $total = 0;
    while($startdate <= $feesToDate){
    $from_date = $startdate->format('Y-m-d');

    //School fee
    $getCollectedFeesQry = $connect->query("SELECT COALESCE(SUM(afd.fee_received),0) AS collectedFees ,afd_deno.payment_mode FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id  JOIN 
                admission_fees_denomination afd_deno ON af.id = afd_deno.admission_fees_ref_id  WHERE (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') )  AND afd.fees_table_name ='grptable' AND af.school_id = '$school_id'   GROUP BY 
         afd_deno.payment_mode ");
     $schoolFeeSplit = [];
     $collected_fees =0;
     while ($row = $getCollectedFeesQry->fetch(PDO::FETCH_ASSOC)) {
         $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
         $schoolFeeSplit[$mode] = $row['collectedFees'];
         $collected_fees +=  $row['collectedFees'];
     }
    
    //Book feee
    $getBookFeesQry = $connect->query("SELECT afd_deno.payment_mode, COALESCE(SUM(afd.fee_received),0) AS bookFees FROM `admission_fees` af JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id  JOIN 
                admission_fees_denomination afd_deno ON af.id = afd_deno.admission_fees_ref_id WHERE (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') ) AND afd.fees_table_name ='amenitytable' AND af.school_id = '$school_id' GROUP BY 
        afd_deno.payment_mode ");
   $book_fees =0;
   $bookFeeSplit = [];
   while ($row = $getBookFeesQry->fetch(PDO::FETCH_ASSOC)) {
       $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
       $bookFeeSplit[$mode] = $row['bookFees'];
       $book_fees +=  $row['bookFees'];
   }
    // uniform fee
    $getUniformFeesQry = $connect->query("
    SELECT afd_deno.payment_mode, COALESCE(SUM(afd.fee_received),0) AS uniform_fees 
    FROM admission_fees af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
     JOIN admission_fees_denomination afd_deno ON af.id = afd_deno.admission_fees_ref_id 
    JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id  
    WHERE  (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') )
    AND afd.fees_table_name = 'extratable' 
    AND ecaf.extra_particulars LIKE '%Uniform%' 
    AND af.school_id = '$school_id' GROUP BY 
        afd_deno.payment_mode
");
 
            $uniformFeeSplit = [];
            $uniform_fees =0;
            while ($row = $getUniformFeesQry->fetch(PDO::FETCH_ASSOC)) {
                $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
                $uniformFeeSplit[$mode] = $row['uniform_fees'];
                $uniform_fees +=  $row['uniform_fees'];
            }
            // admission fee
            $getAdmissionFeesQry = $connect->query("
SELECT afd_deno.payment_mode, COALESCE(SUM(afd.fee_received),0) AS admission_fees 
FROM admission_fees af 
JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
 JOIN admission_fees_denomination afd_deno ON af.id = afd_deno.admission_fees_ref_id 
JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id  
WHERE  (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') )
AND afd.fees_table_name = 'extratable' 
AND ecaf.extra_particulars LIKE '%Admission%' 
AND af.school_id = '$school_id' GROUP BY 
        afd_deno.payment_mode
");
$admission_fees =0;
            $admissionFeeSplit = [];
            while ($row = $getAdmissionFeesQry->fetch(PDO::FETCH_ASSOC)) {
                $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
                $admissionFeeSplit[$mode] = $row['admission_fees'];
                $admission_fees +=  $row['admission_fees'];
            }
            // eca fee
            $getEcaFeesQry = $connect->query(" 
    SELECT afd_deno.payment_mode, COALESCE(SUM(afd.fee_received),0) AS eca_fees 
    FROM admission_fees af 
    JOIN admission_fees_details afd ON af.id = afd.admission_fees_ref_id 
     JOIN admission_fees_denomination afd_deno ON af.id = afd_deno.admission_fees_ref_id 
    JOIN extra_curricular_activities_fee ecaf ON afd.fees_id = ecaf.extra_fee_id  
    WHERE (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') )
    AND afd.fees_table_name = 'extratable' 
    AND ecaf.extra_particulars LIKE '%ECA %' 
    AND af.school_id = '$school_id' GROUP BY 
        afd_deno.payment_mode
");
$eca_fees =0;
            
            $ecaFeeSplit = [];
            while ($row = $getEcaFeesQry->fetch(PDO::FETCH_ASSOC)) {
                $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
                $ecaFeeSplit[$mode] = $row['eca_fees'];
                $eca_fees +=  $row['eca_fees'];
            }

    // Transport Fee
            $getTransportFeesQry = $connect->query("SELECT tafd_deno.payment_mode, COALESCE(SUM(tafd.fee_received),0) AS transportFees FROM `transport_admission_fees` taf JOIN transport_admission_fees_details tafd ON taf.id = tafd.admission_fees_ref_id   JOIN 
            transport_admission_fees_denomination tafd_deno ON taf.id = tafd_deno.admission_fees_ref_id  WHERE (MONTH(taf.receipt_date) = MONTH('$from_date') AND YEAR(taf.receipt_date) = YEAR('$from_date') ) AND taf.school_id = '$school_id' GROUP BY 
            tafd_deno.payment_mode ");
                  $transportFees =0;
                
                $transportFeeSplit = [];
                while ($row = $getTransportFeesQry->fetch(PDO::FETCH_ASSOC)) {
                    $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
                    $transportFeeSplit[$mode] = $row['transportFees'];
                    $transportFees +=$row['transportFees'];
                }
    
                //Last Year Fee
                $getLastyearFeesQry = $connect->query("SELECT  lyfd_deno.payment_mode, COALESCE(SUM(lyfd.fee_received),0) AS lastyearFees FROM `last_year_fees` lyf JOIN last_year_fees_details lyfd ON lyf.id = lyfd.admission_fees_ref_id JOIN 
            last_year_fees_denomination lyfd_deno ON lyf.id = lyfd_deno.admission_fees_ref_id  WHERE (MONTH(lyf.receipt_date) = MONTH('$from_date') AND YEAR(lyf.receipt_date) = YEAR('$from_date') ) AND lyf.school_id = '$school_id' GROUP BY lyfd_deno.payment_mode");            
                $lastYearFeeSplit = [];
                $lastyearFees = 0;
                while ($row = $getLastyearFeesQry->fetch(PDO::FETCH_ASSOC)) {
                    $mode = $row['payment_mode'] == 'cash_payment' ? 'cash' : 'bank';
                    $lastYearFeeSplit[$mode] = $row['lastyearFees'];
                    $lastyearFees += $row['lastyearFees'];
                }
                /// scholorship 
                 $getScholarshipTotalQry = $connect->query("
    SELECT 
        (
            -- Total from fees_concession table
            COALESCE((
                SELECT SUM(scholarship_amount)
                FROM fees_concession
                  WHERE (MONTH(created_date) = MONTH('$from_date') AND YEAR(created_date) = YEAR('$from_date') )
            ), 0)
            +
            -- Total from admission_fees_details table
            COALESCE((
                SELECT SUM(afd.scholarship)
                FROM admission_fees_details afd
                JOIN admission_fees af 
                    ON afd.admission_fees_ref_id = af.id
                WHERE (MONTH(af.receipt_date) = MONTH('$from_date') AND YEAR(af.receipt_date) = YEAR('$from_date') )
            ), 0)
            +
            -- Total from transport_admission_fees_details table
            COALESCE((
                SELECT SUM(tafd.scholarship)
                FROM transport_admission_fees_details tafd
                JOIN transport_admission_fees taf 
                    ON tafd.admission_fees_ref_id = taf.id
               WHERE (MONTH(taf.receipt_date) = MONTH('$from_date') AND YEAR(taf.receipt_date) = YEAR('$from_date') )
            ), 0)  +
              -- Total from last year table
            COALESCE((
            SELECT SUM(lfd.scholarship)
            FROM last_year_fees lf
            JOIN last_year_fees_details lfd ON lfd.admission_fees_ref_id = lf.id
            JOIN student_creation s ON lf.admission_id = s.student_id
            WHERE (MONTH(lf.receipt_date) = MONTH('$from_date') AND YEAR(lf.receipt_date) = YEAR('$from_date') )
        ), 0)
        ) AS totalScholarship
        ");

            $totalScholarship = 0;
            if ($row = $getScholarshipTotalQry->fetch()) {
                $totalScholarship = $row['totalScholarship'];
            }
                ?>
    <tr>
        <td><?php echo $i++;?></td>
        <td><?php echo $startdate->format('M-Y');?></td>
        <td><?php echo $admission_fees; ?></td>
                <td><?php echo $uniform_fees; ?></td>
                <td><?php echo $book_fees; ?></td>
                <td><?php echo $collected_fees; ?></td>
                <td><?php echo $transportFees; ?></td>
                <td><?php echo $lastyearFees; ?></td>
                <td><?php echo $eca_fees; ?></td>
                <td>
                    <?php
                    $bankTotal = (isset($admissionFeeSplit['bank']) ? $admissionFeeSplit['bank'] : 0) +
                        (isset($uniformFeeSplit['bank']) ? $uniformFeeSplit['bank'] : 0) +
                        (isset($bookFeeSplit['bank']) ? $bookFeeSplit['bank'] : 0) +
                        (isset($schoolFeeSplit['bank']) ? $schoolFeeSplit['bank'] : 0) +
                        (isset($transportFeeSplit['bank']) ? $transportFeeSplit['bank'] : 0) +
                        (isset($lastYearFeeSplit['bank']) ? $lastYearFeeSplit['bank'] : 0) +
                        (isset($ecaFeeSplit['bank']) ? $ecaFeeSplit['bank'] : 0);
                    echo $bankTotal;
                    ?>
                </td>
                <td>
                    <?php
                    $cashTotal = (isset($admissionFeeSplit['cash']) ? $admissionFeeSplit['cash'] : 0) +
                        (isset($uniformFeeSplit['cash']) ? $uniformFeeSplit['cash'] : 0) +
                        (isset($bookFeeSplit['cash']) ? $bookFeeSplit['cash'] : 0) +
                        (isset($schoolFeeSplit['cash']) ? $schoolFeeSplit['cash'] : 0) +
                        (isset($transportFeeSplit['cash']) ? $transportFeeSplit['cash'] : 0) +
                        (isset($lastYearFeeSplit['cash']) ? $lastYearFeeSplit['cash'] : 0) +
                        (isset($ecaFeeSplit['cash']) ? $ecaFeeSplit['cash'] : 0);
                    echo $cashTotal;
                    ?>
                </td>
                  <td><?php echo $totalScholarship; ?></td>
                <td>
                    <?php
                    $totalAmnt = $admission_fees +
                    $uniform_fees +
                    $book_fees +
                        $collected_fees +
                        $transportFees +
                        $lastyearFees ;
                    echo $totalAmnt;
                    ?>
                </td>
    </tr>

    <?php 
   $admissionfee_total += $admission_fees;
   $uniformfee_total += $uniform_fees;
   $bookfee_total += $book_fees;
   $schoolfee_total += $collected_fees;
   $transportfee_total += $transportFees;
   $lastyear_total += $lastyearFees;
   $eca_total += $eca_fees;
   $scholar_total += $totalScholarship;
   $bank_total += $bankTotal;
   $cash_total += $cashTotal;
   $total += $totalAmnt;
$startdate->modify('+1 month');
} ?>
    <tr style="font-weight: bold;">
        <td><?php echo $i;?></td>
        <td>Grand Total</td>
        <td><?php echo $admissionfee_total; ?></td>
            <td><?php echo $uniformfee_total; ?></td>
            <td><?php echo $bookfee_total; ?></td>
            <td><?php echo $schoolfee_total; ?></td>
            <td><?php echo $transportfee_total; ?></td>
            <td><?php echo $lastyear_total; ?></td>
            <td><?php echo $eca_total; ?></td>
            <td><?php echo $bank_total; ?></td>
            <td><?php echo $cash_total; ?></td>
             <td><?php echo $scholar_total; ?></td>
            <td><?php echo $total; ?></td>
    </tr>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#show_monthwise_fees_summary').DataTable({
            order: [[0, "asc"]],
            // columnDefs: [
            //     { type: 'natural', targets: 0 }
            // ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            paging: false, // Disable paging
        });
    });
</script>