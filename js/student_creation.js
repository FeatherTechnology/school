// Document is ready
$(document).ready(function () {	
 
  $('#extra_curricular').select2();
  // $('#extra_curricular').select2();
  $('#extra_curricular').on('select2:opening select2:closing', function( event ) {
      var $searchfield = $(this).parent().find('.select2-search__field');
      $searchfield.prop('disabled', true);
  });
  // $('#emisno').prop('readonly', true);
   
  $(document).on("click", ".rejectpo", function () {
    var id = $(this).data('id');
    $("#student_id").val(id);
  });
  $(".concessiontypedetails").select2({
    // allowClear: true,
    width: "-webkit-fill-available"
});

$("#refstaffid").select2({
  // allowClear: true,
  width: "-webkit-fill-available"
});
$("#refstudentid").select2({
  // allowClear: true,
  width: "-webkit-fill-available"
});
$("#refoldstudentid").select2({
  // allowClear: true,
  width: "-webkit-fill-available"
});

$(".transportarearefid").select2({
  // allowClear: true,
  width: "-webkit-fill-available"
});

// $("#temp_no").on("input", function() {
//   var temp_no = $(this).val();
//   if (temp_no != '') {
//     $('.image_div').show(); // show the image div
//   } else {
//     $('.image_div').hide(); // hide the image div
//   }
// });


  $("body").on("click","#temp_admission_id",function(){
    var temp_admission_id=$(this).attr('value');
    
         $("#temp_admission_id").val(temp_admission_id);
          $.ajax({ 
            url: 'studentFile/ajaxEditTempStudent.php',
            type: 'post',
            data: { "temp_admission_id":temp_admission_id},
            dataType: 'json',
            success:function(response){ 

              $("#temp_no").val(response['temp_no']);
              $("#student_name").val(response['temp_student_name']);
              $("#date_of_birth").val(response['temp_dob']);
              $("#flat_no").val(response['temp_flat_no']);
              $("#street").val(response['temp_street']);
              $("#area_locatlity").val(response['temp_area']);
              $("#district").val(response['temp_district']);
              $("#father_name").val(response['temp_father_name']);
              $("#mother_name").val(response['temp_mother_name']);
              $("#temp_admission_id").val(response['temp_admission_id']);

              // $("#temp_admission_id").val(response['temp_admission_id']);
              // $("#temp_no").attr("value", $("#temp_no").val() + response['temp_no']);
              // $("#student_name").attr("value", $("#student_name").val() + response['temp_student_name']);
              // $("#date_of_birth").attr("value", $("#date_of_birth").val() + response['temp_dob']);
              // $("#flat_no").attr("value", $("#flat_no").val() + response['temp_flat_no']);
              // $("#street").attr("value", $("#street").val() + response['temp_street']);
              // $("#area_locatlity").attr("value", $("#area_locatlity").val() + response['temp_area']);
              // $("#district").attr("value", $("#district").val() + response['temp_district']);
              // $("#father_name").attr("value", $("#father_name").val() + response['temp_father_name']);
              // $("#mother_name").attr("value", $("#mother_name").val() + response['temp_mother_name']);
              
              // Code to standard append a dropdown
              $('#standard').empty(); // clear existing options           
                $('#standard').append("<option value='" + response['temp_standard'] + "'>" + response['temp_standard'] + "</option>"); // add new option
        
              // Code to medium append a dropdown
              $('#medium').empty(); // clear existing options
              // $('#medium').prepend("<option value=''>" + response['temp_medium'] + "</option>"); // add default option
              // var r = 0;
              // for (r = 0; r <= response.temp_medium.length - 1; r++) {
                $('#medium').append("<option value='" + response['temp_medium'] + "'>" + response['temp_medium'] + "</option>"); // add new option
              // }

          
              

              // Code to gender append a radio button
              var gender_options = response.temp_gender;
              if (gender_options === 'Male') {
                $('#male').val('Male').prop('checked', true);
              } else if (gender_options === 'Female') {
                  $('#female').val('Female').prop('checked', true);
              }

              // Code to category append a radio button
              var category_options = response.temp_category;
              if (category_options === 'OBC') {
                $('#obc').val('OBC').prop('checked', true);
              } else if (category_options === 'BC') {
                  $('#bc').val('BC').prop('checked', true);
              } else if (category_options === 'MBC') {
                $('#mbc').val('MBC').prop('checked', true);
              } else if (category_options === 'SC') {
                $('#sc').val('SC').prop('checked', true);
              } else if (category_options === 'ST') {
                $('#st').val('ST').prop('checked', true);
              } else if (category_options === 'DNC') {
              $('#dnc').val('DNC').prop('checked', true);
              } else if (category_options === 'BCM') {
                $('#bcm').val('BCM').prop('checked', true);
              }

            extracur();
            
            }
  });
         
});


    // Modal Box 
 
    $.ajax({
        url: 'studentFile/ajaxResetTemporaryStudentTable.php',
        type: 'POST',
        data: {},
        cache: false,
        success:function(html){
            $("#updateddepartmentTable").empty();
            $("#updateddepartmentTable").html(html);
        }
    });


   
	      // the selector will match all input controls of type :checkbox
        // and attach a click event handler 
      $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $box.prop("checked", false);
        }
      });

      // Get Previous School Details
      $("#standard").change(function(){
        var standard = $("#standard").val(); 
        hide_show_standard(standard)
      });

      //hostel details show
        $('#hostel').change(function(){

          $('#transport_details').hide();

          if(this.checked)
              $('#room_details').show();
          else
              $('#room_details').hide();
      });

    //transport details show
    $('#transport').change(function(){

      $('#room_details').hide();

      if(this.checked)
          $('#transport_details').show();
      else
          $('#transport_details').hide();

    });

     //Gaurdian details show
     $('#lives_gaurdian').change(function(){

      if(this.checked)
          $('#gaurdian_details').show();
      else
          $('#gaurdian_details').hide();
  });
    
    //Conecssion type\

    $("#concession_types_det").show();

    $("#scholar").click(function(){
      $("#concession_types_det").hide();
    });

    $("#rte").click(function(){
      $("#concession_types_det").hide();
    });

    $("#general").click(function(){
      $("#concession_types_det").show();
    });

    // Get Reference Details
    $("#referencecat").change(function(){
      var referencecat = $("#referencecat").val(); 
      hide_show_referenceCat(referencecat)
    });

