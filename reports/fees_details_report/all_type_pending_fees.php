<style>
    #show_student_allPending_list th {
        text-align: left !important;
        white-space: nowrap;
    }

    #show_student_allPending_list td {
        white-space: nowrap;
    }

    .text-right {
        text-align: right !important;
    }

  #printArea {
    display: block;
    padding: 10px;
    font-size: 25px !important;
}

.reminder-card {
    width: 100%;
    padding: 10px 0;
    box-sizing: border-box;
    font-size: 25px !important;
    line-height: 1.6;
    page-break-inside: avoid;
    break-inside: avoid;
    border: none;
}

.reminder-card hr {
    border: 1px solid #000;
    margin-top: 20px;
}

@media print {
    body.reminder-print * {
        visibility: hidden;
    }

    body.reminder-print #printArea,
    body.reminder-print #printArea * {
        visibility: visible;
    }

    body.reminder-print #printArea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: block;
        font-size: 30px !important;
    }

    body.reminder-print .reminder-card {
        width: 100%;
        padding: 0 0 20px 0;
        margin: 0 0 20px 0;
        border: none;
        page-break-after: auto; /* allow continuous page */
    }

    body.reminder-print .reminder-card h4 {
        font-size: 30px !important;
        font-weight: bold;
        margin-bottom: 10px;
    }

}

</style>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - All Type Pending Fees Details Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="student_all_pending_fee_form" name="student_all_pending_fee_form" method="post" enctype="multipart/form-data">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Academic Year</label>
                                    <select type="text" class="form-control" id="academic_year" name="academic_year" tabindex="1">
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Medium</label>
                                    <select class="form-control" id="medium" name="medium" tabindex="2">
                                        <option value="0">Select Medium</option>
                                        <option value="1" <?php if (isset($medium)) {
                                                                if ($medium == "1") echo 'selected';
                                                            } ?>>Tamil</option>
                                        <option value="2" <?php if (isset($medium)) {
                                                                if ($medium == "2") echo 'selected';
                                                            } ?>>English</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Standard List</label>
                                    <select class="form-control" id="standard" name="standard" tabindex="3">
                                        <option value="0">Select a Standard...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select class="form-control" id="section" name="section" tabindex="4">
                                        <option value="0">Select Section</option>
                                    </select>
                                </div>
                            </div>
                            <br><br><br><br><br><br>

                            <div class="col-xl-9 col-lg-8 col-md-6 col-sm-6 col-12"></div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                            <div class="form-group">
                                <input type="button" name="pendingFees_table_view" id="pendingFees_table_view" class="btn btn-primary" value="View" tabindex="5">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="listCard" style="display: none;">
            <div class="card-body">
                <div class="row ">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 rem_type" style="display:none;">
                        <div class="form-group">
                            <label>Fee Reminder Type</label>
                            <select class="form-control" id="fee_type" name="fee_type" tabindex="4">
                                <option value="0">Select Fee Reminder Type</option>
                                <option value="1">Last Year</option>
                                <option value="2">Admission Fees</option>
                                <option value="3">Uniform Fees</option>
                                <option value="4">Book Fees</option>
                                <option value="5">Group Fees - I Term</option>
                                <option value="6">Group Fees - II Term</option>
                                <option value="7">Group Fees - III Term</option>
                                <option value="8">Transport - I Term</option>
                                <option value="9">Transport - II Term</option>
                                <option value="10">Transport - III Term</option>
                                <option value="11">ECA</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" id="reminderPrint" style="margin-top: 18px; display:none;">
                        <button id="printButton" type="button" class="btn btn-primary">
                            Print Fee Reminder
                        </button>
                    </div>
                </div>
                <br><br>
                <div id="showStudentFeesPendingList"></div>
            </div>
        </div>
        <div id="printArea" style="display:none;"></div>
    </form>
</div>