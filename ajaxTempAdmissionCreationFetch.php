<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["school_id"])){
    $school_id = $_SESSION["school_id"];
 }
 if(isset($_SESSION["academic_year"])){
    $year_id = $_SESSION["academic_year"];
 }
$column = array(
    'temp_admission_id',
    'temp_student_name',
    'temp_standard',
    'temp_gender',
    'temp_flat_no',
    'temp_street',
    'temp_area',
    'temp_district',

    'status'
);

$query = "SELECT * FROM temp_admission_student WHERE  school_id='$school_id' AND year_id='$year_id'";

if($_POST['search']!="");
{
    if (isset($_POST['search'])) {

        if($_POST['search']=="Active")
        {
            $query .="and status=0 "; 
        }
        else if($_POST['search']=="Inactive")
        {
            $query .="and status=1 ";
        }

        else{	
            $query .= "
            
           AND temp_student_name LIKE  '%".$_POST['search']."%'
           AND temp_standard LIKE '%".$_POST['search']."%'
           AND temp_gender LIKE '%".$_POST['search']."%'
           AND temp_flat_no LIKE '%".$_POST['search']."%'
           AND temp_street LIKE '%".$_POST['search']."%'
           AND temp_area LIKE '%".$_POST['search']."%'
           AND temp_district LIKE '%".$_POST['search']."%'
           AND status LIKE '%".$_POST['search']."%' ";
        }
    }
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $connect->prepare($query . $query1);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

$sno = 1;
foreach ($result as $row) {
    $sub_array   = array();
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }
    
    $sub_array[] = $row['temp_student_name'];
    $sub_array[] = $row['temp_standard'];
    $sub_array[] = $row['temp_gender'];
    $sub_array[] = $row['temp_flat_no'] ." ". " " .$row['temp_street'] ." ". " ".$row['temp_street']." ". " ".$row['temp_area']." ". " ".$row['temp_district'];
    
    // $status      = $row['status'];
    // if($status == 1)
	// {
	// $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	// }
	// else
	// {
    // $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	// }
	$id   = $row['temp_admission_id'];
	
	$action="<a href='temp_admission_form&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='temp_admission_form&del=$id' title='Delete details' class='delete_temp_student'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    if(isset($_SESSION["userid"])){
        $userid = $_SESSION["userid"];
        $school_id = $_SESSION["school_id"];
        $year_id = $_SESSION["academic_year"];
    }

    $query     = "SELECT * FROM temp_admission_student WHERE  school_id='$school_id' AND year_id='$year_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data
);

echo json_encode($output);
?>