//form validation

	// Validate Admission number
	$('#admission_numberCheck').hide();	
	let admission_numberError = true;
	$('#admission_number').change(function () {	
		validateadmission_number();
	});

	function validateadmission_number() { 
		let admission_numberValue = $('#admission_number').val();	
		if (admission_numberValue.length == '') {
			$('#admission_numberCheck').show();
			admission_numberError = false;
			return false;
		}
		else {
			$('#admission_numberCheck').hide();
			admission_numberError = true;	
		}
	}

  // Validate student Name
	$('#student_nameCheck').hide();	
	let student_nameError = true;
	$('#student_name').change(function () {	
		validatestudent_name();
	});

	function validatestudent_name() { 
		let student_nameValue = $('#student_name').val();	
		if (student_nameValue.length == '') {
			$('#student_nameCheck').show();
			student_nameError = false;
			return false;
		}
		else {
			$('#student_nameCheck').hide();
			student_nameError = true;	
		}
	}

     // Validate gender_status
     $('#genderCheck').hide(); 
     let gender_error = true;
     $('input[name="gender"]').click(function () {     
         validategenderStatus();
     });
     function validategenderStatus() {

      let male = $("#male").prop("checked");  
      let female = $("#female").prop("checked");  

      if (male == false && female == false) { 
          $('#genderCheck').show();
          gender_error = false;
          return false;
      } else if (male == false && female == true) {
          $('#genderCheck').hide();
          gender_error = true; 
        } else if (male == true && female == false) {
          $('#genderCheck').hide();
          gender_error = true; 
        }else if (male == true || female == true) {
          $('#genderCheck').hide();
          gender_error = true; 
        }
  }

  // Validate mother_tongue
  $('#mother_tongueCheck').hide();	
	let mother_tongueError = true;
	$('#mother_tongue').change(function () {	
		validateMotherTongue();
	});

	function validateMotherTongue() { 
		let mother_tongueValue = $('#mother_tongue').val();	
		if (mother_tongueValue.length == '') {
			$('#mother_tongueCheck').show();
			mother_tongueError = false;
			return false;
		}
		else {
			$('#mother_tongueCheck').hide();
			mother_tongueError = true;	
		}
	}

   // Validate Statndard
   $('#standardCheck').hide();	
   let standardError = true;
   $('#standard').change(function () {	
     validateStandard();
   });
 
   function validateStandard() { 
     let standardValue = $('#standard').val();	
     if (standardValue.length == '') {
       $('#standardCheck').show();
       standardError = false;
       return false;
     }
     else {
       $('#standardCheck').hide();
       standardError = true;	
     }
   }

   

   // Validate section
   $('#sectionCheck').hide();	
   let sectionError = true;
   $('#section').change(function () {	
     validatesection();
   });
 
   function validatesection() { 
     let sectionValue = $('#section').val();	
     if (sectionValue.length == '') {
       $('#sectionCheck').show();
       sectionError = false;
       return false;
     }
     else {
       $('#sectionCheck').hide();
       sectionError = true;	
     }
   }

   // Validate medium
   $('#mediumCheck').hide();	
   let mediumError = true;
   $('#medium').change(function () {	
     validatemedium();
   });
 
   function validatemedium() { 
     let mediumValue = $('#medium').val();	
     if (mediumValue.length == '') {
       $('#mediumCheck').show();
       mediumError = false;
       return false;
     }
     else {
       $('#mediumCheck').hide();
       mediumError = true;	
     }
   }
   // Validate Roll number
   $('#studentrollnoCheck').hide();	
   let studentrollnoError = true;
   $('#studentrollno').change(function () {	
     validatestudentrollno();
   });
 
   function validatestudentrollno() { 
     let studentrollnoValue = $('#studentrollno').val();	
     if (studentrollnoValue.length == '') {
       $('#studentrollnoCheck').show();
       studentrollnoError = false;
       return false;
     }
     else {
       $('#studentrollnoCheck').hide();
       studentrollnoError = true;	
     }
   }

   // Validate studentstype
   $('#studentstypeCheck').hide();	
   let studentstypeError = true;
   $('#studentstype').change(function () {	
     validatestudentstype();
   });
 
   function validatestudentstype() { 
     let studentstypeValue = $('#studentstype').val();	
     if (studentstypeValue.length == '') {
       $('#studentstypeCheck').show();
       studentstypeError = false;
       return false;
     }
     else {
       $('#studentstypeCheck').hide();
       studentstypeError = true;	
     }
   }

   // Validate reason
   $('#reasonCheck').hide();	
   let reasonError = true;
   $('#reason').change(function () {	
     validatereason();
   });
 
   function validatereason() { 
     let reasonValue = $('#reason').val();	
     if (reasonValue.length == '') {
       $('#reasonCheck').show();
       reasonError = false;
       return false;
     }
     else {
       $('#reasonCheck').hide();
       reasonError = true;	
     }
   }

