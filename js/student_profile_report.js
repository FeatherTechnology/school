// Document is ready
$(document).ready(function () {


$('#student_profile_view_btn').click(function () {
    let student_id = $('#student_name1').val();
    console.log('Student ID:', student_id);

    if (student_id && student_id !== '0') {
        $.ajax({
            type: 'POST',
            url: 'reports/fees_details_report/studentProfileReport.php',
            data: { "student_id": student_id },
            success: function (response) {
                $('#listCard').show();
                $('#showstudentProfileReportList').empty().html(response);
            }
        });
    } else {
        $('#showstudentProfileReportList').empty();
        $('#listCard').hide();
        alert("Kindly select student Fields!");
    }
});


}); //Document END//
