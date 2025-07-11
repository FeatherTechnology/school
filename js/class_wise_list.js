// Document is ready
$(document).ready(function () {
    
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
                $('#section').append("<option value='0'>Select section</option>");
                 $('#section').append("<option value='all'>All</option>"); // Append "All" option here
                for (var i = 0; i < response.length; i++) {
                $('#section').append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                }
            }
        })
    });

    $('#table_view').click(function(){
        let academicyear = $('#academic_year').val();
        let stdMedium = $('#medium').val();
        let stdStandard = $('#standard').val();
        let stdSection = $('#section').val();

        if(academicyear !='0' && stdMedium !='0' && stdStandard !='0' && stdSection !='0'){
            $.ajax({
                type: 'POST',
                data: {"academicyear": academicyear, "stdMedium": stdMedium, "stdStandard": stdStandard, "stdSection": stdSection},
                url: 'reports/class_wise_report/getClassListReport.php',
                success: function(response){
                    $('#listCard').show();
                    $('#showStudentClassList').empty();
                    $('#showStudentClassList').html(response);
                }
            })
        }else{
            $('#showStudentClassList').empty();
            $('#listCard').hide();
            alert("Kindly select All Fields!");
        }
    });

}); //Document END//


$(function () {
  getStandardList(); //Getting standard list from database.
  getAcademicYearList(); //Get  Academic Year List.
});

function getStandardList() { //Getting standard list from database.
    $.ajax({
    type: 'POST',
    data: {},
    url: 'ajaxFiles/getStandardList.php',
    dataType: 'json',
    success: function (response) {
        $('#standard').empty();
        $('#standard').append("<option value='0'>Select Standard</option>");
          $('#standard').append("<option value='all'>All</option>"); // Append "All" option here
        for (var i = 0; i < response.length; i++) {
        $('#standard').append("<option value='" + response[i]['std_id'] + "'>" + response[i]['std'] + "</option>");
        }
    }
    })
}

function getAcademicYearList(){ //Getting academic_year list from database.
    $.ajax({
        type: 'POST',
        data: {},
        url: 'ajaxFiles/getAcademicYearList.php',
        dataType: 'json',
        success:function(response){
            $('#academic_year').empty();
            $('#academic_year').append("<option value=''>Select Academic Year</option>");
            for(var i=0; i <response.length; i++){
                
                $('#academic_year').append("<option value='" +response[i]['academicyear']+ "'>" +response[i]['academicyear']+ "</option>");
            }
        }
    })
}