// Submit form event
$('#deleted_student__creation').submit(function(event) {
  // Prevent default form submission
  event.preventDefault();

  // Get form data
  var formData = $(this).serialize();

  // AJAX request
  $.ajax({
    url: 'studentFile/ajaxInsertReason.php', // Replace with your AJAX page URL
    type: 'POST',
    data: formData,
    success: function(response) { 
      // Handle the response from the AJAX page
      alert(response);
      // Redirect to the "edit_stduent_creation" page
      window.location.href = 'edit_student_creation';
    },
    error: function(xhr, status, error) {
      // Handle error if the AJAX request fails
      console.log(error);
    }
  });
});





  

  //  $('#myButton').click(function() { alert(buttonValue)
  //   var buttonValue = $(this).val();
  //   console.log('The button value is: ' + buttonValue);
  // });


  //  $("#rejectpobtn").on('click','.rejectpobtn',function(){ alert("dfsdfsd")
    
  //       $('#student_id').val();	alert(student_id)

  //       $.ajax({ 
  //         url: 'studentFile/ajaxInsertReason.php',
  //         type: 'post',
  //         data: { "student_id":student_id},
  //         dataType: 'json',
  //         success:function(response){

  //           $("#student_id").val(response["student_id"]);

  //         }
  //     });
  //  });

  $("#myButton").on('click','.delete',function(){
    var currentRow=$(this).closest("tr"); 
    var ponum=currentRow.find("td:eq(0)").text();
    $("#ponum").val(ponum);
     $.ajax({
     url: "purchaseorderfiles/printpo.php",
     data: {"ponum":ponum},
     cache: false,
     type: "post",
     success: function(html){
       $("#poprintfield").html(html);
     }
 });
 });

   // get age 
   
	// $("#date_of_birth").datepicker({
	// 	onSelect: function(value, ui) {
	// 		var current = new Date().getTime(), 
	// 			dateSelect = new Date(value).getTime();
	// 			age = current - dateSelect;
	// 			ageGet = Math.floor(age / 1000 / 60 / 60 / 24 / 365.25); // age / ms / sec / min / hour / days in a year
	// 		if(ageGet < 4){
	// 			less_than_4(ageGet);
	// 		}else{
	// 			greater_than_4(ageGet);
	// 		}
	// 	},
	// 	yearRange: '1900:+0d',//base year:current year
	// 	changeMonth: true,
	// 	changeYear: true,
	// 	defaultDate: '-4yr',
	// }).attr("readonly", "readonly"); //prevent manual changes


	// function less_than_4(theAge){
	// 	alert("Failed! your age is less than 4. Age: "+theAge);
	// }
	// function greater_than_4(theAge){
	// 	alert("Done! your age is greater or equal to 4. Age: "+theAge);
	// }
  //end age 

 //Student Bulk Import Excel upload
 $("#insertsuccess").hide();
 $("#notinsertsuccess").hide();
 $("#submitwithpobulkbtn").click(function(){

   var file_data = $('#file').prop('files')[0];   
   var withpo_bulk = new FormData();                  
   withpo_bulk.append('file', file_data);

   if(file.files.length == 0 ){
     alert("Please Select Excel File");
     return false;
   }

    $.ajax({
     type: 'POST',
     url: 'studentFile/ajaxstudentbulkupload.php',
     data: withpo_bulk,
     dataType: 'json',
     contentType: false,
     cache: false,
     processData:false,
     beforeSend: function(){
     $('#file').attr("disabled",  true);
       $('#submitwithpobulkbtn').attr("disabled", true);
     },
     success: function(data){
     if(data == 0){
       $("#notinsertsuccess").hide();
       $("#insertsuccess").show();
       $("#file").val('');
     }else if(data == 1){
       $("#insertsuccess").hide();
       $("#notinsertsuccess").show();
       $("#file").val('');
     }
     },
     complete: function(){
     $('#file').attr("disabled",  false);
     $('#submitwithpobulkbtn').attr("disabled", false);     
     document.getElementById("withpo_upload_form").reset();    
     }
    });
   });

 // Age Validation

    $('#date_of_birth').on('change', function() {
      var dob = $('#date_of_birth').val();
      var age = calculateAge(dob);
      if (age < 4) {
        // $("#age-result").hide();
      
        $("#age-result").text('');
        $('#age-result1').text('You must be at least 4 years old to use this service.');
        $('#date_of_birth').val('');
      } else {
        

        $("#age-result1").text('');
        $('#age-result').text('Age validated: ' + age);
      }
    });
  
  function calculateAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
  }

  // Modal Box for Reason Name
  $("#reasonCheck").hide();
  $(document).on("click", "#submitreasonBtn", function () { alert(student_id)
      var student_id=$("#student_id").val();
      var reason=$("#reason").val();
      if(reason!=""){
          $.ajax({
              url: 'studentFile/ajaxInsertReason.php',
              type: 'POST',
              data: {"reason":reason,"student_id":student_id},
              cache: false,
              success:function(response){
                  var insresult = response.includes("Exists");
                  var updresult = response.includes("Updated");
                  if(insresult){
                      $('#reasonInsertNotOk').show(); 
                      setTimeout(function() {
                          $('#reasonInsertNotOk').fadeOut('fast');
                      }, 2000);
                  }else if(updresult){
                      $('#reasonUpdateOk').show();  
                      setTimeout(function() {
                          $('#reasonUpdateOk').fadeOut('fast');
                      }, 2000);
                      $("#reasonTable").remove();
                      resetreasonTable();
                      $("#reason").val('');
                      $("#student_id").val('');
                  }
                  else{
                      $('#reasonInsertOk').show();  
                      setTimeout(function() {
                          $('#reasonInsertOk').fadeOut('fast');
                      }, 2000);
                      $("#reasonTable").remove();
                      resetreasonTable();
                      $("#reason").val('');
                      $("#student_id").val('');
                  }
              }
          });
      }
      else{
      $("#reasonnameCheck").show();
      }
  });


  function resetreasonTable(){
  $.ajax({
      url: 'studentFile/ajaxResetReasonTable.php',
      type: 'POST',
      data: {},
      cache: false,
      success:function(html){
          $("#updatedreasonTable").empty();
          $("#updatedreasonTable").html(html);
      }
  });
  }
 
   $("#reason").keyup(function(){
       var CTval = $("#reason").val();
       if(CTval.length == ''){
       $("#reasonnameCheck").show();
       return false;
       }else{
       $("#reasonnameCheck").hide();
       }
   });
   $("body").on("click","#edit_reason",function(){
       var student_id=$(this).attr('value');
       $("#student_id").val(student_id);
       $.ajax({
               url: 'studentFile/ajaxEditReason.php',
               type: 'POST',
               data: {"student_id":student_id},
               cache: false,
               success:function(response){
               $("#reason").val(response);
           }
       });
   });

 $("body").on("click","#delete_reason", function(){
   var isok=confirm("Do you want delete reason?");
   if(isok==false){
     return false;
   }else{
       var student_id=$(this).attr('value');
       var c_obj = $(this).parents("tr");
       $.ajax({
           url: 'studentFile/ajaxDeleteReason.php',
           type: 'POST',
           data: {"student_id":student_id},
           cache: false,
           success:function(response){
               var delresult = response.includes("Rights");
               if(delresult){
               $('#reasonDeleteNotOk').show(); 
               setTimeout(function() {
               $('#reasonDeleteNotOk').fadeOut('fast');
               }, 2000);
               }
               else{
               c_obj.remove();
               $('#reasonDeleteOk').show();  
               setTimeout(function() {
               $('#reasonDeleteOk').fadeOut('fast');
               }, 2000);
               }
           }
       });
   }
 });
 
 $(function(){
   $('#reasonTable').DataTable({
     'iDisplayLength': 5,
     "language": {
       "lengthMenu": "Display _MENU_ Records Per Page",
       "info": "Showing Page _PAGE_ of _PAGES_",
     }
   });
 });



  
  // Submit Button 
	$('#SubmitStudentCreation').click(function () {	
    validateadmission_number();
    validatestudent_name();	
    validategenderStatus();
    validateMotherTongue();
    validateStandard();
    validatesection();
    validatemedium();
    validatestudentrollno();
    validatestudentstype();
    calculateAge();
    validatereason();
    

  if(admission_numberError == true && student_nameError == true && gender_error == true && mother_tongueError == true && standardError == true
    && sectionError == true && mediumError == true && studentrollnoError == true &&  studentstypeError == true && reasonError == true){    
    return true;
      } 
      else 
      {
          return false;
      }
  });

  $("#studentBulkDownload").click(function () {
    window.location.href='uploads/downloadfiles/Bulk_Import_Excel_Formate.xlsx'
  });

});


