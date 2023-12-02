// Document is ready
$(document).ready(function () {	

        // add event listener to select element
    $('#temp_medium').on('change', function() {  
        // get the selected option value
        // var selectedStandard = $(this).val(); 
        var selectedStandard = $("#temp_standard").val(); 
        // generate temporary number based on selected standard
        var tempNo = generateTempNo(selectedStandard);

        // set the temporary number input value
        $('#temp_no').val(tempNo);
    });

    function generateTempNo(standard) {
        var currentYear = new Date().getFullYear(); // get the current year
    
        // construct the temporary number format based on the selected standard
        var tempNoFormat = standard + '-' + currentYear + '-';
     console.log("newNumericPart",tempNoFormat);
        // get the last temporary number value from the database for all standards
        var lastTempNo = getLastTempNo(standard,currentYear);
    
        // extract the numeric part from the last temporary number
        var lastNumericPart = parseInt(lastTempNo.split('-')[2]);
    
        // increment the numeric part by 1
        var newNumericPart = lastNumericPart + 1;
   
        // construct the new temporary number
        var tempNo = tempNoFormat + newNumericPart;
    
        // set the value of the temp_no input field
        $('#temp_no').val(tempNo);
    
        return tempNo;
    }
    
    
    function getLastTempNo(standard,currentYear) {
        console.log(standard);
       
        // make a database query to get the last temporary number value for all standards
        // and return it
        // assuming you are using jQuery and AJAX, you can do something like this:
        var medium = $('#temp_medium').val();
        console.log("medium",medium);
        var lastTempNo;
        $.ajax({
            url: 'ajaxgetTempcode.php',
            type: 'POST',
            async: false,
            data: {"standard":standard,"currentYear":currentYear,"medium":medium},
            success: function(data) {
                lastTempNo = data;
            }
        });
        return lastTempNo;
    }
    
    
    
    
    // Age Validation

    $('#temp_dob').on('change', function() {
        var dob = $('#temp_dob').val();
        var age = calculateAge(dob);
        if (age < 4) {
          // $("#age-result").hide();
        
          $("#age-result").text('');
          $('#age-result1').text('You must be at least 4 years old to use this service.');
          $('#temp_dob').val('');
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

    $('button').click(function() {
        var birthdate = $('#birthdate').val();
        var gradeLevel = $('#grade').val();
        var age = calculateAge(birthdate);
        var schoolAge = calculateSchoolAge(age, gradeLevel);
        $('#result').text("The student's school age is "+schoolAge+" years old.");
        });

        // temp_contact_number validation
        $('#temp_contact_number').keyup(function () {     
            validatemobile();
      });
       // temp_student_name validation
       $('#temp_student_name').blur(function () {     
        validatename();
  });
    // dob validation
    $('#temp_dob').blur(function () {     
        validdob();
  });
      
    });
// Create new bidder
$("#submittemp_admission_creation").click(function(){ 

    validatemobile();
    validatename();
    validdob();
    
});

        function validatemobile(){
          var mob = $('#temp_contact_number').val();
          console.log("mob",mob.length);
            if(mob == ''){
               $('#val_mob').text("Enter mobile Number");
               $('#submittemp_admission_creation').prop("disabled", true);

            }else{

                if(mob.length == '10'){
                    $('#val_mob').text("");
                    $('#submittemp_admission_creation').prop("disabled", false);
                 
                }else{
                    $('#val_mob').text("Enter 10 digit mobile number");
                    $('#submittemp_admission_creation').prop("disabled", true);
                }
                // $('#val_mob').text("");

            }

        }
        function validatename(){
            var mob = $('#temp_student_name').val();
              if(mob == ''){
                 $('#valname').text("Enter Student Name ");
                 $('#submittemp_admission_creation').prop("disabled", true);
  
              }else{
                $('#valname').text("");
                $('#submittemp_admission_creation').prop("disabled", false);
                }
  
          }
          function validdob(){
            var dob = $('#temp_dob').val();

            if(dob == ''){
                $('#age-result1').text("Enter Date Of Birth ");
                $('#submittemp_admission_creation').prop("disabled", true);
 
             }else{
               $('#age-result1').text("");
               $('#submittemp_admission_creation').prop("disabled", false);
               }
          }
        function calculateAge(birthdate) {
        var today = new Date();
        var birthDate = new Date(birthdate);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
        }
        return age;
        }
        function calculateSchoolAge(age, gradeLevel) {
        var schoolAge;
        switch (gradeLevel) {
        case 'K':
        schoolAge = age + 5;
        break;
        case '1':
        schoolAge = age + 6;
        break;
        case '2':
        schoolAge = age + 7;
        break;
        case '3':
        schoolAge = age + 8;
        break;
        case '4':
        schoolAge = age + 9;
        break;
        case '5':
        schoolAge = age + 10;
        break;
        case '6':
        schoolAge = age + 11;
        break;
        case '7':
        schoolAge = age + 12;
        break;
        case '8':
        schoolAge = age + 13;
        break;
        case '9':
        schoolAge = age + 14;
        break;
        case '10':
        schoolAge = age + 15;
        break;
        case '11':
        schoolAge = age + 16;
        break;
        case '12':
        schoolAge = age + 17;
        break;
        default:
        schoolAge = 'undefined';
        }
        return schoolAge;
        }
	