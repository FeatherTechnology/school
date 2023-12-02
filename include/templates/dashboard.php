<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Dashboard</li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
	<!-- Row start -->
	<form action="" method="post" name="vendorcreation" id="vendorcreation" >
		<div class="row gutters">
		<!-- General Info -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
                    <div class="card-header">Today's Events</div>
					<div class="card-body row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table id="concession_table_info" class="table custom-table">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Student Name</th>
                                                <th>Academic Year</th>
                                                <th>Standard</th>
                                                <th>Section</th>
                                                <th>School Fees</th>
                                                <th>Concession Amount</th>
                                                <th>Balance Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</form>
</div>