function hide_show_standard(standard){
  if(standard == 'PRE.K.G'){ 
    $("#previous_school").hide();
  }else {
    $("#previous_school").show();
  }
}

function hide_show_referenceCat(referencecat){
  if(referencecat == 'NewStudent'){ 
    $("#reference_newstudent").show();
    $("#reference_oldstudent").hide();
    $("#reference_staff").hide();
    $("#reference_agent").hide();

  }else if(referencecat == 'OldStudent'){
    $("#reference_newstudent").hide();
    $("#reference_oldstudent").show();
    $("#reference_staff").hide();
    $("#reference_agent").hide();

  }else if(referencecat == 'Staff'){
    $("#reference_newstudent").hide();
    $("#reference_oldstudent").hide();
    $("#reference_staff").show();
    $("#reference_agent").hide();

  }else if(referencecat == 'Agent'){
    $("#reference_newstudent").hide();
    $("#reference_oldstudent").hide();
    $("#reference_staff").hide();
    $("#reference_agent").show();

  }else if(referencecat == 'Other'){
    $("#reference_newstudent").hide();
    $("#reference_oldstudent").hide();
    $("#reference_staff").hide();
    $("#reference_agent").show();
  }
}

// Address value get permanant address as same

function filladd()
{
	 if(filltoo.checked == true) 
     {
             var flat_no11 =document.getElementById("flat_no").value;
			 var street11 =document.getElementById("street").value;
			 var area_locatlity11 =document.getElementById("area_locatlity").value;
			 var district11 =document.getElementById("district").value;
			 var pincode11 =document.getElementById("pincode").value;
          

           
            var copyflat_no =flat_no11 ;
            var copystreet =street11;
            var copyarea_locality =area_locatlity11 ;
            var copydist =district11 ;
            var copypin =pincode11 ;

            
            document.getElementById("flat_no1").value = copyflat_no;
            document.getElementById("street1").value = copystreet;
            document.getElementById("area_locatlity1").value = copyarea_locality;
            document.getElementById("district1").value = copydist;
            document.getElementById("pincode1").value = copypin;
	 }
	 else if(filltoo.checked == false)
	 {
        document.getElementById("flat_no1").value ='';
        document.getElementById("street1").value = '';
        document.getElementById("area_locatlity1").value = '';
        document.getElementById("district1").value = '';
        document.getElementById("pincode1").value = '';
	 }
}

