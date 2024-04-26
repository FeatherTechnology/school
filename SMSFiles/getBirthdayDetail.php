<?php 
include "../ajaxconfig.php";
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
    $school_id = $_SESSION["school_id"];
    $academic_year = $_SESSION["academic_year"];
}
$getBirthdayQry = $connect->query("SELECT
`student_id`,
`student_name`,
`date_of_birth`,
`sms_sent_no`
FROM
`student_creation`
WHERE
DATE_FORMAT(`date_of_birth`,'%m-%d') BETWEEN DATE_FORMAT(CURRENT_DATE(),'%m-%d') and DATE_FORMAT(CURRENT_DATE()+ INTERVAL 7 DAY,'%m-%d')
AND school_id ='$school_id' AND year_id ='$academic_year' ");
$i=0;
    while($getBirthdayDetails = $getBirthdayQry->fetchObject()){
?>
    <tr>
        <td name="student_name<?php echo $i;?>"><?php echo $getBirthdayDetails->student_name; ?></td>
        <td><?php echo date('d-m-Y', strtotime($getBirthdayDetails->date_of_birth)); ?></td>
        <td><?php echo $getBirthdayDetails->sms_sent_no; ?></td>
        <td><button type="submit" id="submit_tamilbirthday_wishes" name="submit_tamilbirthday_wishes" value="Send SMS" class="btn btn-primary">Send SMS</button>
        <input type="hidden" name="linenum" value="<?php echo $i; ?>">
        </td>
    </tr>
<?php $i++; } ?>