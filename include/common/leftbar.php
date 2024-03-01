<style>
	body {
	font-family: "Lato", sans-serif;
	}

	/* Fixed sidenav, full height */
	.sidenav {
	height: 100%;
	width: 200px;
	position: fixed;
	z-index: 1;
	top: 0;
	left: 0;
	background-color: #111;
	overflow-x: hidden;
	padding-top: 20px;
	}

	/* Style the sidenav links and the dropdown button */
	.sidenav a, .dropdown-btn1 {
	padding: 6px 8px 6px 16px;
	text-decoration: none;
	
	color: #818181;
	display: block;
	border: none;
	background: none;
	width: 100%;
	text-align: left;
	cursor: pointer;
	outline: none;
	}

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn1:hover {
	color: #5090c0;
	}

	.sidenav a, .dropdown-btn {
	padding: 6px 8px 6px 16px;
	text-decoration: none;
	
	color: #818181;
	display: block;
	border: none;
	background: none;
	width: 100%;
	text-align: left;
	cursor: pointer;
	outline: none;
	}

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn:hover {
	color: #5090c0;
	}

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn1:hover {
	color: #5090c0;
	}
	/* Main content */
	.main {
	margin-left: 200px; /* Same as the width of the sidenav */
	
	padding: 0px 10px;
	}

	/* Add an active class to the active dropdown button */
	.active {
	
	color: white;
	}

	/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
	.dropdown-container {
	display: none;

	padding-left: 8px;
	}

	.dropdown-container1 {
	display: none;

	padding-left: 8px;
	}
	/* Optional: Style the caret down icon */
	.fa-caret-down {
	float: right;
	padding-right: 8px;
	}

	/* Some media queries for responsiveness */
	@media screen and (max-height: 450px) {
	.sidenav {padding-top: 15px;}
	.sidenav a {font-size: 18px;}
	}
