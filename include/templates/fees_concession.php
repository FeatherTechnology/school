<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
    
   
} 
$StudentList = $userObj->getStudentList($mysqli,$school_id,$year_id);

$id=0;
 if(isset($_POST['SubmitFeesConcession']) && $_POST['SubmitFeesConcession'] != '')
 {

    $updatePayConcessionfeesCreationmaster = $userObj->updatePayConcessionfeesCreation($mysqli,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>fees_concession';</script> 
    <?php	}   

?>
<style>
    .dataTables_filter input {
    border: 1px solid #e4e4e4;
    padding: 7px;
}
.select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
.select2{
    width:377%
}
</style>
<link rel="stylesheet" href="css/select2.min.css" />
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Overall Concession Screen </li>
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
                                <input type="hidden" class="form-control" value="<?php if(isset($school_id)) echo $school_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <!--Fields -->
                                                    <div class="col-md-12 "> 
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <input type="radio" tabindex="40" name="concession_type" id="general_concession" value="General Concession" <?php if(isset($concession_type))
                                                                echo ($concession_type=='General Concession')?'checked':'' ?>> &nbsp;&nbsp; <label for="general_concession">General Concession </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" tabindex="41" name="concession_type" id="referal_concession"  value="Referal Concession" <?php if(isset($concession_type))
                                                                echo ($concession_type=='Referal Concession')?'checked':'' ?>> &nbsp;&nbsp; <label for="referal_concession">Referal Concession  </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" tabindex="42" name="concession_type" id="manual_concession"  value="Manual Concession" <?php if(isset($concession_type))
                                                                echo ($concession_type=='Manual Concession')?'checked':'' ?>> &nbsp;&nbsp; <label for="manual_concession">Manual Concession </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="manual_concessionDiv" style="display:none;">
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">General Concession Form</div>
                                                </div>
                                            <div class="card-body">
                                                <div class="row ">
                                                <!--Fields -->
                                                     <div class="col-md-12 "> 
                                                        <div class="row">
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Medium</label>
                                        <select class="form-control select2" id="medium" name="medium">
                                        <option>Select Medium</option> 
                                        <option value="Tamil" <?php  if(isset($medium)) { if($medium == "Tamil") echo 'selected'; }?>>Tamil</option> 
                                        <option value="English" <?php  if(isset($medium)) { if($medium == "English") echo 'selected'; }?>>English</option>
                                    </select>
                                 </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Standard List</label>
                                            <select class="form-control select2" id="standard" name="standard">
                                                <option value="">Select a Standard...</option>
                                                <option value="PRE.K.G" <?php  if(isset($standard)) { if($standard == "PRE.K.G") echo 'selected'; }?>>PRE.K.G</option>
                                                <option value="L.K.G"<?php  if(isset($standard)) { if($standard == "L.K.G") echo 'selected'; }?>>L.K.G</option>
                                                <option value="U.K.G" <?php  if(isset($standard)) { if($standard == "U.K.G") echo 'selected'; }?>>U.K.G</option>
                                                <option value="I" <?php  if(isset($standard)) { if($standard == "I") echo 'selected'; }?>>I</option>
                                                <option value="II" <?php  if(isset($standard)) { if($standard == "II") echo 'selected'; }?>>II</option>
                                                <option value="III" <?php  if(isset($standard)) { if($standard == "III") echo 'selected'; }?>>III</option>
                                                <option value="IV" <?php  if(isset($standard)) { if($standard == "IV") echo 'selected'; }?>>IV</option>
                                                <option value="V" <?php  if(isset($standard)) { if($standard == "V") echo 'selected'; }?>>V</option>
                                                <option value="VI" <?php  if(isset($standard)) { if($standard == "VI") echo 'selected'; }?>>VI</option>
                                                <option value="VI" <?php  if(isset($standard)) { if($standard == "VI") echo 'selected'; }?>>VII</option>
                                                <option value="VIII" <?php  if(isset($standard)) { if($standard == "VIII") echo 'selected'; }?>>VIII</option>
                                                <option value="IX" <?php  if(isset($standard)) { if($standard == "IX") echo 'selected'; }?>>IX</option>
                                                <option value="X" <?php  if(isset($standard)) { if($standard == "X") echo 'selected'; }?>>X</option>
                                                <option value="XI_Maths_Biology" <?php  if(isset($standard)) { if($standard == "XI_Maths_Biology") echo 'selected'; }?>>XI_Maths_Biology</option>
                                                <option value="XI_Maths_ComputerScience" <?php  if(isset($standard)) { if($standard == "XI_Maths_ComputerScience") echo 'selected'; }?>>XI_Maths_ComputerScience</option>
                                                <option value="XI_Biology_ComputerScience" <?php  if(isset($standard)) { if($standard == "XI_Biology_ComputerScience") echo 'selected'; }?>>XI_Biology_ComputerScience</option>
                                                <option value="XII_Maths_Biology" <?php  if(isset($standard)) { if($standard == "XII_Maths_Biology") echo 'selected'; }?>>XII_Maths_Biology</option>
                                                <option value="XII_Maths_ComputerScience" <?php  if(isset($standard)) { if($standard == "XII_Maths_ComputerScience") echo 'selected'; }?>>XII_Maths_ComputerScience</option>
                                                <option value="XII_Biology_ComputerScience" <?php  if(isset($standard)) { if($standard == "XII_Biology_ComputerScience") echo 'selected'; }?>>XII_Biology_ComputerScience</option>
                                                <option value="XI_All" <?php  if(isset($standard)) { if($standard == "XI_All") echo 'selected'; }?>>XI_All</option>
                                                <option value="XII_All" <?php  if(isset($standard)) { if($standard == "XII_All") echo 'selected'; }?>>XII_All</option>
                                                <option value="XI_Commerce_ComputerScience" <?php  if(isset($standard)) { if($standard == "XI_Commerce_ComputerScience") echo 'selected'; }?>>XI_Commerce_ComputerScience</option>
                                                <option value="XII_Commerce_ComputerScience" <?php  if(isset($standard)) { if($standard == "XII_Commerce_ComputerScience") echo 'selected'; }?>>XII_Commerce_ComputerScience</option>
                                               
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
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Select Students</label>
                                        <select class="form-control select2" id="student_id" name="student_id">
                                            <option value="">Select a Student...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                    <select class="form-control select2" id="student_name1" name="student_name1"><option value="">Select a Student...</option>
                                            <?php if (sizeof($StudentList)>0) { 
                                                for($j=0;$j<count($StudentList);$j++) { ?>
                                                <option <?php if(isset($student_id)) { if($StudentList[$j]['student_id'] == $student_id)  echo 'selected'; }  ?> value="<?php echo $StudentList[$j]['student_id']; ?>">
                                                <?php echo $StudentList[$j]['student_name'] .'-'. $StudentList[$j]['admission_number'] ;?></option>
                                                <?php }} ?>
                                            </select>
                                        <!-- <span id="studentstypeCheck" class="text-danger">Please Select Student Type</span> -->
                                    </div>
                                </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12"></div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput"><b>OR</b></label>
                                        </div>
                                    </div>     
              
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="student_detailsDiv" style="display:none">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div id="stockinfotable">
                                            <div class="card">
                                                <!-- <div class="card-header">
                                                    <div class="card-title">Student Concession List Pending for Approval</div>
                                                </div> -->
                                                <div class="card-body">
                                                    <div id="updatedstockinfotable"> 
                                                    <table id="general_concessionTable" class="table custom-table" cellspacing="0" ></table>
                                                    </div>
                                                    <center><button type="submit" name="SubmitFeesConcession" id="SubmitFeesConcession" class="btn btn-success" value="Submit" tabindex="9"><span class="icon-keyboard_tab"></span>&nbsp;Approve This Concession</button></center>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div id="student_detailswithoutDiv" style="display:none">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div id="stockinfotable">
                                            <div class="card">
                                                <!-- <div class="card-header">
                                                    <div class="card-title">Student Concession List Pending for Approval</div>
                                                </div> -->
                                                <div class="card-body">
                                                    <div id="updatedstockinfotable1"> 
                                                    <table id="general_concessionTable1" class="table custom-table" cellspacing="0" ></table>
                                                    </div>
                                                    <center><button type="submit" name="SubmitFeesConcession" id="SubmitFeesConcession" class="btn btn-success" value="Submit" tabindex="9"><span class="icon-keyboard_tab"></span>&nbsp;Approve This Concession</button></center>

                                                </div>
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

</script>

