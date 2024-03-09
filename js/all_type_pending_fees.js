// Document is ready
$(document).ready(function () {

    // Get the current year
    var currentYear = new Date().getFullYear();

    // Generate a list of academic years for the dropdown
    var dropdown = document.getElementById('academic_year');
    for (var i = currentYear; i >= currentYear - 4; i--) {
    var option = document.createElement('option');
    option.value = i + '-' + (i + 1);
    option.text = i + '-' + (i + 1);
    dropdown.appendChild(option);
    }

    $('#standard').change(function(){
        let standardID = $(this).val();
        let academicYear = $('#academic_year').val();
        let medium = $('#medium').val();
        $.ajax({
            type: 'POST',
            data: {"standardID":standardID, "academicYear":academicYear, "medium": medium},
            url: 'reports/class_wise_report/getSectionList.php',
            dataType: 'json',
            success: function(response){
                $('#section').empty();
                $('#section').append("<option value='0'>Select option</option>");
                for (var i = 0; i < response.length; i++) {
                $('#section').append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                }
            }
        })
    });

    $('#pendingFees_table_view').click(function(){
        let academicyear = $('#academic_year').val();
        let stdMedium = $('#medium').val();
        let stdStandard = $('#standard').val();
        let stdSection = $('#section').val();

        if(academicyear !='0' && stdMedium !='0' && stdStandard != '0' && stdSection != '0'){
            $.ajax({
                type: 'POST',
                data: {"academicyear": academicyear, "stdMedium": stdMedium, "stdStandard": stdStandard, "stdSection": stdSection},
                url: 'reports/fees_details_report/allPendingFeesDetails.php',
                success: function(response){
                    $('#listCard').show();
                    $('#showStudentFeesPendingList').empty();
                    $('#showStudentFeesPendingList').html(response);
                }
            })
        }else{
            $('#showStudentFeesPendingList').empty();
            $('#listCard').hide();
            alert("Kindly select All Fields!");
        }
    });

}); //Document END//


$(function () {
  getStandardList(); //Getting standard list from database.
});

function getStandardList() { //Getting standard list from database.
    $.ajax({
    type: 'POST',
    data: {},
    url: 'ajaxFiles/getStandardList.php',
    dataType: 'json',
    success: function (response) {
        $('#standard').empty();
        $('#standard').append("<option value='0'>Select option</option>");
        for (var i = 0; i < response.length; i++) {
        $('#standard').append("<option value='" + response[i]['std_id'] + "'>" + response[i]['std'] + "</option>");
        }
    }
    })
}
