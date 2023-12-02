<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 

$id=0;
 if(isset($_POST['submitschool_creation']) && $_POST['submitschool_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateSchoolCreationmaster = $userObj->updateSchoolCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_school_creation&msc=2';</script> 
    <?php	}
    else{   
		$addSchoolCreation = $userObj->addSchoolCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_school_creation&msc=1';</script>
        <?php
    }
 }   

$del=0;
if(isset($_GET['del']))
{
$del=$_GET['del'];
}
if($del>0)
{
	$deleteSchoolCreation = $userObj->deleteSchoolCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_school_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getSchoolCreation = $userObj->getSchoolCreation($mysqli,$idupd); 
	
	if (sizeof($getSchoolCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getSchoolCreation);$ibranch++)  {	
            $school_id                      = $getSchoolCreation['school_id'];
			$school_name                	 = $getSchoolCreation['school_name'];
			$school_login_name          		     = $getSchoolCreation['school_login_name'];
			$contact_number      			     = $getSchoolCreation['contact_number'];
			$address1		         = $getSchoolCreation['address1'];
			$address2    			         = $getSchoolCreation['address2'];
            $district                   = $getSchoolCreation['district'];
			$state       		     = $getSchoolCreation['state'];
			$email_id     			     = $getSchoolCreation['email_id'];
		}
	}
}
?>
<style>
   .select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
.dataTables_length {
        display: none;
    }

    .dataTables_filter input {
    border: 1px solid #e4e4e4;
    padding: 7px;
}
</style>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM -Student RollBack Form </li>
    </ol>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "school_creation" name="school_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($school_id)) echo $school_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
        <div class="card-body">

             <div class="row ">
                <!--Fields -->
               <div class="col-md-12"> 
                  <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Standard List</label>
                                        <select class="form-control select2" id="standard" name="standard">
                                            <option value="">Select a Standard...</option>
                                            <option value="PRE.K.G" <?php  if(isset($temp_standard)) { if($temp_standard == "PRE.K.G") echo 'selected'; }?>>PRE.K.G</option>
                                            <option value="L.K.G"<?php  if(isset($temp_standard)) { if($temp_standard == "L.K.G") echo 'selected'; }?>>L.K.G</option>
                                            <option value="U.K.G" <?php  if(isset($temp_standard)) { if($temp_standard == "U.K.G") echo 'selected'; }?>>U.K.G</option>
                                            <option value="I" <?php  if(isset($temp_standard)) { if($temp_standard == "I") echo 'selected'; }?>>I</option>
                                            <option value="II" <?php  if(isset($temp_standard)) { if($temp_standard == "II") echo 'selected'; }?>>II</option>
                                            <option value="III" <?php  if(isset($temp_standard)) { if($temp_standard == "III") echo 'selected'; }?>>III</option>
                                            <option value="IV" <?php  if(isset($temp_standard)) { if($temp_standard == "IV") echo 'selected'; }?>>IV</option>
                                            <option value="V" <?php  if(isset($temp_standard)) { if($temp_standard == "V") echo 'selected'; }?>>V</option>
                                            <option value="VI" <?php  if(isset($temp_standard)) { if($temp_standard == "VI") echo 'selected'; }?>>VI</option>
                                            <option value="VI" <?php  if(isset($temp_standard)) { if($temp_standard == "VI") echo 'selected'; }?>>VII</option>
                                            <option value="VIII" <?php  if(isset($temp_standard)) { if($temp_standard == "VIII") echo 'selected'; }?>>VIII</option>
                                            <option value="IX" <?php  if(isset($temp_standard)) { if($temp_standard == "IX") echo 'selected'; }?>>IX</option>
                                            <option value="X" <?php  if(isset($temp_standard)) { if($temp_standard == "X") echo 'selected'; }?>>X</option>
                                            <option value="XI_Maths_Biology" <?php  if(isset($temp_standard)) { if($temp_standard == "XI_Maths_Biology") echo 'selected'; }?>>XI_Maths_Biology</option>
                                            <option value="XI_Maths_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XI_Maths_ComputerScience") echo 'selected'; }?>>XI_Maths_ComputerScience</option>
                                            <option value="XI_Biology_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XI_Biology_ComputerScience") echo 'selected'; }?>>XI_Biology_ComputerScience</option>
                                            <option value="XII_Maths_Biology" <?php  if(isset($temp_standard)) { if($temp_standard == "XII_Maths_Biology") echo 'selected'; }?>>XII_Maths_Biology</option>
                                            <option value="XII_Maths_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XII_Maths_ComputerScience") echo 'selected'; }?>>XII_Maths_ComputerScience</option>
                                            <option value="XII_Biology_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XII_Biology_ComputerScience") echo 'selected'; }?>>XII_Biology_ComputerScience</option>
                                            <option value="XI_All" <?php  if(isset($temp_standard)) { if($temp_standard == "XI_All") echo 'selected'; }?>>XI_All</option>
                                            <option value="XII_All" <?php  if(isset($temp_standard)) { if($temp_standard == "XII_All") echo 'selected'; }?>>XII_All</option>
                                            <option value="XI_Commerce_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XI_Commerce_ComputerScience") echo 'selected'; }?>>XI_Commerce_ComputerScience</option>
                                            <option value="XII_Commerce_ComputerScience" <?php  if(isset($temp_standard)) { if($temp_standard == "XII_Commerce_ComputerScience") echo 'selected'; }?>>XII_Commerce_ComputerScience</option>
                                        
                                    </select>
                                </div>
                            </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select class="form-control select2" id="section" name="section">
                                    <option>Select Section</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                            <table id="student_rollback_info" class="table custom-table">
                                <thead>
                                    <tr>
                                    <th>Pass / Fail<br><br><input type="checkbox" id="select-all"></th>
                                    <th>Admission No</th>
                                    <th>Name</th>
                                    <th>Standard Name</th>
                                    <th>Section Name</th>
                                    <th>Pass / Fail</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                                <!-- Second Table for Unselected Data -->
                                <table id="unselected_table" class="table custom-table" style="display:none">
                                    <thead>
                                        <tr>
                                        <th>Admission No</th>
                                        <th>Name</th>
                                        <th>Standard Name</th>
                                        <th>Section Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Unselected data rows will be dynamically populated -->
                                    </tbody>
                                </table>
                            </div>  

                            <div class="col-md-12">
                            
                            <div class="text-center">
                                <button type="button" name="submitFailList" id="submitFailList" class="btn btn-danger" value="Submit" tabindex="9">Fail List Show</button>
                                <button type="submit" name="submitschool_creation" id="submitschool_creation" class="btn btn-success" value="Submit" tabindex="9">Submit</button>

                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