// $("body").on("click","#temp_no_empty",function(){
//   var temp_no = $("#temp_no").val(); 

//   if (temp_no != '') { 
//     $('.image_div').show(); // show the image div
//   } else { 
//     $('.image_div').hide(); // hide the image div
//   }
// });

function DropDownStock() {
  var temp_no = $("#temp_no").val(); 

  if (temp_no != '') { 
    $('.image_div').show(); // show the image div
  } else { 
    $('.image_div').hide(); // hide the image div
  }
}
$('#telephone_number').blur(function() {
  mobno();
});
$('#gaurdian_mobile').blur(function() {
  gaurdmobno();
  smsmobno();
});
$('#gaurdian_mobile').keyup(function() {
  smsmobno();
});
$('#mother_mobile_no').blur(function() {
  mommobile();
});
$('#father_mobile_no').blur(function() {
  dadmobile();
});
$('#sms_sent_no').blur(function() {
  smsmobile();
});


function mobno() {
  var mobno = $('#telephone_number').val();
  if(mobno.length == ' '){
       $('#mobile').text('');
      $('#SubmitStudentCreation').prop('disabled', false);
  }else{
    if(mobno.length < '10'){
      $('#mobile').text('Enter 10 Digit Mobile Number');
      $('#SubmitStudentCreation').prop('disabled', true);
      }else{
        $('#mobile').text('');
      $('#SubmitStudentCreation').prop('disabled', false);

      }
  }
     
}
function gaurdmobno(){
  var mobno = $('#gaurdian_mobile').val();
  if(mobno.length == ' '){
    $('#gaurdmobile').text('');
   $('#SubmitStudentCreation').prop('disabled', false);
}else{
  if(mobno.length < '10'){
    $('#gaurdmobile').text('Enter 10 Digit Mobile Number');
    $('#SubmitStudentCreation').prop('disabled', true);
    }else{
      $('#gaurdmobile').text('');
    $('#SubmitStudentCreation').prop('disabled', false);

    }
}
}

