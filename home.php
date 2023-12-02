<?php 
@session_start();

if(isset($_SESSION['fullname'])){
	$fullname  = $_SESSION['fullname'];
}
if(isset($_SESSION['userid'])){
	$userid  = $_SESSION['userid'];
}

$msc=0;
if(isset($_GET['msc']))
{
	$msc=$_GET['msc'];
}
$current_page = isset($_GET['page']) ? $_GET['page'] : null; 
define('iEditValid', 1);
include('api/main.php'); // Database Connection File   
?>

<!doctype html>
<html lang="en">

<!-- downlaod customer excel div -->
<div id="backup_customer" style="display:none"></div>
<div id="accountdata" style="display:none"></div>
<!-- end customer excel div -->

<!-- Important -->
<?php  if( $current_page != 'vendorcreation' and $current_page != 'auction_details' ) { ?>
<?php include "include/common/dashboardhead.php"?>
<?php  } ?>


<?php if($current_page == 'vendorcreation') { ?>
<?php include "include/common/dashboardfinancedatatablehead.php"?>
<?php } ?>
<?php if($current_page == 'auction_details') { ?>
<?php include "include/common/dashboardfinancedatatablehead.php"?>
<?php } ?>

<body>
	<!-- Page wrapper start -->
	<div class="page-wrapper">
		<?php 
		if($_SESSION['userid']=="")
		{
			echo "<script>location.href='index.php'</script>"; 
		}
		include "include/common/leftbar.php"?>

		<!-- Page content start  -->
		<div class="page-content">

			<!-- Header start -->
			<header class="header">
				<div class="toggle-btns">
					<a id="toggle-sidebar" href="#">
						<i class="icon-list"></i>
					</a>
					<a id="pin-sidebar" href="#">
						<i class="icon-list"></i>
					</a>
				</div>
				<h3 class="sec" style="color:#1b6aaa; text-align: center;">
					<span class="text-wrapper">
					<span class="line line1"></span>
					<span class="letters"><?php echo $_SESSION['school_name']."-"."(".$_SESSION['academic_year'].")";  ?></span>
					</span>
				</h3>
				
				<div class="header-items">
					<!-- Custom search start -->
					<div class="custom-search">
						<input type="text" class="search-query" placeholder="Search here ..." >
						<i class="icon-search1"></i>
					</div>
					<!-- Custom search end -->

					<!-- Header actions start -->
					<ul class="header-actions">
						<li class="dropdown"></li>
						<li class="dropdown">
							<a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
								<i class="icon-bell"></i>
								<span
									class="count-label"><?php //echo count($notification); // count($notificationmax); ?></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
								<div class="dropdown-menu-header">
									Notifications
								</div>
								<div class="customScroll5 quickscard">
									<ul class="header-notifications"></ul>
								</div>
							</div>
						</li>
						<li class="dropdown">
							<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
								aria-haspopup="true">
								<span class="user-name"><?php echo $fullname; ?></span>
								<span class="avatar">
									<img src="img/user22.png" alt="avatar">
									<span class="status busy"></span>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
								<div class="header-profile-actions">
									<div class="header-user-profile">
										<div class="header-user">
											<img src="img/user22.png" alt="Admin Template">
										</div>
										<h5><?php echo $fullname; ?></h5>
										<p><?php echo $fullname; ?></p>
									</div>
									<a href="#"><i class="icon-user1"></i> My Profile</a>
									<a href="logout.php"><i class="icon-log-out1"></i> Sign Out</a>
								</div>
							</div>
						</li>
					</ul>
					<!-- Header actions end -->
				</div>
			</header>
			<!-- Header end -->

			<!-- School Creation -->
			<?php if($current_page == 'school_creation') { ?>
			<?php include "include/templates/school_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_school_creation') { ?>
			<?php include "include/templates/edit_school_creation.php" ?>
			<?php } ?>

			<!-- syllabus Allocation -->
			<?php if($current_page == 'syllabus_allocation') { ?>
			<?php include "include/templates/syllabus_allocation.php" ?>
			<?php } ?>

			<?php if($current_page == 'syllabus_report') { ?>
			<?php include "include/templates/syllabus_report.php" ?>
			<?php } ?>
			<!-- Fees Master Model1-->	
			<?php if($current_page == 'fees_master_model1') { ?>
			<?php include "include/templates/fees_master_model1.php" ?>
			<?php } ?>
			<!-- Fees Master Model2 -->
			<?php if($current_page == 'fees_master_model2') { ?>
			<?php include "include/templates/fees_master_model2.php" ?>
			<?php } ?>
			<!-- Fees Master Model3 -->
			<?php if($current_page == 'fees_master_model3') { ?>
			<?php include "include/templates/fees_master_model3.php" ?>
			<?php } ?>
			<!-- Fees Master Model4 -->
			<?php if($current_page == 'fees_master_model4') { ?>
			<?php include "include/templates/fees_master_model4.php" ?>
			<?php } ?>
			<!-- Holiday Creation -->
			<?php if($current_page == 'holiday_creation') { ?>
			<?php include "include/templates/holiday_creation.php" ?>
			<?php } ?>
				<!-- Backup And Restore -->
			<?php if($current_page == 'backup_restore') { ?>
			<?php include "include/templates/backup_restore.php" ?>
			<?php } ?>
				<!-- Temp Student Admission -->
			<?php if($current_page == 'temp_admission_form') { ?>
			<?php include "include/templates/temp_admission_form.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_temp_admission_form') { ?>
			<?php include "include/templates/edit_temp_admission_form.php" ?>
			<?php } ?>
				<!-- student Creation -->
			<?php if($current_page == 'student_creation') { ?>
			<?php include "include/templates/student_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_student_creation') { ?>
			<?php include "include/templates/edit_student_creation.php" ?>
			<?php } ?>
				<!-- Delete Student -->
			<?php if($current_page == 'delete_student') { ?>
			<?php include "include/templates/delete_student.php" ?>
			<?php } ?>
				<!-- Student Rollback -->
			<?php if($current_page == 'student_rollback') { ?>
			<?php include "include/templates/student_rollback.php" ?>
			<?php } ?>
				<!-- Covid Concession -->
			<?php if($current_page == 'covid_concession') { ?>
			<?php include "include/templates/covid_concession.php" ?>
			<?php } ?>
				<!-- Fees Concession -->
			<?php if($current_page == 'fees_concession') { ?>
			<?php include "include/templates/fees_concession.php" ?>
			<?php } ?>

			<!-- Fees collection -->
			<?php if($current_page == 'fees_collection') { ?>
			<?php include "include/templates/fees_collection.php" ?>
			<?php } ?>

				<!-- Configuration Setting-->
			<?php if($current_page == 'configurationsetting') { ?>
			<?php include "include/templates/configurationsetting.php" ?>
			<?php } ?>

			<!-- Trust creation -->
			<?php if($current_page == 'trust_creation') { ?>
			<?php include "include/templates/trust_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_trust_creation') { ?>
			<?php include "include/templates/edit_trust_creation.php" ?>
			<?php } ?>
			<!-- Item Creation -->
			<?php if($current_page == 'item_creation') { ?>
			<?php include "include/templates/item_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_item_creation') { ?>
			<?php include "include/templates/edit_item_creation.php" ?>
			<?php } ?>
			<!-- Area Creation -->
			<?php if($current_page == 'area_creation') { ?>
			<?php include "include/templates/area_creation.php" ?>
			<?php } ?>

			<!-- staff Creation -->
			<?php if($current_page == 'staff_creation') { ?>
			<?php include "include/templates/staff_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_staff_creation') { ?>
			<?php include "include/templates/edit_staff_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'pay_fees') { ?>
			<?php include "include/templates/pay_fees.php" ?>
			<?php } ?>

			<?php if($current_page == 'transport_fees') { ?>
			<?php include "include/templates/transport_fees.php" ?>
			<?php } ?>

			<?php if($current_page == 'last_year_fees') { ?>
			<?php include "include/templates/last_year_fees.php" ?>
			<?php } ?>

			<?php if($current_page == 'dashboard') { ?>
			<?php include "include/templates/dashboard.php" ?>
			<?php } ?>

			<?php if($current_page == 'transfer_certificate') { ?>
			<?php include "include/templates/transfer_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_transfer_certificate') { ?>
			<?php include "include/templates/edit_transfer_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'conduct_certificate') { ?>
			<?php include "include/templates/conduct_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_conduct_certificate') { ?>
			<?php include "include/templates/edit_conduct_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'study_certificate') { ?>
			<?php include "include/templates/study_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'bonafide_certificate') { ?>
			<?php include "include/templates/bonafide_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'course_completion') { ?>
			<?php include "include/templates/course_completion.php" ?>
			<?php } ?>

			<?php if($current_page == 'marksheet_certificate') { ?>
			<?php include "include/templates/marksheet_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'transport_fees_master') { ?>
			<?php include "include/templates/transport_fees_master.php" ?>
			<?php } ?>

			<?php if($current_page == 'last_year_fees_master') { ?>
			<?php include "include/templates/last_year_fees_master.php" ?>
			<?php } ?>
			
			<?php if($current_page == 'last_year_fees_pay') { ?>
			<?php include "include/templates/last_year_fees_pay.php" ?>
			<?php } ?>

			<?php if($current_page == 'bonafide_community_certificate') { ?>
			<?php include "include/templates/bonafide_community_certificate.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_student_bonafide') { ?>
			<?php include "include/templates/edit_student_bonafide.php" ?>
			<?php } ?>

			<?php if($current_page == 'purchase_order') { ?>
			<?php include "include/templates/purchase_order.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_purchase_order') { ?>
			<?php include "include/templates/edit_purchase_order.php" ?>
			<?php } ?>

			<?php if($current_page == 'stock_issuance') { ?>
			<?php include "include/templates/stock_issuance.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_stock_issuance') { ?>
			<?php include "include/templates/edit_stock_issuance.php" ?>
			<?php } ?>

			<?php if($current_page == 'stockstatement') { ?>
			<?php include "include/templates/stockstatement.php" ?>
			<?php } ?>


			
		</div>
		<!-- Page content end -->

	</div>
	<!-- Page wrapper end -->

	<!-- Important -->
	<!-- This the important section for download excel file and script adding with our screen -->
	<?php if( $current_page != 'vendorcreation') { ?>
	<?php include "include/common/dashboardfooter.php"?>
	<?php } ?>

	<?php
		if($current_page == 'vendorcreation') { ?>
	<?php include "include/common/dashboardfinancedatatablefooter.php" ?>
	<?php } ?>
	
	
</body>
</html>