</style>
<?php
$billmodel = $userObj->getbilltype($mysqli, $userid);?>
<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper" style="background-color:#1b6aaa;">
	<!-- Sidebar brand start  -->
	<!-- <div class="sidebar-brand" style="background-color: #1b6aaa">
		<a href="javascript:void(0)" class="logo">
			<h2 class="ml-4" style="color: white">School</h2>
			
		</a>
	</div> -->
	<div class="sidebar-menu sidebar-brand" style="background-color: #1b6aaa">
			<ul>
                <li class="sidebar">
					<a href="edit_school_creation">
						<i class="icon-list"></i>
						<span class="menu-text"><h2 class="ml-4" style="color: white">School</h2></span>
					</a>
				
				</li>
            </ul>
   </div>
	<div class="sidebar-content">
	<!-- sidebar menu start -->
		<div class="sidebar-menu">
			<ul>	
				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-record_voice_over"></i>
						<span class="menu-text">Administration</span>
					</a>
					<div class="sidebar-submenu">
						<ul>	
							<li>									
								<a href="dashboard"><i class="icon-record_voice_over"></i>Dashboard</a>
							</li>
							<li>
								<a href="edit_trust_creation"><i class="icon-user"></i>Trust Creation</a>
							</li>			
							<li>									
								<a href="edit_school_creation"><i class="icon-school"></i>School Update</a>
							</li>
							
							<li>
								<?php if(isset($billmodel)){
								if($billmodel == "model1"){ ?>
									<a href="fees_master_model1"><i><span class="icon-attach_money"></span></i>Fees Master</a>
								<?php }else if($billmodel == "model2"){ ?>
									<a href="fees_master_model2"><i><span class="icon-attach_money"></span></i>Fees Master</a>
								<?php }
								else if($billmodel == "model3"){ ?>
									<a href="fees_master_model3"><i><span class="icon-attach_money"></span></i>Fees Master</a>
								<?php }
								else if($billmodel == "model4"){ ?>
									<a href="fees_master_model3"><i><span class="icon-attach_money"></span></i>Fees Master</a>
								<?php }
								} ?>
							</li>
										
							
							<li>									
								<a href="holiday_creation"><i><span class="icon-near_me"></span></i>Holiday Info
								</a>
							</li>
							<!-- <li>									
								<a href="finance_creation"><i><span class="icon-attach_money"></span></i>Finance Creation
								</a>
							</li> -->
							<!-- <li>
								<a href="configurationsetting"><i class="icon-cog"></i>Configuration Setting</a>
							</li>
							<li>									
								<a href="backup_restore"><i><span class="icon-database"></span></i>Backup & Restore
								</a>
							</li> -->
						</ul>
					</div>
				</li>

				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-edit1"></i>
						<span class="menu-text">Master</span>
					</a>
					<div class="sidebar-submenu">
						<ul>
							<li>
								<a href="area_creation"><i><span class="icon-call_split"></span></i>Area Master</a>
							</li>
							
							<li class="sidebar-dropdown1">
								<a href="javascript:void(0)">
									<i class="icon-book"></i>
									<span class="menu-text" >Syllabus</span>
								</a>
								<div class="sidebar-submenu1">
									<ul>
										<li>
											<a href="syllabus_allocation"><i><span class="icon-pie_chart_outlined"></span></i>Allocation
											</a>	
										</li>
										<li>
											<a href="syllabus_report"><i><span class="icon-bug_report"></span></i>Allocation View
											</a>	
										</li>
									</ul>
								</div>	
							</li>
							
						</ul>
					</div>
				</li>

				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-user"></i>
						<span class="menu-text"> Staff </span>
					</a>
					<div class="sidebar-submenu">
						<ul>
							<li>
								<a href="edit_staff_creation"><i class="icon-add-user"></i>Staff Creation</a>
							</li>
						</ul>
					</div>
				</li>

			
				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-user"></i>
						<span class="menu-text">Student</span>
					</a>
					<div class="sidebar-submenu">
						<ul>
							<li>
								<a href="edit_temp_admission_form"><i class="icon-file"></i>Temp.Admission Form</a>
							</li>
							<li>
								<a href="edit_student_creation"><i class="icon-add-user"></i>Student Creation</a>
							</li>
							
							<li>
								<a href="student_rollback"><i class="icon-cw"></i>Student Roll Back</a>
							</li>
							<li>
								<a href="delete_student"><i class="icon-trash"></i>Delete Student</a>
							</li>
							<li class="sidebar-dropdown1">
								<a href="javascript:void(0)">
									<i class=""><span class="icon-cpu"></span></i>
									<span class="menu-text" >Certificates - 6</span>
								</a>
								<div class="sidebar-submenu1">
									<ul>
										<li>									
											<a href="transfer_certificate"><i><span class="icon-file-text"></span></i>Transfer</a>
										</li>
										<li>									
											<a href="study_certificate"><i><span class="icon-file-text"></span></i>Study</a>
										</li>
										<li>									
											<a href="marksheet_certificate"><i><span class="icon-file-text"></span></i>Mark</a>
										</li>
										<li>									
											<a href="edit_student_bonafide"><i><span class="icon-file-text"></span></i>Bonafide</a>
										</li>
										<li>									
											<a href="conduct_certificate"><i><span class="icon-file-text"></span></i>Conduct</a>
										</li>
										<li>									
											<a href="course_completion"><i><span class="icon-file-text"></span></i>Course Compeletion</a>
										</li>
									</ul>
								</div>	
							</li>
						</ul>
					</div>
				</li>
				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-attach_money"></i>
						<span class="menu-text"> Collection </span>
					</a>
					<div class="sidebar-submenu">
						<ul>
						<li>
								<a href="fees_concession"><i class="icon-attach_money"></i>Fees Concession</a>
							</li>
						<li>
								<a href="fees_collection"><i class="icon-file"></i>Fees Collection</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-truck"></i>
						<span class="menu-text"> Inventory </span>
					</a>
					<div class="sidebar-submenu">
						<ul>
							<li>
								<a href="item_creation"><i><span class="icon-filter_tilt_shift"></span></i>Item Master</a>
							</li>
							<li>
								<a href="purchase_order"><i><span class="icon-filter_tilt_shift"></span></i>Stock Inward Entry</a>
							</li>
							<li>
								<a href="stock_issuance"><i><span class="icon-filter_tilt_shift"></span></i>Stock Issuance</a>
							</li>
							<li>
								<a href="stockstatement"><i><span class="icon-filter_tilt_shift"></span></i>Stock Movement</a>
							</li>
							
						</ul>
					</div>
				</li>
				<li class="sidebar-dropdown">
					<a href="javascript:void(0)">
						<i class="icon-list"></i>
						<span class="menu-text"> Reporting </span>
					</a>
					<div class="sidebar-submenu">
						<ul>
						<li>
								<a href="student_caste_report"><i class="icon-file"></i>Student List</a>
							</li>
						<li>
								<a href="fees_collection"><i class="icon-attach_money"></i>Fees Collection</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		<!-- sidebar menu end -->
		</div>
	</div>
</nav>
<!-- Sidebar wrapper end -->

<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;
	for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
				dropdownContent.style.display = "block";
			}
		});
	}

	var dropdown1 = document.getElementsByClassName("dropdown-btn1");
	var i;
	for (i = 0; i < dropdown1.length; i++) {
		dropdown1[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
				dropdownContent.style.display = "block";
			}
		});
	}
</script>
