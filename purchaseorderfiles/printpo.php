<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["ponum"])){
	$ponum=$_POST["ponum"];
}

// if(isset($_POST["shipto"])){
// 	$shipto=$_POST["shipto"]; 
// }
$getpo=$con->query("SELECT * FROM purchaseorder WHERE ponumber='".strip_tags($ponum)."' ");
while($row=$getpo->fetch_assoc()){
	$vendor=$row["vendor"];
	$shipto=$row["shipto"];
	$purchasedate=$row["purchasedate"];
	$vendoraddress1=$row["vendoraddress"];
	$vendoraddress=explode(',', $vendoraddress1);
	$shippingaddress1=$row["shippingaddress"];
	$shippingaddress=explode(',', $shippingaddress1);
	$ponumber=$row["ponumber"];
	$requisitioner=$row["requisitioner"];
	$shipvia=$row["shipvia"];
	$fob=$row["fob"];
	$shippingterms=$row["shippingterms"];

	$partcode1=$row["partcode"];
	$partcode=explode(',', $partcode1);

	$description1=$row["description"];
	$description=explode(',', $description1);

	$hsncode1=$row["hsncode"];
	$hsncode=explode(',', $hsncode1);

	$quantity1=$row["quantity"];
	$quantity=explode(',', $quantity1);

	$unitprice1=$row["unitprice"];
	$unitprice=explode(',', $unitprice1);

	$tax1=$row["tax"];
	$tax=explode(',', $tax1);


	$total=$row["total"];
	$total=explode(',', $total);

	$subtotal=$row["subtotal"];
	$taxamount=$row["taxamount"];
	$taxrate=round(($taxamount/$subtotal)*100);
	$shippingcharges=$row["shippingcharges"];
	$handlingcharges=$row["handlingcharges"];
	$othercharges=$row["othercharges"];
	$totalpo=$row["totalpo"];
	$othercomments=$row["othercomments"];

	if($shippingcharges==''){
		$shippingcharges = 0;
	}
	if($handlingcharges==''){
		$handlingcharges = 0;
	}
	if($othercharges==''){
		$othercharges = 0;
	}
	if($taxamount==''){
		$taxamount = 0;
	}
}

$getmailid=$con->query("SELECT mailid FROM vendor WHERE vendorid='".$vendor."' ");
while ($data=$getmailid->fetch_assoc()){
	$vendormail=$data["mailid"];
}


$getbrc=$con->query("SELECT * FROM temple_creation");
while ($brc=$getbrc->fetch_assoc()) {
	$address1  =$brc["address1"];
	$address2  =$brc["address2"];
	$city  =$brc["city"];
	$state     =$brc["state"];
	$email_id     =$brc["email_id"];
	$temple_name     =$brc["temple_name"];
}
?>

<head>
<style type="text/css">
	th{
		text-align: center;
		font-weight: bold;
	}
</style>
</head>

<input type="hidden" name="ponum" id="ponum" value="<?php echo $ponumber; ?>">

<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;width: 75%;margin: auto;">

<table style="width: 70%;margin: auto;">
	<tr>
		<!-- <td><img src="img/logo.png" height="50px" width="150px" align="right"></td> -->
		<td><h1><?php echo $temple_name; ?></h1></td>
		<td style="text-align: left;padding-top:10%;">
			<?php echo $address1; ?><br>
			<?php echo $address2; ?><br>
			<?php echo $city; ?><br>
			<?php echo $state; ?><br>
			<?php echo $email_id; ?>
		</td>
	</tr>
</table>
<br /><br />
<table rules="all" style="width: 70%;border-style: double;border: 1px solid black;margin: auto;">
	<tr>
		<th style="background-color: white;color: black">Shipping Address</th>
		<th style="background-color: white;color: black">Vendor Address</th>
		<th style="background-color: white;color: black">Other Detail</th>
	</tr>
	<tr>
		<td style="margin-left: 5px;padding-left: 30px;text-align: left;">
			<?php 
			if(isset($shippingaddress)){
				foreach ($shippingaddress as  $Sadd) {
					echo $Sadd."<br>";
				}
			}
			?>
		</td>
		<td style="margin-left: 5px;padding: 30px;text-align: left;">
			<?php 
			if(isset($vendoraddress)){
				foreach ($vendoraddress as  $Vadd) {
					echo $Vadd."<br>";
				}
			}
			?>
		</td>
		<td><table>
			<tr>
				<td style="text-align: left"><b>Date:</b></td>
				<td style="text-align: left"><?php echo $purchasedate; ?></td>
			</tr>
			<tr>
				<td style="text-align: left"><b>Po Number:</b></td>
				<td style="text-align: left"><?php echo $ponumber; ?></td>
			</tr>
			</table></td>
	</tr>
