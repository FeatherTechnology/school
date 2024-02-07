<?php
@session_start();
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
}
?>
<style>
    .select2-container .select2-selection--single {
        height: 34px !important;
    }

    .select2-container--default .select2-selection--single {
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
    <!--form start-->
    <form id="student_rollback_form" name="student_rollback_form" action="" method="post" enctype="multipart/form-data">
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
                                            <select class="form-control select2" id="standard" name="standard" tabindex="1">
                                                <option value="">Select a Standard...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select class="form-control select2" id="section" name="section" tabindex="2">
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
                            <tbody id="studentRollBackList">
                            </tbody>
                        </table>
                        <!-- Second Table for Unselected Data -->
                        <table class="table custom-table" id="unselected_table" style="display:none">
                            <thead>
                                <tr>
                                    <th>Admission No</th>
                                    <th>Name</th>
                                    <th>Standard Name</th>
                                    <th>Section Name</th>
                                </tr>
                            </thead>
                            <tbody id="unselected_tbody">
                            </tbody>
                        </table>
                        <!-- Unselected data rows will be dynamically populated -->
                    </div>

                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="button" name="submitFailList" id="submitFailList" class="btn btn-danger" value="Submit" tabindex="3">Show Fail List</button>
                            <button type="submit" name="submitschool_creation" id="submitschool_creation" class="btn btn-success" value="Submit" tabindex="4">Submit</button>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </form>
</div>