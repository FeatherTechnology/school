<?php
@session_start();
include 'ajaxconfig.php';

$Id =0;

 if(isset($_POST['model'])){
    $model=$_POST['model']; 
}
$qry="SELECT * FROM billsettings where 1";


$result=$con->query($qry);

while( $row = $result->fetch_assoc()){
     $Id              = $row['id'];
	 
     if($Id >0)
	 {
		$updateconfigsetting="UPDATE billsettings SET billmodel = '".strip_tags($model)."'  WHERE id = '".strip_tags($Id)."' "; 
		$updateconfigsettinge=$con->query($updateconfigsetting) or die("Error :".$con->error);
        $configsettingupdate="Configuration Billing Setting Has been Updated!"; 
        echo json_encode($configsettingupdate);
	
	 }
	
}
 if($Id ==0)
 {
	     $insert=$con->query("INSERT INTO billsettings(billmodel) VALUES('".strip_tags($model)."')");
	    if($insert == true){
		$message="Configuration Billing Setting Has been Inserted!";
		echo json_encode($message);
	
	 }
     
   }

?>