function smsmobno(){
  var mobno = $('#gaurdian_mobile').val();
  if(mobno == ''){
    $('#sms_sent_no').val('');
  }else{
    $('#sms_sent_no').val($('#gaurdian_mobile').val());
  }
  
  
}
function mommobile(){
  var mobno = $('#mother_mobile_no').val();
  if(mobno.length == ' '){
    $('#mommobile').text('');
   $('#SubmitStudentCreation').prop('disabled', false);
}else{
  if(mobno.length < '10'){
    $('#mommobile').text('Enter 10 Digit Mobile Number');
    $('#SubmitStudentCreation').prop('disabled', true);
    }else{
      $('#mommobile').text('');
    $('#SubmitStudentCreation').prop('disabled', false);

    }
}
}
function dadmobile(){
  var mobno = $('#father_mobile_no').val();
  if(mobno.length == ' '){
    $('#dadmobile').text('');
   $('#SubmitStudentCreation').prop('disabled', false);
}else{
  if(mobno.length < '10'){
    $('#dadmobile').text('Enter 10 Digit Mobile Number');
    $('#SubmitStudentCreation').prop('disabled', true);
    }else{
      $('#dadmobile').text('');
    $('#SubmitStudentCreation').prop('disabled', false);

    }
}
}
function smsmobile(){
  var mobno = $('#sms_sent_no').val();
  if(mobno.length == ' '){
    $('#smsmobile').text('');
   $('#SubmitStudentCreation').prop('disabled', false);
}else{
  if(mobno.length < '10'){
    $('#smsmobile').text('Enter 10 Digit Mobile Number');
    $('#SubmitStudentCreation').prop('disabled', true);
    }else{
      $('#smsmobile').text('');
    $('#SubmitStudentCreation').prop('disabled', false);

    }
}
}
function validateEmail(email) {
  // Regular expression pattern for email validation
  var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}
