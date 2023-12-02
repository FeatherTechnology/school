<?php
include '../../ajaxconfig.php';
session_start();

if(isset($_POST['student_id'])){
	$student_id = $_POST['student_id']; 
} 
if(isset($_SESSION["academic_year"])){
   
    $academic_years = $_SESSION["academic_year"];
} 
?>
<b>Click Here</b>
<a onclick="paidtranFeesdetail()" id="button1"><button type="button" class="btn btn-primary"><span class="icon-keyboard_tab"></span>&nbsp;Transport Paid Fees Details</button></a>
<a onclick="paidFeesdetail()" id="button2" style="display:none"><button type="button" class="btn btn-primary"><span class="icon-keyboard_tab"></span>&nbsp;Paid Fees Details</button></a>
<table class="table custom-table" id="updatedSyllabusTable"> 
				<thead>
					<tr>
						<th colspan="7"><span class="icon-list"></span> Paid Details</th>
					</tr>
					<tr>
						<th width="50">S.No</th>
						<th>Receipt Date</th>
						<th>Receipt Number</th>
						<th>Receipt Number In Detail</th>
						<th>Particulars</th>
                        <th>Total Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
    <?php
    // $currentYear = date("Y");
    // $currentAcademicYear = ($currentYear) . '-' . ($currentYear + 1);
     $currentAcademicYear = $_SESSION["academic_year"];

    $ctselect = "SELECT 
    pfr.receipt_number, 
    pf.receipt_date, 
    pfr.grp_particulars, 
    pfr.extra_particulars, 
    pfr.amenity_particulars,
    pfr.extra_fees_total_received, 
    pfr.amenity_fees_total_received, 
    pfr.grp_fees_total_received,
    pfr.grp_fees_id,
    pfr.extra_fees_id, 
    pfr.amenity_fees_id, 
    pf.academic_year, 
    pfr.amenity_amount_recieved, 
    pfr.extra_amount_recieved, 
    pfr.amount_recieved
   
FROM 
    pay_fees_ref pfr
    LEFT JOIN pay_fees pf ON pf.pay_fees_id = pfr.pay_fees_id
   
WHERE  
    pfr.student_id = '$student_id' 
    AND pf.academic_year = '$currentAcademicYear' 
    AND pf.status = 0 
    AND pfr.status = 0  

ORDER BY 
     pfr.receipt_number DESC";  
    // echo "$ctselect";
