<?php
include "../ajaxconfig.php";
    //Student Roll Back form
    $student_id = [];
    if(isset($_POST['student_id'])){
        $student_id = $_POST['student_id'];
    }
    $standard_id = [];
    if(isset($_POST['standard_id'])){
        $standard_id = $_POST['standard_id'];
    }

    $particular_std_id = array('14','15','16','17','18','19','20','21','22','23');
    for($i=0; $i < count($student_id); $i++){

        if(!in_array($standard_id[$i], $particular_std_id)){ //these under 9 std. so jst add 1 to the id and update.
            $next_std_id = intval($standard_id[$i]) + 1;
            $updateStudentCreation = $connect->query("UPDATE `student_creation` SET `standard`='$next_std_id' WHERE `student_id`='$student_id[$i]'");
            
        }else{ //these are 11th std so  no need to check next standard id.
            
            if($standard_id[$i] == '14'){ //Maths_biology
                $next_std_id = '19';
            }else if($standard_id[$i] == '15'){//maths_computerscience
                $next_std_id = '20';
            }else if($standard_id[$i] == '16'){//biology_computerscience
                $next_std_id = '21';
            }else if($standard_id[$i] == '17'){//commerce_computerscience
                $next_std_id = '22';
            }else if($standard_id[$i] == '18'){//all
                $next_std_id = '23';
            }

            $updateStudentCreation = $connect->query("UPDATE `student_creation` SET `standard`='$next_std_id' WHERE `student_id`='$student_id[$i]'");

        }
    }

    echo  json_encode(['status'=>'success', 'data'=>$updateStudentCreation]);

//Student Roll Back form END//

?>