$('#gaurdian_email_id').blur(function() {
  var email = $(this).val();
  if (email =='') {
      $('#gaurdemail').text('');
      $('#SubmitStudentCreation').prop('disabled', false);
  }else{
    if (validateEmail(email)) {
      $('#gaurdemail').text('');
      $('#SubmitStudentCreation').prop('disabled', false);
  } else {
       $('#gaurdemail').text('Enter Valid Email ID');
       $('#SubmitStudentCreation').prop('disabled', true);
  }
  }

  
});
$('#father_email_id').blur(function() {
  var email = $(this).val();
  if (email =='') {
      $('#dademail').text('');
      $('#SubmitStudentCreation').prop('disabled', false);
  }else{
    if (validateEmail(email)) {
      $('#dademail').text('');
      $('#SubmitStudentCreation').prop('disabled', false);
  } else {
       $('#dademail').text('Enter Valid Email ID');
       $('#SubmitStudentCreation').prop('disabled', true);
  }
  }

  
});
$("#SubmitStudentCreation").on('click', function() {
          mobno();
          gaurdmobno();
          smsmobno();
          mommobile();
          dadmobile();
          smsmobile();
          dadaadhaar();   
          momaadhaar();
          gaurdaadhar();
          appaadhaar();
});
// Document is ready
$(document).ready(function () {	
  extracur();
});

function extracur(){
              var studentstype = $('#studentstype').val();
              var mediums = $('#medium').val();
              var standards = $('#standard').val();
              var extra_cur = $('#extra_cur').val();
              
              $.ajax({ 
                url: 'studentFile/ajaxextraactivity.php',
                type: 'post',
                data: { "mediums":mediums,
                        "standards":standards,
                        "studentstype":studentstype
                      },
                dataType: 'json',
                success:function(response){ 
                  var dropdown = $('#extra_curricular');
      dropdown.empty();
      
          
      for (var key in response) {
        if (response.hasOwnProperty(key)) {
          var record = response[key];
          var isSelected = (extra_cur != '') ? (record.fees_id == extra_cur) : false;
          var option = new Option(record.extra_particulars, record.fees_id, isSelected, isSelected);
          dropdown.append(option);
        }
      }
        
      // dropdown.trigger('change');
                   
                }
              })

}
$("#studentstype").change(function(){
  extracur();
});