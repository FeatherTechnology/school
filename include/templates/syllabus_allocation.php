<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$SubjectList = $userObj->getSubjectDetails($mysqli);
$id=0;
 if(isset($_POST['submitsubject_creation']) && $_POST['submitsubject_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateSubjectDetailsmaster = $userObj->updateSubjectDetails($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>syllabus_allocation&msc=2';</script> 
    <?php	}
    else{   
		$addSubjectDetails = $userObj->addSubjectDetails($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>syllabus_allocation&msc=1';</script>
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
	$deleteSubjectDetails = $userObj->deleteSubjectDetails($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>syllabus_allocation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getSubjectDetails = $userObj->getSubjectDetails($mysqli,$idupd); 
	
	if (sizeof($getSubjectDetails)>0) {
        for($ibranch=0;$ibranch<sizeof($getSubjectDetails);$ibranch++)  {	
            $subject_id                       = $getSubjectDetails['subject_id '];
			$paper_name                	 = $getSubjectDetails['paper_name'];
			$max_mark          		     = $getSubjectDetails['max_mark'];
			$calss_id      			     = $getSubjectDetails['calss_id'];            
		}
	}
}
?>
<style>
.dataTables_length {
        display: none;
    }
    .dataTables_filter {
        display: none;
    }
    .dataTables_info {
        display: none;
    }
    .dataTables_paginate {
        display: none;
    }
    div.dt-buttons {
    position: relative;
    float: right;
}
</style>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Syllabus Master </li>
    </ol>

    <a href="edit_school_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
	
<!--------form start-->
<form id = "school_creation" name="school_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($subject_id )) echo $subject_id ; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                    	 <div class="row ">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                              <div class="row">
                              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Select</label>
                                        <select class="form-control select2" id="class_id" name="class_id">
                                            <option>Select</option> 
                                            <option value="2" <?php  if(isset($class_id)) { if($class_id == "2") echo 'selected'; }?>>L.K.G</option> 
                                            <option value="3" <?php  if(isset($class_id)) { if($class_id == "3") echo 'selected'; }?>>U.K.G</option> 
                                            <option value="4" <?php  if(isset($class_id)) { if($class_id == "4") echo 'selected'; }?>>I</option> 
                                            <option value="5" <?php  if(isset($class_id)) { if($class_id == "5") echo 'selected'; }?>>II</option> 
                                            <option value="6" <?php  if(isset($class_id)) { if($class_id == "6") echo 'selected'; }?>>III</option> 
                                        </select>
                                    </div>
                                </div>

                                    <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="button" class="btn btn-primary" id="table_view" name="table_view" style="margin-top:20px;" value="View"> 
                                             <!-- <span class="text-danger" id="email_idcheck">Enter Valid E-mail Id</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>  
                                <!--                             
                            <div class="col-md-12">
                            <br><br> -->
                            <!-- <div class="text-right">
                                <button type="submit" onclick="submitsubject_creation();" name="submitsubject_creation" id="submitsubject_creation" class="btn btn-primary" value="Submit" tabindex="14">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="15">Cancel</button>
                            </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
                            <div id="stockinfotable">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Subject Details</div>
                                    </div>
                                </div>
                                <!-- alert messages -->
                                <div id="subject_detailsInsertNotOk" class="unsuccessalert">subject_details Already Exists, Please Enter a Different Name!
                                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="subject_detailsInsertOk" class="successalert">subject_details Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="subject_detailsUpdateOk" class="successalert">subject_details Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="subject_detailsDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This subject_details!
                                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="subject_detailsDeleteOk" class="successalert">Subject Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Paper Name</label>
                                            <input  name="paper_name" id="paper_name" placeholder="Paper Name" value="" class="form-control"  type="text">
                                            <input type="hidden" class="form-control" id="subject_id" name="subject_id" 
                                                aria-describedby="id" placeholder="Enter id">
                                        <span class="text-danger" tabindex="1" id="papernameCheck">Enter Subject Name</span>

                                        </div>
                                    </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Max Mark</label>
                                        <input  name="max_mark" id="max_mark" placeholder="Max Mark" value="" class="form-control"  type="number">
                                        <input  name="class_id" id="class_id" class="form-control" value="<?php if(isset($class_id )) echo $class_id ; ?>" type="hidden">
                                        <input  name="insert_login_id" id="insert_login_id" class="form-control" value="<?php if(isset($userid )) echo $userid ;?>" type="hidden">
                                        <span class="text-danger" tabindex="1" id="max_markCheck">Enter Mark</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <button style="margin-top:20px;" type="button" name="ajaxAllocationBtn" id="ajaxAllocationBtn" class="btn btn-primary" value="submit" tabindex="10">Save</button>
                                    </div>
                                </div>
                            </div>
                        <div id="updatedstockinfotable"> 
                    <table class="table custom-table" id="updatedSyllabusTable"> 
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Paper Name</th>
                                <th>Max Mark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (sizeof($SubjectList)>0) { 
                                for($j=0;$j<count($SubjectList);$j++) { ?>
                                <tr>
                                    <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                    <td><?php  echo $SubjectList[$j]['paper_name']; ?></td>
                                    <td><?php  echo $SubjectList[$j]['max_mark']; ?></td>
                                    <td>
                                        <a id="edit_subject" value="<?php echo $SubjectList[$j]['subject_id'] ?>"><span class="icon-border_color"></span></a> &nbsp;
                                        <a id="delete_subject" value="<?php echo $SubjectList[$j]['subject_id'] ?>"><span class='icon-trash-2'></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>  
</form>
<script>
   setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000);
</script>

