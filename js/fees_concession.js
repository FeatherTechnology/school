// Document is ready
$(document).ready(function(){ 

// Listen for changes to the 'grp_concession_amount' input field
// $('#grp_concession_amount').change(function() { 
  // alert("fdfasdf")
  // var concess = $(this).val();
  // console.log(concess);
  // // Get the values of 'grp_balance_amount' and 'grp_concession_amount'
  // var grpBalanceAmount = parseFloat($('.amount_balance').val()) || 0;
  // var grpConcessionAmount = parseFloat($('.grp_concession_amount').val()) || 0;

  // // Calculate the new 'balance_amount' value
  // var balanceAmount = grpBalanceAmount - grpConcessionAmount;

  // // Update the 'grp_balance_amount' input field with the new value
  // $('.grp_balance_amount').val(balanceAmount.toFixed(2));
// });

        $('input[name="concession_type"]').click(function(){
          var value = $(this).val();
          
          if(value == "General Concession"){
            $("#manual_concessionDiv").hide();
            $("#general_concessionDiv").show();
            $("#referal_concessionDiv").hide();

          } else if(value == "Referal Concession"){
            $("#manual_concessionDiv").hide();
            $("#general_concessionDiv").hide();
            $("#referal_concessionDiv").show();
          }
          else if(value == "Manual Concession"){
            $("#manual_concessionDiv").show();
            $("#general_concessionDiv").hide();
            $("#referal_concessionDiv").hide();
          }
        });


        $("#student_detailsDiv").hide();
        $("#student_detailswithoutDiv").hide();

        $("#student_id").change(function(){ 
            var standard=$("#standard").val();
            var medium=$("#medium").val();
            var student_id=$("#student_id").val();
            resetstockinfotable(medium,student_id,standard);   
            $("#student_detailswithoutDiv").hide();
            $("#student_detailsDiv").show();
            $("#manual_concessionDiv").show();
            $("#general_concessionDiv").hide();
            $("#referal_concessionDiv").hide();
        });
        
        $("#student_name1").change(function(){ 
            var student_name1=$("#student_name1").val();
            resetstockinfotables(student_name1); 
            $("#student_detailswithoutDiv").show();
            $("#student_detailsDiv").hide(); 
            $("#manual_concessionDiv").show();
            $("#general_concessionDiv").hide();
            $("#referal_concessionDiv").hide();
        });

        function resetstockinfotable(){
          var standard=$("#standard").val();
          var medium=$("#medium").val();
          var student_id=$("#student_id").val();
          var payfeesid=$(".pay_fees_id").val();
          $.ajax({
          url: 'FeesConcession/ajaxResetConcessionTable.php',
          type: 'POST',
          data: {"standard":standard,"medium":medium,"student_id":student_id,"payfeesid":payfeesid},
          cache: false,
          success:function(html){
              $("#updatedstockinfotable").empty();
              $("#updatedstockinfotable").html(html);
          }
        });
        }
    // call the reset function to populate the table
    resetstockinfotable();

    function resetstockinfotables(){
      var student_name1=$("#student_name1").val();
      var payfeesid=$(".pay_fees_id").val();

      $.ajax({
      url: 'FeesConcession/ajaxResetConcessionTable.php',
      type: 'POST',
      data: {"student_name1":student_name1,"payfeesid":payfeesid},
      cache: false,
      success:function(html){
          $("#updatedstockinfotable1").empty();
          $("#updatedstockinfotable1").html(html);
      }
    });
    }
  // call the reset function to populate the table
  resetstockinfotables();
});


     // listen for changes in the medium, standard, and section dropdowns
