<?php
@session_start();
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $year_id = $_SESSION["academic_year"];
    $academic_year = $_SESSION["academic_year"];
}

$StudentList = $userObj->getStudentList($mysqli, $school_id, $year_id);
?><!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Student Profile Report </li>
    </ol>
</div>
<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="student_profile_form" name="student_profile_form" method="post" enctype="multipart/form-data">
        <!-- card start -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <select class="form-control select2" id="student_name1" name="student_name1"> <!--onchange="paidFees()" -->
                                <option value="0">Select a Student...</option>
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

                    <br><br><br><br><br><br>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12"></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="button" name="student_profile_view_btn" id="student_profile_view_btn" class="btn btn-primary" value="View" tabindex="7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- card END -->

        <div class="card" id="listCard" style="display: none;">
            <div class="card-body">
                <div id="showstudentProfileReportList"></div>
            </div>
        </div>
    </form>
    <!--form END-->
</div>
<!-- Main container END -->