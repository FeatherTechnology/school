<?php
include 'ajaxconfig.php';

if(isset($_POST['standard'])){
    $standard = $_POST['standard'];  
}
if(isset($_POST['section'])){
    $section = $_POST['section']; 
}
 
?>
        <table id="student_rollback_info" class="table custom-table">
            <thead>
                <tr>
                <th>Pass / Fail<br><br><input type="checkbox" id="select-all"></th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Standard Name</th>
                <th>Section Name</th>
                <th>Pass / Fail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ctselect="SELECT * FROM student_creation WHERE standard ='".$standard."' AND section ='".$section."' "; 
                $ctresult=$mysqli->query($ctselect);
                if($ctresult->num_rows>0){
        
                while($ct=$ctresult->fetch_assoc()){
                ?>
                <tr>
                <td><input type="checkbox" class="checkbox" value="1"></td>
                <td><?php if(isset($ct["admission_number"])){ echo $ct["admission_number"]; }?></td>
                <td><?php if(isset($ct["student_name"])){ echo $ct["student_name"]; }?></td>
                <td><?php if(isset($ct["standard"])){ echo $ct["standard"]; }?></td>
                <td><?php if(isset($ct["section"])){ echo $ct["section"]; }?></td>
                <td></td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
        <!-- Second Table for Unselected Data -->
        <table id="unselected_table" class="table custom-table" style="display:none">
            <thead>
                <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Standard Name</th>
                <th>Section Name</th>
                </tr>
            </thead>
            <tbody>
                <!-- Unselected data rows will be dynamically populated -->
            </tbody>
        </table>

    
</table>

