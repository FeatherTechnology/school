<?php
error_reporting(0);
@session_start();
require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');
include("../ajaxconfig.php");

if(isset($_FILES["file"]["type"])){
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
if(in_array($_FILES["file"]["type"],$allowedFileType)){
	    $targetPath = '../uploads/bulkimport/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
        	$Reader->ChangeSheet($i);
        	foreach ($Reader as $Row){
				
			
            $reference = "";
            if(isset($Row[0])) {
            $reference = mysqli_real_escape_string($con,$Row[0]);
            }
            $depth = "";
            if(isset($Row[1])) {
            $depth = mysqli_real_escape_string($con,$Row[1]);
            }
            $screen_name = "";
            if(isset($Row[2])) {
            $screen_name = mysqli_real_escape_string($con,$Row[2]);
            }
            $new_product_ref_id = "";
            if(isset($Row[3])) {
            $new_product_ref_id = mysqli_real_escape_string($con,$Row[3]);
            }

			// $product_name = "";
            // if(isset($Row[3])) {
            // $product_name = mysqli_real_escape_string($con,$Row[3]);
			// $getproduct             = $con->query("SELECT product_id,product_name FROM product WHERE product_name='".$product_name."' ");
			// while($row13=$getproduct->fetch_assoc()){
			// $product_name                   = $row13["product_name"];		
			// }
            // }

            // $module_name = "";
            // if(isset($Row[3])) {
            // $module_name = mysqli_real_escape_string($con,$Row[3]);
			// $getmodule             = $con->query("SELECT module_id,module_name FROM module WHERE module_name='".$module_name."' ");
			// while($row13=$getmodule->fetch_assoc()){
			// $module_name                   = $row13["module_name"];		
			// }
            // }
			
			

        if($i==0 && $product_name!="Product Name" && $module_name !="Module Name" && $product_name!="" && $module_name !="" && $screen_name !="" && $reference !="" && $depth !="")
		{ 
        $query = "INSERT INTO product_ref(product_id,new_product_id,product_name$product_name,screen_name$screen_name,reference$reference,depth$depth) VALUES (
	    '".strip_tags($product_name)."','".strip_tags($module_name)."','".strip_tags($screen_name)."',
	   '".strip_tags($reference)."','".strip_tags($depth)."')";

       $result = $con->query($query) or die("Error ".$con->error);

    } } }  

    if(!empty($result)) {
    $message = 0;
    }
    else{
    $message = 1;
    }
}
    }else{
        $message = 1;
    }
echo json_encode($message);
?>