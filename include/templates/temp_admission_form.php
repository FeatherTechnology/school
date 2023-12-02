<?php 

@session_start();
if(isset($_SESSION["userid"])){

    $userid = $_SESSION["userid"];
    $school_id =$_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
   
}
$id=0;
 if(isset($_POST['submittemp_admission_creation']) && $_POST['submittemp_admission_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateTempStudentCreationmaster = $userObj->updateTempStudentCreation($mysqli,$id,$userid,$school_id,$year_id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_temp_admission_form&msc=2';</script> 
    <?php	}
    else{   
		$addTempStudentCreation = $userObj->addTempStudentCreation($mysqli,$userid,$school_id,$year_id);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_temp_admission_form&msc=1';</script>
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
	$deleteTempStudentCreation = $userObj->deleteTempStudentCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_temp_admission_form&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
    if(isset($_SESSION["userid"])){

        $userid = $_SESSION["userid"];
        $school_id =$_SESSION["school_id"];
        $year_id = $_SESSION["academic_year"];
       
    }
	$getTempStudentCreation = $userObj->getTempStudentCreation($mysqli,$idupd,$school_id,$year_id); 
	
	if (sizeof($getTempStudentCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getTempStudentCreation);$ibranch++)  {	
            $temp_admission_id                       = $getTempStudentCreation['temp_admission_id'];
			$temp_student_name                	 = $getTempStudentCreation['temp_student_name'];
			$temp_dob          		     = $getTempStudentCreation['temp_dob'];
			$temp_contact_number      			     = $getTempStudentCreation['temp_contact_number'];
			$temp_gender		         = $getTempStudentCreation['temp_gender'];
			$temp_category    			         = $getTempStudentCreation['temp_category'];
			$temp_standard                	 = $getTempStudentCreation['temp_standard'];
			$temp_no                	 = $getTempStudentCreation['temp_no'];
            $temp_student_type                   = $getTempStudentCreation['temp_student_type'];
			$temp_medium       		     = $getTempStudentCreation['temp_medium'];
			$temp_entrance_exam_date     			     = $getTempStudentCreation['temp_entrance_exam_date'];
			$temp_entrance_exam_mark     		             = $getTempStudentCreation['temp_entrance_exam_mark'];
			$temp_src     			     = $getTempStudentCreation['temp_src'];
			$temp_father_name                      = $getTempStudentCreation['temp_father_name'];
            $temp_mother_name                      = $getTempStudentCreation['temp_mother_name']; 
            $temp_area                      = $getTempStudentCreation['temp_area']; 
            $temp_flat_no                      = $getTempStudentCreation['temp_flat_no']; 
            $temp_street                      = $getTempStudentCreation['temp_street']; 
            $temp_district                      = $getTempStudentCreation['temp_district']; 
            
		}
	}
}
?>
<style>.select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
</style>
<link rel="stylesheet" href="css/select2.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- Page header start -->
<style>
    h5{
       font-size: 1rem;
       margin-bottom: 0px; 
    }
    
