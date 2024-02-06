$(document).ready(function(){

    $(document).on("click", ".rejectpo", function (){ //to set student id when delete modal box open.
        var id = $(this).data('id');
        $("#student_id").val(id);
    });

    // Submit form event
    $('#deleted_student__creation').submit(function (event) {
    // Prevent default form submission
    event.preventDefault();
    // Get form data
    var formData = $(this).serialize();
    // AJAX request
    $.ajax({
        url: 'studentFile/ajaxInsertReason.php', // Replace with your AJAX page URL
        type: 'POST',
        data: formData,
        success: function (response) {
            var pending = response.includes("pending");
            var deleted = response.includes("successfully");
            var notfound = response.includes("found");
            if(pending){
                alert('Student cannot be deleted. Student fees are pending for the academic year.');
                
            }else if(deleted){
                alert('Student deleted successfully.');

            }else if(notfound){
                alert('Student name not found. Please make sure the student has paid fees.');

            }else{
                alert(response);
            }
            
        // Redirect to the "edit_stduent_creation" page
        window.location.href = 'edit_student_creation';
        },
        error: function (xhr, status, error) {
        // Handle error if the AJAX request fails
        console.log(error);
        }
    });
    });


    //Modal Box for Attachment.
    $(document).on('click','.attachmentFiles', function(){
        clearAllfieldInModal();
        
        var studID=$(this).attr('data-id');
        var admissionNo=$(this).attr('data-no');
        $('#admissionno').val(admissionNo);
        $('#studentid').val(studID);
        resetAttachmentTable(studID);
    });

    $('#submitAttachmentBtn').click(function(){
        var admissionno = $('#admissionno').val();
        var studentid = $('#studentid').val();
        var attachment_id = $("#attachment_id").val();
        var title = $('#title').val();
        var updatecertificate = $('#updatecertificate').val();
    
        var formData = new FormData();
        formData.append("file", $('#certificate')[0].files[0]);
        formData.append("admissionno", admissionno);
        formData.append("studentid", studentid);
        formData.append("attachment_id", attachment_id);
        formData.append("title", title);
        formData.append("updatecertificate", updatecertificate);
    
        if (formData != "") {
            $.ajax({
                url: 'studentFile/attachmentFiles/ajaxInsertAttachment.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    var insresult = response.includes("Exists");
                    var updresult = response.includes("Updated");
                    if (insresult) {
                        $('#attachmentInsertNotOk').show();
                        setTimeout(function() {
                            $('#attachmentInsertNotOk').fadeOut('fast');
                        }, 2000);
                    } else if (updresult) {
                        $('#attachmentUpdateOk').show();
                        setTimeout(function() {
                            $('#attachmentUpdateOk').fadeOut('fast');
                        }, 2000);
                        resetAttachmentTable(studentid);
                        clearAllfieldInModal();
                    } else {
                        $('#attachmentInsertOk').show();
                        setTimeout(function() {
                            $('#attachmentInsertOk').fadeOut('fast');
                        }, 2000);
                        resetAttachmentTable(studentid);
                        clearAllfieldInModal();
                    }
                }
            });
        } else {
            $("#attachmentnameCheck").show();
        }
    });
    

    $("body").on("click","#edit_attachment",function(){
        var attachment_id = $(this).attr('value');
        $("#attachment_id").val(attachment_id);
        $.ajax({
            url: 'studentFile/attachmentFiles/ajaxEditAttachment.php',
            type: 'POST',
            data: {"attachment_id":attachment_id},
            cache: false,
            dataType: 'json',
            success:function(response){
            $("#title").val(response['title']);
            $("#updatecertificate").val(response['file_name']);
            $("#attachedfile").attr("href", response['file_path']);
            $("#attachedfile").text(response['file_name']);
            }
        });
    });

    $("body").on("click","#delete_attachment", function(){
    var isok=confirm("Do you want Delete Attachment?");
    if(isok==false){
    return false;
    }else{
        var attachment_id=$(this).attr('value');
        var c_obj = $(this).parents("tr");
        $.ajax({
            url: 'studentFile/attachmentFiles/ajaxDeleteAttachment.php',
            type: 'POST',
            data: {"attachment_id":attachment_id},
            cache: false,
            success:function(response){
                var delresult = response.includes("Rights");
                if(delresult){
                $('#attachmentDeleteNotOk').show(); 
                setTimeout(function() {
                $('#attachmentDeleteNotOk').fadeOut('fast');
                }, 2000);
                }
                else{
                c_obj.remove();
                $('#attachmentDeleteOk').show();  
                setTimeout(function() {
                $('#attachmentDeleteOk').fadeOut('fast');
                }, 2000);
                }

                clearAllfieldInModal();
            }
        });
    }
    });
    //Modal Box for Assertion Name END


}); //Document END.

//Assertion Modal START
//reset Attachment modal table
function resetAttachmentTable(studID){
    $.ajax({
        url: 'studentFile/attachmentFiles/ajaxResetAttachmentTable.php',
        type: 'POST',
        data: {"studID":studID},
        cache: false,
        success:function(html){
            $("#updatedAttachmentTable").empty();
            $("#updatedAttachmentTable").html(html);
        }
    });
}

function clearAllfieldInModal(){
    $('#attachment_id').val('');
    $('#title').val('');
    $('#certificate').val('');
    $('#updatecertificate').val('');
}
//Assertion Modal END