<?php
include 'ajaxconfig.php';

if(isset($_POST['type'])){
    $type = $_POST['type'];  
}
if(isset($_POST['standard'])){
    $standard = $_POST['standard'];  
}
if(isset($_POST['section'])){
    $section = $_POST['section']; 
}

if($type == '1'){
    $ctselect="SELECT sc.student_id, sc.admission_number, sc.student_name, sc.section, stdc.standard, sc.standard as std_id FROM student_creation sc JOIN standard_creation stdc ON sc.standard = stdc.standard_id WHERE sc.deleted_student = '0' AND sc.standard NOT IN (13, 19, 20, 21, 22, 23) "; 

}else{
    $ctselect="SELECT sc.student_id, sc.admission_number, sc.student_name, sc.section, stdc.standard, sc.standard as std_id FROM student_creation sc JOIN standard_creation stdc ON sc.standard = stdc.standard_id WHERE sc.standard ='".$standard."' AND sc.section ='".$section."' AND sc.deleted_student = '0' AND sc.standard NOT IN (13, 19, 20, 21, 22, 23)"; 

}
$ctresult=$mysqli->query($ctselect);
if($ctresult->num_rows>0){

while($ct=$ctresult->fetch_assoc()){
?>
<tr>
<td><input type="checkbox" class="checkbox" name="studentId[]" value="<?php echo $ct["student_id"];?>"></td>
<td><?php echo $ct["admission_number"]; ?></td>
<td><?php echo $ct["student_name"]; ?></td>
<td><input type="hidden" name="stdId[]" value="<?php echo $ct["std_id"];?>"><?php echo $ct["standard"]; ?></td>
<td><?php echo $ct["section"]; ?></td>
<td></td>
</tr>
<?php } } ?>