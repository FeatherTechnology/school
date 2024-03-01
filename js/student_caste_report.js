$(document).ready(function(){
    // $('.hidebc').hide();
    // $('.hidembc').hide();
    // $('.hidesc').hide();
    // $('.hidest').hide();
    // $('.hideobc').hide();
    // $('.hidednc').hide();
    // $('.hidebcm').hide();
}); //Document END////

$(function(){
    getStudentCasteDetails();
});


function getStudentCasteDetails(){
    $.ajax({
        type: 'POST',
        data: {},
        url: 'reports/caste_report/getStudentCasteDetails.php',
        success: function(){

        }
    })
};