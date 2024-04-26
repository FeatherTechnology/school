$(document).ready(function(){

    // $('#birthday_comment').keyup(function() {
    //     $('#char_count').val(this.value.length)
    // });

    $("#birthday_details").on('click', '#smsTostudent', function () {
        let currentRow = $(this).closest('tr');
        let studentName = currentRow.find('td:eq(0)' ).text();
        let studentNo = currentRow.find('td:eq(2)' ).text();
        let  birthDayComment = 'Dear '+ studentName +', Happy Birthday! Wishing you a day filled with joy, laughter, and wonderful memories. May this year bring you success, happiness, and all that your heart desires. -VPHSS';
        let TemplateId	= '1707171402041076933'; //FROM DLT PORTAL.
        $.ajax({
            type: 'POST',
            data: {'content': birthDayComment, 'studentNo': studentNo, 'TemplateId': TemplateId},
            url: 'ajaxFiles/ajaxSendSMS.php',
            success: function (response) { 

                if(response.status == 200){
                    alert('Message sent Successfully. '+ response.message)
                }else{
                    alert("Message Failed!");
                }

            }, error: function (xhr, status, error) {
                console.log(error);
            }    
        })
    });

});

$(function(){
    getBirthdayDetails();
});


function getBirthdayDetails(){
    $.ajax({
        type: 'POST',
        data: {},
        url: 'SMSFiles/getBirthdayDetail.php',
        success:function(response){
            $('#birthday_info').empty();
            $('#birthday_info').html(response);

            $('#birthday_details').DataTable({
                'order': [0, 'desc'],
                'processing': true,
                'iDisplayLength': 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                // dom: 'lBfrtip',
                // buttons: [
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                //         }
                //     }
                // ],
            });
        }
    })
} 