</style>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Temporary Admission Form </li>
    </ol>

    <a href="edit_temp_admission_form">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "school_creation" name="school_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($temp_admission_id)) echo "$temp_admission_id"; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                <div class="card-header">
						<div class="card-title"><div id="example1" style="width: fit-content; padding: 10px;border-radius: 50px 50px; border: 2px solid #4789f129;background-color: #1b6aaa;color: whitesmoke;text-align: center;"><h5>General Info</h5></div></div>
                        
					</div>
                    <div class="card-body">

                    	 <div class="row ">
                            <!--Fields -->
                                    <div class="col-md-12 ">
                                                <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student Name</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="1" id="temp_student_name" name="temp_student_name" class="form-control"  value="<?php if(isset($temp_student_name)) echo $temp_student_name; ?>" placeholder="Enter Student Name">
                                                    <span id="valname" class="text-danger"></span></div>
                                                        <div class="col-sm-5" ></div>
                                                </div> 
                                                <br>
                                                <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Of Birth</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" > <input type="date" tabindex="2" id="temp_dob" name="temp_dob" class="form-control"  value="<?php if(isset($temp_dob)) echo $temp_dob; ?>"><div class="text-success"  id="age-result"></div><div  class="text-danger" id="age-result1"></div></div>
                                                        <div class="col-sm-5" ></div>
                                                </div> 
                                                <br>
                                                <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" > <input type="radio" tabindex="3" name="temp_gender" id="male" value="Male" <?php if(isset($temp_gender))
                                         echo ($temp_gender=='Male')?'checked':'' ?>> &nbsp;&nbsp; <label for="male">Male </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="4" name="temp_gender" id="female"  value="Female" <?php if(isset($temp_gender))
                                         echo ($temp_gender=='Female')?'checked':'' ?>> &nbsp;&nbsp; <label for="female">Female </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="col-sm-5" ></div>
                                                </div> 
                                                <br>
                                                <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-6" > <input type="radio" tabindex="5"  name="temp_category" id="obc" value="OBC" <?php  if(isset($temp_category)) echo ($temp_category == "OBC") ?'checked':'' ?>> &nbsp;&nbsp; <label for="obc">OBC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="bc"  value="BC" <?php  if(isset($temp_category)) echo($temp_category == "BC") ?'checked':'' ?>> &nbsp;&nbsp; <label for="bc">BC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="mbc"  value="MBC" <?php  if(isset($temp_category)) echo($temp_category == "MBC") ?'checked':''  ?>> &nbsp;&nbsp; <label for="mbc">MBC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="sc"  value="SC" <?php  if(isset($temp_category)) echo($temp_category == "SC") ?'checked':''  ?>> &nbsp;&nbsp; <label for="sc">SC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="st"  value="ST" <?php  if(isset($temp_category)) echo($temp_category == "ST") ?'checked':''  ?>> &nbsp;&nbsp; <label for="st">ST </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="dnc"  value="DNC" <?php  if(isset($temp_category)) echo($temp_category == "DNC")  ?'checked':''   ?>> &nbsp;&nbsp; <label for="dnc">DNC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="bcm"  value="BCM" <?php  if(isset($temp_category)) echo($temp_category == "BCM")  ?'checked':''  ?>> &nbsp;&nbsp; <label for="bcm">BCM </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="col-sm-3" ></div>
                                                </div> 
                                        <!-- <div class="row">
                                        
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="disabledInput">Student Name</label>
                                                        <input type="text" tabindex="1" id="temp_student_name" name="temp_student_name" class="form-control"  value="<?php if(isset($temp_student_name)) echo $temp_student_name; ?>" placeholder="Enter Student Name">
                                                        <!-- <span id="student_namecheck" class="text-danger" >Enter Student Name</span> 
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="disabledInput">Date Of Birth</span></label>
                                                        <input type="date" tabindex="2" id="temp_dob" name="temp_dob" class="form-control"  value="<?php if(isset($temp_dob)) echo $temp_dob; ?>">
                                                        <div class="text-success"  id="age-result"></div>
                                                        <div  class="text-danger" id="age-result1"></div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="disabledInput">Gender</label><br>
                                                        <input type="radio" tabindex="3" checked name="temp_gender" id="male" value="Male" <?php if(isset($temp_gender))
                                         echo ($temp_gender=='Male')?'checked':'' ?>> &nbsp;&nbsp; <label for="male">Male </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="4" name="temp_gender" id="female"  value="Female" <?php if(isset($temp_gender))
                                         echo ($temp_gender=='Female')?'checked':'' ?>> &nbsp;&nbsp; <label for="female">Female </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>

                                                <div class="col-xl-5 col-lg-4 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="disabledInput">Category</label><br><br>
                                                        <input type="radio" tabindex="5" checked name="temp_category" id="obc" value="OBC" <?php  if(isset($temp_category)) { if($temp_category == "OBC") echo 'selected'; }?>> &nbsp;&nbsp; <label for="obc">OBC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="bc"  value="BC" <?php  if(isset($temp_category)) { if($temp_category == "BC") echo 'selected'; }?>> &nbsp;&nbsp; <label for="bc">BC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="mbc"  value="MBC" <?php  if(isset($temp_category)) { if($temp_category == "MBC") echo 'selected'; }?>> &nbsp;&nbsp; <label for="mbc">MBC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="sc"  value="SC" <?php  if(isset($temp_category)) { if($temp_category == "SC") echo 'selected'; }?>> &nbsp;&nbsp; <label for="sc">SC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="st"  value="ST" <?php  if(isset($temp_category)) { if($temp_category == "ST") echo 'selected'; }?>> &nbsp;&nbsp; <label for="st">ST </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="dnc"  value="DNC" <?php  if(isset($temp_category)) { if($temp_category == "DNC") echo 'selected'; }?>> &nbsp;&nbsp; <label for="dnc">DNC </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" tabindex="5" name="temp_category" id="bcm"  value="BCM" <?php  if(isset($temp_category)) { if($temp_category == "BCM") echo 'selected'; }?>> &nbsp;&nbsp; <label for="bcm">BCM </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                        </div> -->
                                    </div>
                                    
                                    <div class="card-header">
                                        <div class="card-title"><br><div id="example1" style="width: 100%; padding: 10px;border-radius: 50px 50px; border: 2px solid #4789f129;background-color: #1b6aaa;color: whitesmoke;text-align: center;"><h5>Joining Details</h5></div></div>
                                    </div>
                                    <div class="col-md-12 "> 
                                        <!-- <div class="row"> -->
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Standard</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" >
                                                        <select class="form-control" tabindex="6" id="temp_standard" name="temp_standard">
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
                                                     <input type="hidden" tabindex="1" id="temp_no" name="temp_no" class="form-control"  value="<?php if(isset($temp_no)) echo $temp_no; ?>" placeholder="Enter Student Name">
                                                         </div>
                                                        <div class="col-sm-5" ></div>
                                        </div> <br>
                                        
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Medium</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" >  <select class="form-control " id="temp_medium" tabindex="8" name="temp_medium">
                                                        <option>Select Medium</option> 
                                                        <option value="Tamil"  <?php  if(isset($temp_medium)) { if($temp_medium == "Tamil") echo 'selected'; }?>>Tamil</option> 
                                                        <option value="English"  <?php  if(isset($temp_medium)) { if($temp_medium == "English") echo 'selected'; }?>>English</option>
                                                    </select></div>
                                                        <div class="col-sm-5" ></div>
                                        </div> <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entrance Exam Date</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" > <input class="form-control" tabindex="9" id="temp_entrance_exam_date" name="temp_entrance_exam_date" type="date" value="<?php if(isset($temp_entrance_exam_date)) echo $temp_entrance_exam_date; ?>"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div> <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entrance Mark</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" > <input type="number" tabindex="10" id="temp_entrance_exam_mark" name="temp_entrance_exam_mark" class="form-control"  value="<?php if(isset($temp_entrance_exam_mark)) echo $temp_entrance_exam_mark; ?>" placeholder="Enter Entrance Mark"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div> <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;visibility:hidden"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" >
                                                        <input type="radio" tabindex="11"  name="temp_src" id="scholarship" value="Scholarship" <?php if(isset($temp_src)) echo ($temp_src=='Scholarship')?'checked':'' ?>> &nbsp;&nbsp; <label for="male">Scholarship </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" tabindex="12" name="temp_src" id="rte"  value="RTE" <?php if(isset($temp_src)) echo ($temp_src=='RTE')?'checked':'' ?>> &nbsp;&nbsp; <label for="rte">RTE </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" tabindex="13" name="temp_src" id="concession"  value="Concession" <?php if(isset($temp_src)) echo ($temp_src=='Concession')?'checked':'' ?>> &nbsp;&nbsp; <label for="concession">Concession </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="col-sm-5" ></div>
                                        </div> <br>
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputReadOnly">Standard</label>
                                                    <select class="form-control" tabindex="6" id="temp_standard" name="temp_standard">
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
                                            </div> -->
                                         
                                                        <!-- <input type="hidden" tabindex="1" id="temp_no" name="temp_no" class="form-control"  value="<?php if(isset($temp_no)) echo $temp_no; ?>" placeholder="Enter Student Name"> -->
                                                      
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputReadOnly">Student Type</label>
                                                    <select class="form-control select2" tabindex="7" id="temp_student_type" name="temp_student_type">
                                                        <option>Select Type</option> 
                                                        <option value="New Student"  <?php  if(isset($temp_student_type)) { if($temp_student_type == "New Student") echo 'selected'; }?>>New Student</option> 
                                                        <option value="Old Student"  <?php  if(isset($temp_student_type)) { if($temp_student_type == "Old Student") echo 'selected'; }?>>Old Student</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                           
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputReadOnly">Entrance Exam Date</label>
                                                    <input class="form-control" tabindex="9" id="temp_entrance_exam_date" name="temp_entrance_exam_date" type="date" value="<?php if(isset($temp_entrance_exam_date)) echo $temp_entrance_exam_date; ?>">
                                                  
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Entrance Mark</label>
                                                    <input type="number" tabindex="10" id="temp_entrance_exam_mark" name="temp_entrance_exam_mark" class="form-control"  value="<?php if(isset($temp_entrance_exam_mark)) echo $temp_entrance_exam_mark; ?>" placeholder="Enter Entrance Mark">
                                                    <!-- <span id="student_namecheck" class="text-danger" >Enter Student Name</span> 
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput" style="visibility:hidden">Gender</label><br>
                                                    <input type="radio" tabindex="11" checked name="temp_src" id="scholarship" value="Scholarship"> &nbsp;&nbsp; <label for="male">Scholarship </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" tabindex="12" name="temp_src" id="rte"  value="RTE"> &nbsp;&nbsp; <label for="rte">RTE </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" tabindex="13" name="temp_src" id="concession"  value="Concession"> &nbsp;&nbsp; <label for="concession">Concession </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div> -->
                                        <!-- </div> -->
                                    </div>  
                                    <div class="card-header">
                                        <div class="card-title"><div id="example1" style="width: 100%; padding: 10px;border-radius: 50px 50px; border: 2px solid #4789f129;background-color: #1b6aaa;color: whitesmoke;text-align: center;"><h5>Parents Info</h5></div></div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 "> 
                                        
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Father Name</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="14" id="temp_father_name" name="temp_father_name" class="form-control"  value="<?php if(isset($temp_father_name)) echo $temp_father_name; ?>" placeholder="Enter Father Name"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div> 
                                    <br>

                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother Name</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="15" id="temp_mother_name" name="temp_mother_name" class="form-control"  value="<?php if(isset($temp_mother_name)) echo $temp_mother_name; ?>" placeholder="Enter Mother Name"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                    <br>

                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Number</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="number" tabindex="16" onkeydown="javascript: return event.keyCode == 69 ? false : true" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" id="temp_contact_number" name="temp_contact_number" class="form-control"  value="<?php if(isset($temp_contact_number)) echo $temp_contact_number; ?>" placeholder="Enter Contact Number">
                                                         <span id="val_mob" class="text-danger"></span></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                    <br>

                                        <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Father Name</label>
                                                    <input type="text" tabindex="14" id="temp_father_name" name="temp_father_name" class="form-control"  value="<?php if(isset($temp_father_name)) echo $temp_father_name; ?>" placeholder="Enter Father Name">
                                                    <span id="student_namecheck" class="text-danger" >Enter Student Name</span>
                                                </div>
                                        </div> -->
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Mother Name</label>
                                                    <input type="text" tabindex="15" id="temp_mother_name" name="temp_mother_name" class="form-control"  value="<?php if(isset($temp_mother_name)) echo $temp_mother_name; ?>" placeholder="Enter Mother Name">
                                                    <span id="student_namecheck" class="text-danger" >Enter Student Name</span>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Contcat Number</label>
                                                    <input type="number" tabindex="16" onkeydown="javascript: return event.keyCode == 69 ? false : true" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" id="temp_contact_number" name="temp_contact_number" class="form-control"  value="<?php if(isset($temp_contact_number)) echo $temp_contact_number; ?>" placeholder="Enter Contact Number">
                                                    <span id="student_namecheck" class="text-danger" >Enter Student Name</span>
                                                </div>
                                            </div> -->
                                        
                                    </div>  
                                    <div class="card-header">
                                        <div class="card-title"><div id="example1" style="width: 100%; padding: 10px;border-radius: 50px 50px; border: 2px solid #4789f129;background-color: #1b6aaa;color: whitesmoke;text-align: center;"><h5>Address For Communication</h5></div></div>
                                    </div>
                                    <div class="col-md-12 "> 

                                    <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flat No</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="17" id="temp_flat_no" name="temp_flat_no" class="form-control"  value="<?php if(isset($temp_flat_no)) echo $temp_flat_no; ?>" placeholder="Enter Flat No"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                        <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Street</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="18" id="temp_street" name="temp_street" class="form-control"  value="<?php if(isset($temp_street)) echo $temp_street; ?>" placeholder="Enter Street Name"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                        <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Area / Locality</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="19" id="temp_area" name="temp_area" class="form-control"  value="<?php if(isset($temp_area)) echo $temp_area; ?>" placeholder="Enter Area/Locality"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                        <br>
                                        <div class="row" >
                                                        <div class="col-sm-2" style="padding-top: 9px;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District</h6></div>
                                                        <div class="col-sm-1" ></div>
                                                        <div class="col-sm-4" ><input type="text" tabindex="20" id="temp_district" name="temp_district" class="form-control"  value="<?php if(isset($temp_district))  echo $temp_district;?>" placeholder="Enter District"></div>
                                                        <div class="col-sm-5" ></div>
                                        </div>
                                        <br>
                                        <!-- <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Flat No</label>
                                                    <input type="text" tabindex="17" id="temp_flat_no" name="temp_flat_no" class="form-control"  value="<?php if(isset($temp_flat_no)) echo $temp_flat_no; ?>" placeholder="Enter Flat No">
                                                    <span id="student_namecheck" class="text-danger" >Enter Student Name</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Street</label>
                                                    <input type="text" tabindex="18" id="temp_street" name="temp_street" class="form-control"  value="<?php if(isset($temp_street)) echo $temp_street; ?>" placeholder="Enter Street Name">
                                                    <span id="student_namecheck" class="text-danger" >Enter Student Name</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">Area / Locality</label>
                                                    <input type="text" tabindex="19" id="temp_area" name="temp_area" class="form-control"  value="<?php if(isset($temp_area)) echo $temp_area; ?>" placeholder="Enter Area/Locality">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="disabledInput">District</label>
                                                    <input type="text" tabindex="20" id="temp_district" name="temp_district" class="form-control"  value="<?php if(isset($temp_district))  echo $temp_district;?>" placeholder="Enter District">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                            <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" onclick="submittemp_admission_creation();" name="submittemp_admission_creation" id="submittemp_admission_creation" class="btn btn-primary" value="Submit" tabindex="21">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="22">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var loadFile = function(event) {
        var image = document.getElementById("viewimage");
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    $('.select2').select2();
</script>