// SELECT pay_fees.receipt_number, pay_fees.receipt_date, pay_fees_ref.grp_particulars, pay_fees_ref.extra_particulars, pay_fees_ref.amenity_particulars,
//     pay_fees_ref.extra_fees_total_received, pay_fees_ref.amenity_fees_total_received, pay_fees_ref.grp_fees_total_received,pay_fees_ref.grp_fees_id,
//     pay_fees_ref.extra_fees_id, pay_fees_ref.amenity_fees_id, pay_fees.academic_year, pay_fees_ref.amenity_amount_recieved, pay_fees_ref.extra_amount_recieved, pay_fees_ref.amount_recieved 
//     FROM pay_fees_ref 
//     JOIN pay_fees ON (pay_fees_ref.pay_fees_id = pay_fees.pay_fees_id) 
//     WHERE (pay_fees.student_id = '$student_id' AND pay_fees_ref.student_id = '$student_id') 
//     AND academic_year = '$currentAcademicYear' AND pay_fees.status = 0 AND pay_fees_ref.status = 0
    $ctresult = $mysqli->query($ctselect);
    if ($ctresult->num_rows > 0) {
        $j = 1;
        $l = 1;
        while ($ct = $ctresult->fetch_assoc()) {

            $s_array = explode(",", $ct['grp_particulars']);
            $s_array1 = explode(",", $ct['extra_particulars']);
            $s_array2 = explode(",", $ct['amenity_particulars']);
            $s_array3 = explode(",", $ct['grp_fees_total_received']);
            $s_array4 = explode(",", $ct['extra_fees_total_received']);
            $s_array5 = explode(",", $ct['amenity_fees_total_received']);
            $s_array6 = explode(",", $ct['grp_fees_id']);
            $s_array7 = explode(",", $ct['extra_fees_id']);
            $s_array8 = explode(",", $ct['amenity_fees_id']);
            $s_array9 = explode(",", $ct['amount_recieved']);
            $s_array10 = explode(",", $ct['extra_amount_recieved']);
            $s_array11 = explode(",", $ct['amenity_amount_recieved']);
            $receipt_date = $ct['receipt_date'];
            $receipt_number = $ct['receipt_number'];
            $academic_year = $ct['academic_year'];

            $mergedParticularsArray = array_merge($s_array, $s_array1, $s_array2);
            $mergedAmountArray = array_merge($s_array9, $s_array10, $s_array11);
            $mergedIDArray = array_merge($s_array6, $s_array7, $s_array8);

            if (end($s_array) === '') {
                array_pop($s_array); // remove last element if it's empty
            }
            // for ($k = 0; $k < count($s_array13); $k++) {
                // if ($s_array13 > 0) {
                  
                    
                // }
            // }
            // Loop through mergedAmountArray and display rows where the value is greater than 0
            for ($i = 0; $i < count($mergedAmountArray); $i++) {
                if ($mergedAmountArray[$i] > 0) {
                    ?>
                    <tr id="pay_fee_table" class="pay_fee_table">
                        <td hidden><?php echo $mergedIDArray[$i]; ?></td>
                        <td hidden><?php echo $student_id; ?></td>
                        <td><?php echo $j; ?></td>
                        <td><?php echo $receipt_date; ?></td>
                        <td><?php echo $receipt_number; ?></td>
                        <td><?php echo $receipt_number . '(' . $academic_year . ')'; ?></td>
                        <td><?php echo $mergedParticularsArray[$i];  ?></td>
                        <td><?php echo $mergedAmountArray[$i]; ?></td>
                        <td>
						<a class='printpo' onclick="printRow(this)"><span class='icon-print'></span>&nbsp;</a> &nbsp;
                            <a id="delete_subject"><span class='icon-trash-2'></span></a>
                        </td>
                    </tr>
                    <?php
                    $j = $j + 1;
                }
            }
        }

    }
    $ctselect1 = "SELECT
    ptf.receipt_number,
    ptf.receipt_date,
    ptf.grp_particulars,
    tfr.transport_received_fees_total,
    tfr.transport_fees_reff_id
   FROM pay_transport_fees ptf LEFT JOIN transport_fees_ref tfr ON tfr.student_id = ptf.student_id WHERE tfr.transport_received_fees_total NOT IN (0) AND ptf.student_id = '$student_id' AND ptf.academic_year = '$currentAcademicYear' ORDER BY transport_fees_reff_id DESC";  
                    //    id="pay_tran_fee_table";
    $ctresult1 = $mysqli->query($ctselect1);
    if ($ctresult1->num_rows > 0) {
        $k = 1;
        while ($ct1 = $ctresult1->fetch_assoc()) {
            $s_array12 =  $ct1['grp_particulars'];
            $s_array13 =  $ct1['transport_received_fees_total'];
            $s_array14 =  $ct1['transport_fees_reff_id'];
            $receipt_date = $ct1['receipt_date'];
            $receipt_number = $ct1['receipt_number'];
            // for ($k = 0; $k < count($s_array12); $k++) { ?>
            <tr id="pay_trans_fee_table" class="pay_trans_fee_table" style="display:none;">
            <td hidden><?php echo $s_array14; ?></td>
            <td hidden><?php echo $student_id; ?></td>
            <td><?php echo $l; ?></td>
            <td><?php echo $receipt_date; ?></td>
            <td><?php echo $receipt_number; ?></td>
            <td><?php echo $receipt_number . '(' . $academic_year . ')'; ?></td>
            <td><?php echo $s_array12;  ?></td>
            <td><?php echo $s_array13; ?></td>
            <td>
            <a class='printpo' onclick="printRow(this)"><span class='icon-print'></span>&nbsp;</a> &nbsp;
                <a id="delete_subject"><span class='icon-trash-2'></span></a>
            </td>
        </tr>
  <?php $l = $l + 1; }
        // }
    }
    ?>
</tbody>



</table>

<script type="text/javascript">
    $(document).ready( function () {

    // $('#updatedSyllabusTable').DataTable();
} );
$(function(){
    setTimeout(()=>{

    
  $('#updatedSyllabusTable').DataTable({
			//  dom: 'lBfrtip', 
			buttons: [
				{
					extend:  'copy',
					exportOptions: {
						columns: [ 0, 1, 2 ,3 ]
					}
				},		
				{
					extend:  'pdf',
					exportOptions: {
						columns: [ 0, 1, 2 ,3 ]
					}
				},
				{
					extend:  'excel',
					exportOptions: {
						columns: [ 0, 1, 2 ,3 ]
					}
				},
				{
					extend:  'print',
					exportOptions: {
						columns: [ 0, 1, 2 ,3 ]
					}
				},
				{		 
					extend:'colvis',
					collectionLayout: 'fixed four-column',
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
  });
},1500);
});

function paidtranFeesdetail(){
  
  $('#button1').css("display", "none");
  $('#button2').css("display", "");
  $('.pay_trans_fee_table').each(function() {
    
    $(this).css("display", "");
   });
   $('.pay_fee_table').each(function() {
    
    $(this).css("display", "none");
   });
}
function paidFeesdetail(){
  
  $('#button1').css("display", "");
  $('#button2').css("display", "none");
  $('.pay_trans_fee_table').each(function() {
    
    $(this).css("display", "none");
   });
   $('.pay_fee_table').each(function() {
    
    $(this).css("display", "");
   });
}
</script>