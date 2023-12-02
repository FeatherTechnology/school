
<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$StudentAdmissionList = $userObj->getAdmissionNoDetails($mysqli);

$id=0;
 if(isset($_POST['SubmitConductCertificate']) && $_POST['SubmitConductCertificate'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
        $id = $_POST['id'];     
        $updateCondutCertificateCreation = $userObj->updateCondutCertificateCreation($mysqli,$id,$userid);  
        ?>
         <script>location.href='<?php echo $HOSTPATH; ?>edit_conduct_certificate&msc=2';</script> 
        <?php   
    }
    else{   
        $addCondutCertificateCreation = $userObj->addCondutCertificateCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_conduct_certificate&msc=1';</script>
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
        $deleteCondutCertificateCreation = $userObj->deleteCondutCertificateCreation($mysqli,$del,$userid); 
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_conduct_certificate&msc=3';</script>
    <?php	
    }
    
    if(isset($_GET['upd']))
    {
    $idupd=$_GET['upd'];
    }
    $status =0;
    if($idupd>0)
    {
        $getCondutCertificateCreation = $userObj->getCondutCertificateCreation($mysqli,$idupd); 
        
        if (sizeof($getCondutCertificateCreation)>0) {
            for($ibranch=0;$ibranch<sizeof($getCondutCertificateCreation);$ibranch++)  {	
                $conduct_id                      = $getCondutCertificateCreation['conduct_id'];
                $admission_number                = $getCondutCertificateCreation['admission_number']; 
                $student_name                    = $getCondutCertificateCreation['student_name'];
                $school_name                     = $getCondutCertificateCreation['school_name']; 
                $school_address                     = $getCondutCertificateCreation['school_address']; 
                $studied_from                    = $getCondutCertificateCreation['studied_from']; 
                $studied_to                      = $getCondutCertificateCreation['studied_to']; 
                $academic_year_from              = $getCondutCertificateCreation['academic_year_from']; 
                $academic_year_to                = $getCondutCertificateCreation['academic_year_to']; 
                $place                           = $getCondutCertificateCreation['place']; 
                $student_character               = $getCondutCertificateCreation['student_character']; 
                $phone_number                    = $getCondutCertificateCreation['phone_number'];                 
            }
        }
    } 
?>
<style>
.select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
     border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
</style>
<link rel="stylesheet" href="css/select2.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">SM - Conduct Certicate</li>
    </ol>

    <a href="edit_conduct_certificate">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				
    <div class="main-container">
            <!--------form start-->
        <form id = "customer_master" name="customer_master" action="" method="post" enctype="multipart/form-data"> 
                <input type="hidden" class="form-control" value="<?php if(isset($conduct_id)) echo $conduct_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="">
                <div class="row gutters">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              
                        <div class="card">
                                <div class="card-header">Conduct Certificate</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Admission No :</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
                                            <select class="form-control" id="admission_number" name="admission_number"><option value="">Select a Student...</option>
                                            <?php if (sizeof($StudentAdmissionList)>0) { 
                                                for($j=0;$j<count($StudentAdmissionList);$j++) { ?>
                                                <option <?php if(isset($admission_number)) { if($StudentAdmissionList[$j]['student_id'] == $admission_number)  echo 'selected'; }  ?> value="<?php echo $StudentAdmissionList[$j]['student_id']; ?>">
                                                <?php echo $StudentAdmissionList[$j]['admission_number'];?></option>
                                                <?php }} ?>
                                            </select>
                                            </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Student Name :</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                <input type="text"  tabindex="2"  name="student_name" id="student_name" value="<?php if(isset($student_name)) echo $student_name ; ?>"  class="form-control">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">School Name:</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="3"  name="school_name" id="school_name" value="VIDHYA PARTHI NATIONAL ACADEMY"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">School Address :</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="4"  name="school_address" id="school_address" class="form-control" value="<?php if(isset($school_address)) echo $school_address ; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">School and studied from :</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="5"  name="studied_from" id="studied_from" class="form-control" value="<?php if(isset($studied_from)) echo $studied_from; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">School and studied To :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="6"  name="studied_to" id="studied_to" class="form-control" value="<?php if(isset($studied_to)) echo $studied_to; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Academic Year From :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="7"  name="academic_year_from" id="academic_year_from" class="form-control" value="<?php if(isset($academic_year_from)) echo $academic_year_from; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Acadmic Year To :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="8"  name="academic_year_to" id="academic_year_to" class="form-control" value="<?php if(isset($academic_year_to)) echo $academic_year_to; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Place :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="9"  name="place" id="place" class="form-control" value="<?php if(isset($place)) echo $place; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Character :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="10"  name="student_character" id="student_character" class="form-control" value="<?php if(isset($student_character)) echo $student_character; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Phone Number :</label>
                                                </div>
                                            </div>
                                             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <input type="text"  tabindex="11"  name="phone_number" id="phone_number" class="form-control" value="<?php if(isset($phone_number)) echo $phone_number; ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                                                <div class="text-right">
                                                    <div>
                                                        <button type="submit" tabindex="12" name="SubmitConductCertificate" id="SubmitConductCertificate" class="btn btn-primary" value="submit" tabindex="10">Submit</button>&nbsp;&nbsp;&nbsp;
                                                        <button type="reset"  tabindex="13" class="btn btn-outline-secondary">Cancel</button> 
                                                    </div> <br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<script>
    $('.select2').select2();

    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000);
</script>