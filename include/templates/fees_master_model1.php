<!--- 1= Tamil, 2= English, 1 = New Student, 2 = Old Student -->
<?php
// $FeesList = $userObj->getFeesMasterModel1Details($mysqli);
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Fees Master </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--------form start-->
    <form id="school_creation" name="school_creation" action="" method="post" enctype="multipart/form-data">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row ">
                            <!--Fields -->
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Academic Year</label>
                                            <select tabindex="1" type="text" class="form-control select2 freezeFieldAfterClick" id="academic_year" name="academic_year" tabindex="1">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Medium</label>
                                            <select class="form-control select2 freezeFieldAfterClick" id="medium" name="medium"> <!--- 1= Tamil, 2= English -->
                                                <option>Select Medium</option>
                                                <option value="1">Tamil</option>
                                                <option value="2">English</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Students Type</label>
                                            <select class="form-control select2 freezeFieldAfterClick" id="student_type" name="student_type"> <!--1 = New Student, 2 = Old Student -->
                                                <option>Select Type</option>
                                                <option value="1">New Student</option>
                                                <option value="2">Old Student</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Standard List</label>
                                            <select class="form-control select2 freezeFieldAfterClick" id="standard" name="standard"> <!--From Ajax file --> </select>
                                        </div>
                                    </div><br><br><br><br><br><br>
                                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="button" name="table_view" id="table_view" class="btn btn-primary table_view" value="View" tabindex="14">
                                            <input type="button" name="table_refresh" id="table_refresh" class="btn btn-danger" value="Refresh" tabindex="14">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- Group/Course Fees STARTS-->
                        <div id="grp_course_fee_Div" style="display: none;">
                            <div class="card">
                                <div class="card-header" style="background-image: linear-gradient(white, #e6d9cc);">
                                    <div class="card-title">Group/Course Fees</div>
                                </div>
                                <div class="card-body">
                                    <!-- alert messages -->
                                    <div id="fees_detailsInsertNotOk" class="unsuccessalert">Group/Course Fees Already Exists, Please Enter a Different Name!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsInsertOk" class="successalert">Group/Course Fees Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsUpdateOk" class="successalert">Group/Course Fees Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Group/Course Fees!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsInsertFailed" class="unsuccessalert">Group/Course Fees Insert Failed!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsDeleteOk" class="successalert">Group/Course Fees Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Particulars</label>
                                                    <input type="hidden" name="grp_course_id" id="grp_course_id" class="grpTableField">
                                                    <input name="grp_particulars" id="grp_particulars" placeholder="Particulars" class="form-control grpTableField" type="text">
                                                    <span class="text-danger" id="grp_particularsCheck" style="display: none;">Enter Particulars</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input name="grp_amount" id="grp_amount" placeholder="Amount" class="form-control grpTableField" type="number">
                                                    <span class="text-danger" id="grp_amountCheck" style="display: none;">Enter Amount</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input name="grp_date" id="grp_date" class="form-control grpTableField" type="date">
                                                    <span class="text-danger" id="grp_dateCheck" style="display: none;">Enter Due Date</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <button style="margin-top:20px;" type="button" name="Submit_Group" id="Submit_Group" class="btn btn-primary" value="submit" tabindex="10">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="updatedstockinfotable"> </div>
                                </div>
                            </div>
                        </div>
                        <!--- Group/Course Fees END-->
                        <!--- Extra Curricular Activities START-->
                        <div id="extra_curricular_Div" style="display: none;">
                            <div class="card">
                                <div class="card-header" style="background-image: linear-gradient(white, #e6d9cc);">
                                    <div class="card-title">Extra Curricular Activities</div>
                                </div>
                                <div class="card-body">
                                    <!-- alert messages -->
                                    <div id="fees_detailsextraInsertNotOk" class="unsuccessalert">Extra Curricular Activities Fees Already Exists, Please Enter a Different Name!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsextraInsertOk" class="successalert">Extra Curricular Activities Fees Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsextraUpdateOk" class="successalert">Extra Curricular Activities Fees Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsextraDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Extra Curricular Activities Fees!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsextraInsertFailed" class="unsuccessalert">Extra Curricular Activities Fees Insert Failed!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsextraDeleteOk" class="successalert">Extra Curricular Activities Fees Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Particulars</label>
                                                    <input type="hidden" name="extra_fee_id" id="extra_fee_id" class="extraCurField">
                                                    <input name="extra_particulars" id="extra_particulars" placeholder="Particulars" class="form-control extraCurField" type="text">
                                                    <span class="text-danger" id="extra_particularsCheck" style="display: none;">Enter Particulars</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input name="extra_amount" id="extra_amount" placeholder="Amount" class="form-control extraCurField" type="number">
                                                    <span class="text-danger" id="extra_amountCheck" style="display: none;">Enter Amount</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input name="extra_date" id="extra_date" class="form-control extraCurField" type="date">
                                                    <span class="text-danger" id="extra_dateCheck" style="display: none;">Enter Date</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <button style="margin-top:20px;" type="button" name="Submit_Extra" id="Submit_Extra" class="btn btn-primary" value="submit" tabindex="10">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="updatedstockinfotableextra"> </div>
                                </div>
                            </div>
                        </div>
                        <!--- Extra Curricular Activities END-->

                        <!--- Amenity Fees START-->
                        <div id="amenity_fee_Div" style="display: none;">
                            <div class="card">
                                <div class="card-header" style="background-image: linear-gradient(white, #e6d9cc);">
                                    <div class="card-title">Amenity Fees</div>
                                </div>
                                <div class="card-body">
                                    <!-- alert messages -->
                                    <div id="fees_detailsamenityInsertNotOk" class="unsuccessalert">Amenity Fees Already Exists, Please Enter a Different Name!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsamenityInsertOk" class="successalert">Amenity Fees Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsamenityUpdateOk" class="successalert">Amenity Fees Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsamenityDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Amenity Fees!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsamenityInsertFailed" class="unsuccessalert">Amenity Fees Insert Failed!
                                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div id="fees_detailsamenityDeleteOk" class="successalert">Amenity Fees Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Particulars</label>
                                                    <input type="hidden" name="amenity_fee_id" id="amenity_fee_id" class="amenityField">
                                                    <input name="amenity_particulars" id="amenity_particulars" placeholder="Particulars" class="form-control amenityField" type="text">
                                                    <span class="text-danger" id="amenity_particularsCheck" style="display: none;">Enter Particulars</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input name="amenity_amount" id="amenity_amount" placeholder="Amount" class="form-control amenityField" type="number">
                                                    <span class="text-danger" id="amenity_amountCheck" style="display: none;">Enter Amount</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input name="amenity_date" id="amenity_date" placeholder="Amount" class="form-control amenityField" type="date">
                                                    <span class="text-danger" id="amenity_dateCheck" style="display: none;">Enter Date</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <button style="margin-top:20px;" type="button" name="Submit_Amenity" id="Submit_Amenity" class="btn btn-primary" value="submit" tabindex="10">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="updatedstockinfotableamenity"> </div>
                                </div>
                            </div>
                        </div>
                        <!--- Amenity Fees END-->

                    </div> <!-- card body END-->
                </div> <!-- Card END-->
            </div>
        </div>
    </form>
</div>