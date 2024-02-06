<?php
include '../ajaxconfig.php';
if(isset($_POST["ponum"])){
	$ponum = $_POST["ponum"];
}

// $getitemavlqry=$mysqli->query("SELECT vendor, shipto, partcode, quantity, unitprice FROM purchaseorder WHERE ponumber = '".$ponum."' ");
// while($row=$getitemavlqry->fetch_assoc()){
// 	$vendor       = $row["vendor"];
// 	$shipto       = $row["shipto"];
// 	$epartcode1   = $row["partcode"];
// 	$equantity1   = $row["quantity"];
// 	$eunitprice1  = $row["unitprice"];
// }
// $epartcode = explode(',', $epartcode1);
// $equantity = explode(',', $equantity1);
// $eunitprice = explode(',', $eunitprice1);


// if($shipto[0] == 'g'){
// 	$Sshipto = ltrim($shipto, 'g');
// 	$isvendor = $mysqli->query("SELECT godownrefid FROM godownref WHERE vendorselect = '".$vendor."' ");
// 	if($isvendor->num_rows>0){
// 		for($i=0; $i<=sizeof($equantity)-1; $i++){
// 		$updateqry=$mysqli->query("UPDATE godownref SET openingstock = openingstock + '".$equantity[$i]."', purchaseprice = '".$eunitprice[$i]."' WHERE vendorselect = '".$vendor."' AND godownid = '".$Sshipto."' ");
// 	}
// 	}else{
// 		for($i=0; $i<=sizeof($equantity)-1; $i++){
// 			$insertqry = $mysqli->query("INSERT INTO godownref(openingstock, purchaseprice, vendorselect, godownid) VALUES('".$equantity[$i]."', '".$eunitprice[$i]."', '".$vendor."', '".$Sshipto."') ");
// 		}
// 	}
// }


// else if($shipto[0] == 'b'){
// 	$Sshipto = ltrim($shipto, 'b');
// 	for($i=0; $i<=sizeof($equantity)-1; $i++){
// 		$getTable = $mysqli->query("SELECT * FROM account1 WHERE partnumber = '".$epartcode[$i]."' ");
// 		if($getTable->num_rows>0){
// 		$updateqry=$mysqli->query("UPDATE account1ref SET openingstock = openingstock + '".$equantity[$i]."', purchasestock =  '".$equantity[$i]."', purchaseprice = '".$eunitprice[$i]."' WHERE partnumber = '".$epartcode[$i]."'  AND branchid = '".$Sshipto."' ");

// 		$updateqry1=$mysqli->query("UPDATE account1 SET noofgmpcs = noofgmpcs + '".$equantity[$i]."'  WHERE partnumber = '".$epartcode[$i]."' AND branchid = '".$Sshipto."' ");
// 		}
// 		else
// 		{
// 		$updateqry=$mysqli->query("UPDATE account2ref SET openingstock = openingstock + '".$equantity[$i]."', purchasestock = '".$equantity[$i]."', purchaseprice = '".$eunitprice[$i]."' WHERE partnumber = '".$epartcode[$i]."'  AND branchid = '".$Sshipto."' ");

// 		$updateqry1=$mysqli->query("UPDATE account2 SET noofgmpcs = noofgmpcs + '".$equantity[$i]."'  WHERE partnumber = '".$epartcode[$i]."' AND branchid = '".$Sshipto."' ");
// 		}
// 	}
// }

$approveqry=$mysqli->query("UPDATE purchaseorder SET  approvedstatus = 1 WHERE ponumber = '".$ponum."' ") OR die("Error");
if($approveqry){
	$message="updated";
}
else{
	$message = "error";
}
echo json_encode($message);
?>