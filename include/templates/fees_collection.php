<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
    $academic_year = $_SESSION["academic_year"];
} 
// print_r($_SESSION);
$FeesList = $userObj->getFeesMasterModel1Details($mysqli,$school_id,$academic_year);

$StudentList = $userObj->getStudentList($mysqli,$school_id,$year_id);



?>
<style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  /* width: 30%; */
  padding-left: 105px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 10px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
td input{
 border:none;
}
.responsive-table {
  width: 100%;
  border-collapse: collapse;
}

.responsive-table th,
.responsive-table td {
  padding: 8px;
  border: 1px solid #ccc;
}
</style>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Fees Collection </li>
       
    </ol>

    <a href="edit_school_creation">
        <!-- <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button> -->
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "school_creation" name="school_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($fees_id)) echo $fees_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Select Students</label>
                                        <select  class="form-control select2" id="student_id" name="student_id" > <!--onchange="paidFees()" -->
                                            <option value="">Select a Student...</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                                    
                                    <!-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                    
                                    </div>
                                </div>   -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <label for="disabledInput" style="display: block; text-align: center;"><b>OR</b></label>
                                    </div>
                                </div>
                                     
                                
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                    <select class="form-control select2" id="student_name1" name="student_name1" > <!--onchange="paidFees()" -->
                                            <option value="">Select a Student...</option>
                                            <?php
                                            if (sizeof($StudentList) > 0) {
                                                for ($j = 0; $j < count($StudentList); $j++) {
                                                $selected = "";
                                                if (isset($student_id) && $StudentList[$j]['student_id'] == $student_id || isset($_GET['st']) && $StudentList[$j]['student_id'] == $_GET['st']) {
                                                    $selected = "selected";
                                                }
                                                                                              
                                                ?>
                                                <option value="<?php echo $StudentList[$j]['student_id']; ?>" <?php echo $selected; ?>>
                                                    <?php echo $StudentList[$j]['student_name'] . '-' . $StudentList[$j]['admission_number']; ?>
                                                </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        <!-- <span id="studentstypeCheck" class="text-danger">Please Select Student Type</span>  if (isset($_GET['st'])) {  $dynamic_id = $_GET['st']; }  -->
                                                
                                    </div>
                                </div>  
                                </div>
                            </div>  
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                    	 <div class="row ">
                            <!--Fields -->
                            <div class="col-md-12"> 
                                <div id="stockinfotable">
                                    <div class="col-md-12"> 
                                        <div class="row">
                                        <!-- column -->
                                            <div class="" style="overflow-x: auto;">
                                                <label for="">Click Here</label>&nbsp;
                                                    <a  onclick="payFees();">
                                                        <button name="student_pay_fees" id="student_pay_fees" type="button" class="btn btn-primary">
                                                            <span class="icon-keyboard_tab"></span>&nbsp;Pay Fees
                                                        </button>
                                                    </a> <br><br>
                                                <table class="responsive-table">
                                                <tr style="border: 1px solid white;">
                                                    <th colspan="3" style="text-align:center">Student Details</th>
                                                </tr>
                                                <tr style="border: 1px solid white;">
                                                    <td style="border-right: 1px solid white;">Admission No</td>
                                                    <td style="background-color: #2d5a7f6e;"><input type="text" style="background-color: transparent;color:#f6f8fa;"  id="admission_number"></td>
                                                </tr>
                                                <tr style="border: 1px solid white;">
                                                    <td style="border-right: 1px solid white;">Roll Number</td>
                                                    <td style="background-color: #2d5a7f6e;"><input type="text" style="background-color: transparent;color:#f6f8fa;" id="roll_number"></td>
                                                </tr>
                                                <tr style="border-right: 1px solid white;">
                                                    <td style="border: 1px solid white;">Class-Section</td>
                                                    <td style="background-color: #2d5a7f6e;"><input type="text" style="background-color: transparent;color:#f6f8fa;" id="section1"></td>
                                                </tr>
                                                <tr style="border: 1px solid white;">
                                                    <td style="border-right: 1px solid white;">Student Name</td>
                                                    <td style="background-color: #2d5a7f6e;"><input type="text" style="background-color: transparent;color:#f6f8fa;" id="student_name"><input type="hidden" style="background-color: transparent;color:#f6f8fa;" id="student_type"></td>
                                                </tr>
                                                </table>
                                            </div><div class="col-xl-1 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                                            <div class="" style="overflow-x: auto;">
                                                <label for="">Click Here</label>&nbsp;<a  onclick="payTrasportFees();"><button type="button" class="btn btn-primary"><span class="icon-keyboard_tab"></span>&nbsp;Pay Transport Fees</button></a>
                                                    &nbsp;<a  onclick="payLastYearFees()"><button type="button" class="btn btn-primary"><span class="icon-keyboard_tab"></span>&nbsp;Pay Last Year Fees</button></a>
                                                <table style="border-bottom: 1px solid #5090c070;"  class="responsive-table">
                                                    <tr >
                                                        <img style="visibility:hidden" src="img/Logo.png" height="50px" width="50px" alt="testing">
                                                        <th style="border-right: 1px solid white;">Fees Details</th>
                                                        <th style="border-right: 1px solid white;">Group Fees</th>
                                                        <th style="border-right: 1px solid white;">Extra Curricular Fees</th>
                                                        <th style="border-right: 1px solid white;">Amenity Fees</th>
                                                        <th style="border-right: 1px solid white;">Transport Fees</th>
                                                        <th>Last Year Fees</th>
                                                    </tr>
                                                    <tr style="border: 1px solid white;">
                                                        <td  style="border-right: 1px solid #5090c070;">Gross Payable</td>
                                                        <td  style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="grp_amount" value="0"></td>
                                                        <td  style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="extra_amount" value="0"></td>
                                                        <td  style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="amenity_amount" value="0"></td>
                                                        <td  style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="tranport_grp_amount" value="0"></td>
                                                        <td  style=" border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="last_year_amount" value="0"></td>
                                                    </tr>
                                                    <tr style="border: 1px solid white;">
                                                    <td style="border-right: 1px solid #5090c070;">Amount Paid</td>
                                                    <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;" type="number" readonly id="grp_amountre" value="0"></td>
                                                    <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;" type="number" readonly id="extra_amountre" value="0"></td>
                                                    <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;" type="number" readonly id="amenity_amountre" value="0"></td>
                                                    <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;" type="number" readonly id="tranport_received_amount" value="0"></td>
                                                    <td  style=" border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;" type="number" readonly id="last_year_received_amount" value="0"></td>
                                                    <!-- <td><input style="background-color:#f6f8fa;" type="number" readonly id="tranport_balance_amount1"></td> -->
                                                    </tr>
                                                    <tr style="border: 1px solid white;">
                                                        <td style="border-right: 1px solid #5090c070;">Concession</td>
                                                        <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="grp_concession_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="extra_concession_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="amenity_concession_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2;" type="number" readonly id="tranport_concession_amount" value="0"></td>
                                                        <td  style=" border-right: 1px solid #5090c070;"><input style="background-color:#f2f2f2; " type="number" readonly id="last_year_concession_amount" value="0"></td>
                                                    </tr>
                                                    <tr style="border: 1px solid white;">
                                                        <td style="border-right: 1px solid #5090c070;font-style: italic;font-weight: bold;">Net Payable</td>
                                                         <td style="border-right: 1px solid #5090c070; border-bottom: 1px solid #5090c070;"><input style="background-color:#f6f8fa;font-style: italic;font-weight: bold;" type="number" readonly id="gross_balance_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070; border-bottom: 1px solid #5090c070;"><input style="background-color:#f6f8fa;font-style: italic;font-weight: bold;" type="number" readonly id="extra_balance_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070; border-bottom: 1px solid #5090c070;"><input style="background-color:#f6f8fa;font-style: italic;font-weight: bold;" type="number" readonly id="amenity_balance_amount" value="0"></td>
                                                        <td style="border-right: 1px solid #5090c070; border-bottom: 1px solid #5090c070;"><input style="background-color:#f6f8fa;font-style: italic;font-weight: bold;" type="number" readonly id="tranport_balance_amount" value="0"></td>
                                                        <td  style=" border-bottom: 1px solid #5090c070; border-right: 1px solid #5090c070;"><input style="background-color:#f6f8fa;font-style: italic;font-weight: bold;" type="number" readonly id="last_year_balance_amount" value="0"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div id="updatedstockinfotable"></div>
                            </div><br><br>
                    <!-- grp Table End -->
                </div>
            </div>
        </div>  
    </form>
    <div id="poprintfield" style="display: none"></div>
    
