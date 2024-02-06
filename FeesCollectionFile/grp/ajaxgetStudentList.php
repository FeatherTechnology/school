<?php
include '../../ajaxconfig.php';
@session_start();
if(isset($_SESSION["userid"])){
  $userid = $_SESSION["userid"];
$school_id = $_SESSION["school_id"];
$year_id = $_SESSION["academic_year"];

} 

// if(isset($_POST['standard'])){
//   $standard = $_POST['standard']; 

//   // make a query to fetch the section list
//   $sql = "SELECT section FROM student_creation WHERE standard = '$standard' AND school_id='$school_id' AND year_id ='$year_id'"; 
//   $result = mysqli_query($mysqli, $sql);

//   // check if there are any sections in the result
//   if (mysqli_num_rows($result) > 0) {
//     $section = array();
//     while($row = mysqli_fetch_assoc($result)) {
//       $section[] = $row['section'];
//     }
//     echo json_encode(array("section"=>$section));
//   } else {
//     echo json_encode(array("section"=>array()));
//   }
// } 


// listen for changes in the medium, standard, and section dropdowns
if(isset($_POST['medium']) && isset($_POST['standard'])){
    $medium = $_POST['medium'];
    $standard = $_POST['standard'];
  
    // make a query to fetch the section list
    $sql = "SELECT section FROM student_creation WHERE medium = '$medium' AND standard = '$standard' AND school_id='$school_id' GROUP BY section";
    $result = mysqli_query($mysqli, $sql);
  
    // check if there are any sections in the result
    if (mysqli_num_rows($result) > 0) {
      $section = array();
      while($row = mysqli_fetch_assoc($result)) {
        $section[] = $row['section'];
        
      }
      echo json_encode(array("section"=>$section));
    } else {
      echo json_encode(array("section"=>array()));
    }
  }
  
  
  if(isset($_POST['section'])){
    $section = $_POST['section'];
  
    // make a query to fetch the student names list
    $sql2 = "SELECT student_id, student_name FROM student_creation WHERE section = '$section' AND school_id='$school_id' AND year_id ='$year_id'";
    // print_r($sql2);
    $result2 = mysqli_query($mysqli, $sql2);
  
    // check if there are any students in the result
    if (mysqli_num_rows($result2) > 0) {
      $student_id = array();
      $student_name = array();
      while($row2 = mysqli_fetch_assoc($result2)) {
        $student_id[] = $row2['student_id'];
        $student_name[] = $row2['student_name'];
      }
      echo json_encode(array("student_id"=>$student_id, "student_name"=>$student_name));
    } else {
      echo json_encode(array("student_id"=>array(), "student_name"=>array()));
    }
  }


  if(isset($_POST['student_id']) && isset($_POST['student_name1'])){
    $student_id = $_POST['student_id'];
    $student_name1 = $_POST['student_name1'];
    
    if (!empty($student_id)) {
        $sql = "SELECT student_name FROM student_creation WHERE student_id = '$student_id' AND school_id='$school_id' AND year_id ='$year_id'";
    } elseif (!empty($student_name1)) {
        $sql = "SELECT student_name FROM student_creation WHERE student_id = '$student_name1' AND school_id='$school_id' AND year_id ='$year_id'";
    } else {
        // handle error case
    }

    // execute the query and return results
    $result = mysqli_query($mysqli, $sql);
  
    // check if there are any students in the result
    if (mysqli_num_rows($result) > 0) {
        $student_name2 = array();
        while($row = mysqli_fetch_assoc($result)) {
            $student_name2[] = $row['student_name'];
        }
        echo json_encode(array("student_name2"=>$student_name2));
    } else {
        echo json_encode(array("student_name2"=>array()));
    }
}

  
  // close the database connection
  mysqli_close($mysqli);

?>