</table>
<br /><br />
<table rules="all" style="width: 70%;border-style: double;border: 1px solid black;margin: auto;">
	<tr>
		<th style="background-color: white;color: black">Requisitioner</th>
		<th style="background-color: white;color: black">FOB</th>
		<th style="background-color: white;color: black">Ship Via</th>
		<th style="background-color: white;color: black">Shipping Terms</th>
	</tr>
	<tr>
		<td style="text-align: center"><?php echo $requisitioner; ?></td>
		<td style="text-align: center"><?php echo $fob; ?></td>
		<td style="text-align: center"><?php echo $shipvia; ?></td>
		<td style="text-align: center"><?php echo $shippingterms; ?></td>
	</tr>
</table>
<br /><br />
<table rules="all" style="width: 70%;border-style: double;border: 1px solid black;margin: auto;">
	<tr>
		<th style="background-color: white;color: black">Part No</th>
		<th style="background-color: white;color: black">Description</th>
		<th style="background-color: white;color: black">Quantity</th>
		<th style="background-color: white;color: black">Unit Price</th>
		<th style="background-color: white;color: black">Total</th>
	</tr>
	<?php for($i=0;$i<=sizeof($partcode)-1;$i++){?>
	<tr>
		<td style="text-align: center"><?php echo $partcode[$i]; ?></td>
		<td style="text-align: center"><?php echo $description[$i]; ?></td>
		<td style="text-align: center"><?php echo $quantity[$i]; ?></td>
		<td style="text-align: center"><?php echo $unitprice[$i]; ?></td>
		<td style="text-align: center"><?php echo $total[$i]; ?></td>
	</tr>
<?php } ?>
</table>
<br /><br />


<table style="border: 1px solid black;width:35%;float: left;margin-left: 15%;margin-right: 5%;">
    <tr>
	<th style="background-color: white;color: black">Other Comments or Special Instructions</th>
	</tr>
	<tr>
	<td style="margin-left: 5px;padding-left: 30px;text-align: left;height: 100px;"><?php echo $othercomments; ?></td>
	</tr>
  </table>

<table rules="all" style="border: 1px solid black;width:30%;margin-left: 55%;">
            <tr>
				<td style="text-align: left;padding-left: 30px;"><b>SUBTOTAL</b></td>
				<td><?php echo $subtotal; ?></td>
			</tr>
			<tr>
				<td style="text-align: left;padding-left: 30px;"><b>TAX RATE %</b></td>
				<td><?php echo $taxrate."%"; ?></td>
			</tr>
			<tr>
				<td style="text-align: left;padding-left: 30px;"><b>TAX</b></td>
				<td><?php echo $taxamount; ?></td>
			</tr>
			<tr>
				<td style="text-align: left;padding-left: 30px;"><b>S&H</b></td>
				<td><?php echo $shippingcharges + $handlingcharges; ?></td>
			</tr>
			<tr>
				<td style="text-align: left;padding-left: 30px;"><b>OTHER</b></td>
				<td><?php echo $othercharges; ?></td>
			</tr>
			<tr>
				<td style="text-align: left;padding-left: 30px;"><b>TOTAL</b></td>
				<td><?php echo $totalpo; ?></td>
			</tr> 
</table>
<br/><br /><br /><br/><br />
<div style="border-top: 1px solid black;margin-left: 10%;margin-right: 10%">
<br/>
<b><p style="float: left;">Authorized by</p></b>
<b><p align="right"><?php echo date("d/m/Y"); ?></p></b>
</div>
</div>
				
<button type="button" name="printpurchase" onclick="poprint()" id="printpurchase" class="btn btn-primary">Print</button>

<script type="text/javascript">
  function poprint(){
  var Bill = document.getElementById("dettable").innerHTML;
  var printWindow = window.open('', '', 'height=400,width=800');
     printWindow.document.write(Bill);
     printWindow.document.close();
     printWindow.print();
     printWindow.close();
 }
 document.getElementById("printpurchase").click()
</script>