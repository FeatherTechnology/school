$(document).ready(function(){

    // $('#birthday_comment').keyup(function() {
    //     $('#char_count').val(this.value.length)
    // });

    // $("#tamil_birthday_details").on('click', '#smsTostudent', function () {
    //     let currentRow = $(this).closest('tr');
    //     let studentName = currentRow.find('td:eq(0)' ).text();
    //     let studentNo = currentRow.find('td:eq(2)' ).text();
    //     let  birthDayComment = 'அன்புள்ள '+ studentName +', இனிய பிறந்தநாள் வாழ்த்துக்கள்! மகிழ்ச்சி, சிரிப்பு மற்றும் அற்புதமான நினைவுகள் நிறைந்த நாளாக அமைய வாழ்த்துக்கள். இந்த ஆண்டு உங்களுக்கு வெற்றி, மகிழ்ச்சி மற்றும் உங்கள் இதயம் விரும்பும் அனைத்தையும் தரட்டும். -வித்யா பார்த்தி மேல்நிலைப்பள்ளி திண்டுக்கல்.-VPHSS';
    //     let TemplateId	= '1707171402058885308'; //FROM DLT PORTAL.
    //     $.ajax({
    //         type: 'POST',
    //         data: {'content': birthDayComment, 'studentNo': studentNo, 'TemplateId': TemplateId},
    //         url: 'ajaxFiles/ajaxSendSMS.php',
    //         success: function (response) { 
    //             if(response.status == 200){
    //                 alert('Message sent Successfully. '+ response.message)
    //             }else{
    //                 alert("Message Failed!");
    //             }

    //         }, error: function (xhr, status, error) {
    //             console.log(error);
    //         }    
    //     })
    // });

//     $("#tamil_birthday_details").on('click', '#smsTostudent', function () {
//         event.preventDefault();
// console.log('aasassa')
//         $.ajax({
//             url: 'include/templates/edit_tamil_birthday_wishes.php',
//             type: 'POST',
//             data: {
//                 submit_tamilbirthday_wishes: 'submit_tamilbirthday_wishes', // Pass the function name as data
//             },
//             success: function(response) {
//                 // Handle the response from the server
//                 console.log('PHP function called successfully.');
//                 // You can perform any additional actions here after the PHP function is executed
//             },
//             error: function(xhr, status, error) {
//                 // Handle errors
//                 console.error('Error calling PHP function.');
//             }
//         });
//     });
    

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

            $('#tamil_birthday_details').DataTable({
                'order': [0,'desc'],
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