$("#medium, #standard, #section").change(function(){ 

  // get the selected values from the medium, standard, and section dropdowns
  var medium = $("#medium").val(); 
  var standard = $("#standard").val(); 
  var section = $("#section").val(); 
  
  // check if both medium and standard dropdowns have a value selected
  if(medium.length != 0 && standard.length != 0) {
  
    // make an AJAX request to fetch the section list
    $.ajax({
      url: 'FeesCollectionFile/grp/ajaxgetStudentList.php',
      type: 'post',
      data: {"medium":medium,"standard":standard},
      dataType: 'json',
      success:function(response){
      
        // clear the section dropdown and add a default option
        $('#section').empty();
        $('#section').append("<option value=''>Select Section</option>");
        
       // loop through the section list in the response and add options to the section dropdown
          for (var i = 0; i < response.section.length; i++) { 
            $('#section').append("<option value='" + response.section[i] + "'>" + response.section[i] + "</option>");
          }

          // set the value of the section dropdown to the selected section
          $('#section').val(section);

        
        // check if section dropdown has a value selected
        if(section.length != 0){
        
          // make an AJAX request to fetch the student names list
          $.ajax({
            url: 'FeesCollectionFile/grp/ajaxgetStudentList.php',
            type: 'post',
            data: { "section":section },
            dataType: 'json',
            success:function(response){
            
              $('#student_id').empty();
              $('#student_id').append("<option value=''>Select Student</option>");
              
              // loop through the student_id list in the response and add options to the student_id dropdown
              for (var i = 0; i < response.student_id.length; i++) { 
                $('#student_id').append("<option value='" + response.student_id[i] + "'>" + response.student_name[i] + "</option>");
              }
          
            }
          });
        }
      },
      error:function(jqXHR, textStatus, errorThrown){
        console.log(errorThrown);
      }
    });
    
  } else {
  
    // if not, clear the section and student dropdowns and return
    // $('#section').empty();
    // $('#section').append("<option value=''>Select Section</option>");
    $('#student_id').empty();
    $('#student_id').append("<option value=''>Select Student</option>");
    
  }

  $('#student_id','#student_name1').on('change', function() {
    var student_id = $(this).val(); // get the selected student_id
    var student_name1 = $(this).val(); // get the selected student_id

    // make an AJAX request to fetch the corresponding student_name
    $.ajax({
      url: 'FeesCollectionFile/grp/ajaxgetStudentList.php',
      type: 'post',
      data: { "student_id":student_id, "student_name1":student_name1},
      dataType: 'json',
      success:function(response){ 
        // console.log("response",response);
        $("#student_name2").val(response['student_name2'] + " " + "Fee Detail for"); // update student_name2 field with the returned value
      }
    });
  });
    
     //  Alert Message Grater Than Amount entered
     $('.grp_concession_amount').on('change', function() { alert("sdfsdfasd")
      var grp_concession_amount = parseInt($('.grp_concession_amount').val()); alert (grp_concession_amount)
      var amount_balance = parseInt($('.amount_balance').val());
      if (amount_balance >grp_concession_amount) {
        alert('Fees collected is greater than total!');
      } 
    });

});


function getBalance(e){
  var grpBalanceAmount = e.parentElement.parentElement.querySelector('.amount_balance').value;
  var grp_balance_amount = e.parentElement.parentElement.querySelector('.grp_balance_amount');
  
  if(parseInt(e.value) > parseInt(grpBalanceAmount)) {
    alert("The entered value is greater than the fee amount.");
    grp_balance_amount.value = 0;
    e.value = 0;
  } else {
    grp_balance_amount.value = parseInt(grpBalanceAmount) - parseInt(e.value);
  }
}

function getExtraBalance(e){
  var grpBalanceAmount = e.parentElement.parentElement.querySelector('.extra_amount').value;
  var extra_balance_amount = e.parentElement.parentElement.querySelector('.extra_balance_amount');
  
  if(parseInt(e.value) > parseInt(grpBalanceAmount)) {
    alert("The entered value is greater than the fee amount.");
    extra_balance_amount.value = 0;
    e.value = 0;
  } else {
    extra_balance_amount.value = parseInt(grpBalanceAmount) - parseInt(e.value);
  }
}

function getAmenityBalance(e){
  var grpBalanceAmount = e.parentElement.parentElement.querySelector('.amenity_amount').value;
  var amenity_balance_amount = e.parentElement.parentElement.querySelector('.amenity_balance_amount');
  
  if(parseInt(e.value) > parseInt(grpBalanceAmount)) {
    alert("The entered value is greater than the fee amount.");
    amenity_balance_amount.value = 0;
    e.value = 0;
  } else {
    amenity_balance_amount.value = parseInt(grpBalanceAmount) - parseInt(e.value);
  }
}


    //DataTabale 

    let example = $('#general_concessionTable1').DataTable({
      // dom: 'lBfrtip', 
       buttons: [
         
         {		 
           extend:'colvis',
           collectionLayout: 'fixed four-column',
         }

       ],	
       "lengthMenu": [
         [10, 25, 50, -1],
         [10, 25, 50, "All"]
       ]
   });

   let example1 = $('#general_concessionTable').DataTable({
    // dom: 'lBfrtip', 
     buttons: [
       
       {		 
         extend:'colvis',
         collectionLayout: 'fixed four-column',
       }

     ],	
     "lengthMenu": [
       [10, 25, 50, -1],
       [10, 25, 50, "All"]
     ]
 });

 let example2 = $('#referal_concessionTable').DataTable({
  // dom: 'lBfrtip', 
   buttons: [
     
     {		 
       extend:'colvis',
       collectionLayout: 'fixed four-column',
     }

   ],	
   "lengthMenu": [
     [10, 25, 50, -1],
     [10, 25, 50, "All"]
   ]
});
let example3 = $('#referal_concessionTable1').DataTable({
  // dom: 'lBfrtip', 
   buttons: [
     
     {		 
       extend:'colvis',
       collectionLayout: 'fixed four-column',
     }

   ],	
   "lengthMenu": [
     [10, 25, 50, -1],
     [10, 25, 50, "All"]
   ]
});
        

 

	