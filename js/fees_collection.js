// Document is ready
$(document).ready(function () {

        $("#stockinfotable").hide();
        
        $('#student_id').change(function () { 
          
         var student_id = $("#student_id").val();
         var medium = $("#medium").val();
         var standard = $("#standard").val();
         var section = $("#section").val();
        
                  $.ajax({ 
                    url: 'FeesCollectionFile/grp/ajaxEditTempStudent.php',
                    type: 'post',
                    data: {"student_id":student_id,"medium":medium,"standard":standard,"section":section},
                    dataType: 'json',
                    success:function(response){ 
        
                      $("#admission_number").val(response['admission_number']);
                      $("#roll_number").val(response['studentrollno']);
                        $("#section1").val(response['section']);
                        $("#grp_amountre").val(response['grp_amountre']);
                        $("#extra_amountre").val(response['extra_amountre']);
                        $("#amenity_amountre").val(response['amenity_amountre']);$("#student_name").val(response['student_name']);
                        $("#grp_amount").val(response['grp_amount']);
                        $("#fees_id").val(response['fees_id']);
                        $("#extra_amount").val(response['extra_amount']);
                        $("#amenity_amount").val(response['amenity_amount']);
                        $("#tranport_grp_amount").val(response['trans_grp_amount']);
                        $("#tranport_received_amount").val(response['transport_received_fees_total']);
                        $("#tranport_concession_amount").val(response['transport_concession_fees_total']); 
                       
                        $("#grp_concession_amount").val(response['grp_con']);
                        $("#extra_concession_amount").val(response['extra_con']);
                        $("#amenity_concession_amount").val(response['amenity_con']);

                        $("#last_year_amount").val(response['totalSum']);
                        $("#last_year_received_amount").val(response['grp_amounlast']);
                        $("#last_year_concession_amount").val(response['grp_conlast']);

                        // Grp Amount Balance
                        var grp_amount = parseInt($('#grp_amount').val() || 0);
                        var grp_amountre = parseInt($('#grp_amountre').val() || 0);
                        var grp_concession = parseInt($('#grp_concession_amount').val() || 0);
                        var amount_balance = grp_amount - (grp_amountre + grp_concession);
                        
                        $('#gross_balance_amount').val(amount_balance); 
                        if (amount_balance == 0) {
                            $("#gross_balance_amount").css("color", "green");
                          } else {
                            $("#gross_balance_amount").css("color", "red");
                          }
  
                          // Extra Amount Balance
                          var extra_amount = parseInt($('#extra_amount').val() || 0);
                          var extra_amountre = parseInt($('#extra_amountre').val() || 0);
                          var extra_concession_amount = parseInt($('#extra_concession_amount').val() || 0);
                          var extra_amount_balance = extra_amount - (extra_amountre + extra_concession_amount);
                          
                          $('#extra_balance_amount').val(extra_amount_balance); 
                          if (extra_amount_balance == 0) {
                              $("#extra_balance_amount").css("color", "green");
                            } else {
                              $("#extra_balance_amount").css("color", "red");
                            }
  
                          // Amenity Amount Balance 
                          
                          var amenity_amount = parseInt($('#amenity_amount').val() || 0);
                          var amenity_amountre = parseInt($('#amenity_amountre').val() || 0);
                          var amenity_concession_amount = parseInt($('#amenity_concession_amount').val() || 0);
                          var amenity_amount_balance = amenity_amount - (amenity_amountre + amenity_concession_amount);
                          
                          $('#amenity_balance_amount').val(amenity_amount_balance); 
                          if (amenity_amount_balance == 0) {
                              $("#amenity_balance_amount").css("color", "green");
                            } else {
                              $("#amenity_balance_amount").css("color", "red");
                            }

                            // Transport Amount Calculation

                            var tranport_grp_amount = parseInt($('#tranport_grp_amount').val() || 0);
                            var tranport_received_amount = parseInt($('#tranport_received_amount').val() || 0);
                            var tranport_concession_amount = parseInt($('#tranport_concession_amount').val() || 0);
                            var transport_amount_balance = tranport_grp_amount - (tranport_received_amount + tranport_concession_amount);
                            
                            $('#tranport_balance_amount').val(transport_amount_balance); 
                            if (transport_amount_balance == 0) {
                                $("#tranport_balance_amount").css("color", "green");
                              } else {
                                $("#tranport_balance_amount").css("color", "red");
                              }

                               // Last Year Amount Calculation

                          var last_year_amount = parseInt($('#last_year_amount').val() || 0);
                          var last_year_received_amount = parseInt($('#last_year_received_amount').val() || 0);
                          var last_year_concession_amount = parseInt($('#last_year_concession_amount').val() || 0);
                          var last_year_amount_balance = last_year_amount - (last_year_received_amount + last_year_concession_amount);
                          $('#last_year_balance_amount').val(last_year_amount_balance); 
                          if (last_year_amount_balance == 0) {
                            $("#last_year_balance_amount").css("color", "green");
                            } else {
                              $("#last_year_balance_amount").css("color", "red");
                            }
                    }
              });
              $("#stockinfotable").show();    
              $.ajax({ 
                url: 'FeesCollectionFile/grp/ajaxResetGrpTable.php',
                type: 'post',
                data: {"student_id":student_id},
                  success:function(html){
                    $("#updatedstockinfotable").empty();
                    $("#updatedstockinfotable").html(html);
                  }
                });
               
        });

        $('#student_name1').change(function () { 
          getstudents();
          
              });
              
              // $("#updatedstockinfotable").on('click','.printpo',function(){ 
              //   var currentRow=$(this).closest("tr"); 
              //   var fees_ids=currentRow.find("td:eq(0)").text();   
              //   var student_id=currentRow.find("td:eq(1)").text();  
              //   var pay_fees_id=currentRow.find("td:eq(2)").text(); 
              //   // $("#fees_ids").val(fees_ids);
              //    $.ajax({ 
              //    url: "FeesCollectionFile/grp/printFeesDetails.php",
              //    data: {"fees_ids":fees_ids,"student_id":student_id,"pay_fees_id":pay_fees_id},
              //    cache: false,
              //    type: "post",
              //    success: function(html){
              //      $("#poprintfield").html(html);
              //    }
              // });
              // });

              $("#updatedstockinfotable").on('click', '.printpo', function() {
                var currentRow = $(this).closest("tr");
                var fees_ids = currentRow.find("td:eq(0)").text();
                var student_id = currentRow.find("td:eq(1)").text();
                var receipt_date = currentRow.find("td:eq(3)").text();
                var receipt_number = currentRow.find("td:eq(4)").text();
                var academic_year = currentRow.find("td:eq(5)").text();
                var mergedParticularsArray = currentRow.find("td:eq(6)").text();
                var mergedAmountArray = currentRow.find("td:eq(7)").text();
            
                $.ajax({
                    url: "FeesCollectionFile/grp/printFeesDetails.php",
                    data: {
                        "fees_ids": fees_ids,
                        "student_id": student_id,
                        "receipt_date": receipt_date,
                        "receipt_number": receipt_number,
                        "academic_year": academic_year,
                        "mergedParticularsArray": mergedParticularsArray,
                        "mergedAmountArray": mergedAmountArray
                    },
                    cache: false,
                    type: "post",
                    success: function(html) {
                        $("#poprintfield").html(html);
                        // Convert the mergedAmountArray value to words
                        var amountInWords = convertNumberToWords(parseFloat(mergedAmountArray));
                        
                        // Update the amount in words in the text
                        $("#amountInWords").text(amountInWords);
                      }
                });
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
      // error:function(jqXHR, textStatus, errorThrown){
      //   console.log(errorThrown);
      // }
    });
    
  } else {
  
    // if not, clear the section and student dropdowns and return
    // $('#section').empty();
    // $('#section').append("<option value=''>Select Section</option>");
    $('#student_id').empty();
    $('#student_id').append("<option value=''>Select Student</option>");
    
  }

});

// $('#student_name1').change(function() {
//   var student_name1 = $("#student_name1").val();
      
// });



getstudents();

});
function getstudents(){ 
  var student_name1 = $("#student_name1").val();
  if(student_name1 == ''){}else{
  $.ajax({ 
    url: 'FeesCollectionFile/grp/ajaxEditTempStudent.php',
    type: 'post',
    data: {"student_name1":student_name1},
    dataType: 'json',
    success:function(response){ 
          
    $("#admission_number").val(response['admission_number']);
    $("#roll_number").val(response['studentrollno']);
      $("#section1").val(response['section']);
      $("#grp_amountre").val(response['grp_amountre']);
      $("#extra_amountre").val(response['extra_amountre']);
      $("#amenity_amountre").val(response['amenity_amountre']);$("#student_name").val(response['student_name']);
      $("#grp_amount").val(response['grp_amount']);
      $("#fees_id").val(response['fees_id']);
      $("#extra_amount").val(response['extra_amount']);
      $("#amenity_amount").val(response['amenity_amount']);
      $("#tranport_grp_amount").val(response['trans_grp_amount']);
      $("#tranport_received_amount").val(response['transport_received_fees_total']);
      $("#tranport_concession_amount").val(response['transport_concession_fees_total']); 
     
      $("#grp_concession_amount").val(response['grp_con']);
      $("#extra_concession_amount").val(response['extra_con']);
      $("#amenity_concession_amount").val(response['amenity_con']);

      $("#last_year_amount").val(response['totalSum']);
      $("#last_year_received_amount").val(response['grp_amounlast']);
      $("#last_year_concession_amount").val(response['grp_conlast']);

      // Grp Amount Balance
      var grp_amount = parseInt($('#grp_amount').val() || 0);
      var grp_amountre = parseInt($('#grp_amountre').val() || 0);
      var grp_concession = parseInt($('#grp_concession_amount').val() || 0);
      var amount_balance = grp_amount - (grp_amountre + grp_concession);
      
      $('#gross_balance_amount').val(amount_balance); 
      if (amount_balance == 0) {
          $("#gross_balance_amount").css("color", "green");
        } else {
          $("#gross_balance_amount").css("color", "red");
        }

        // Extra Amount Balance
        var extra_amount = parseInt($('#extra_amount').val() || 0);
        var extra_amountre = parseInt($('#extra_amountre').val() || 0);
        var extra_concession_amount = parseInt($('#extra_concession_amount').val() || 0);
        var extra_amount_balance = extra_amount - (extra_amountre + extra_concession_amount);
        
        $('#extra_balance_amount').val(extra_amount_balance); 
        if (extra_amount_balance == 0) {
            $("#extra_balance_amount").css("color", "green");
          } else {
            $("#extra_balance_amount").css("color", "red");
          }

        // Amenity Amount Balance 
        
        var amenity_amount = parseInt($('#amenity_amount').val() || 0);
        var amenity_amountre = parseInt($('#amenity_amountre').val() || 0);
        var amenity_concession_amount = parseInt($('#amenity_concession_amount').val() || 0);
        var amenity_amount_balance = amenity_amount - (amenity_amountre + amenity_concession_amount);
        
        $('#amenity_balance_amount').val(amenity_amount_balance); 
        if (amenity_amount_balance == 0) {
            $("#amenity_balance_amount").css("color", "green");
          } else {
            $("#amenity_balance_amount").css("color", "red");
          }

          // Transport Amount Calculation

          var tranport_grp_amount = parseInt($('#tranport_grp_amount').val() || 0);
          var tranport_received_amount = parseInt($('#tranport_received_amount').val() || 0);
          var tranport_concession_amount = parseInt($('#tranport_concession_amount').val() || 0);
          var transport_amount_balance = tranport_grp_amount - (tranport_received_amount + tranport_concession_amount);
          
          $('#tranport_balance_amount').val(transport_amount_balance); 
          if (transport_amount_balance == 0) {
              $("#tranport_balance_amount").css("color", "green");
            } else {
              $("#tranport_balance_amount").css("color", "red");
            }

            // Last Year Amount Calculation

          var last_year_amount = parseInt($('#last_year_amount').val() || 0);
          var last_year_received_amount = parseInt($('#last_year_received_amount').val() || 0);
          var last_year_concession_amount = parseInt($('#last_year_concession_amount').val() || 0);
          var last_year_amount_balance = last_year_amount - (last_year_received_amount + last_year_concession_amount);

          $('#last_year_balance_amount').val(last_year_amount_balance); 
          if (last_year_amount_balance == 0) {
              $("#last_year_balance_amount").css("color", "green");
            } else {
              $("#last_year_balance_amount").css("color", "red");
            }
  
            
          }
  
    });
    $("#stockinfotable").show();    
    $.ajax({ 
      url: 'FeesCollectionFile/grp/ajaxResetGrpTable.php',
      type: 'post',
      data: {"student_id":student_name1},
        success:function(html){
          $("#updatedstockinfotable").empty();
          $("#updatedstockinfotable").html(html);
        }
      });
      $("table tbody tr td:first-child").css("background-color", "#1b6aaa6e");
      $("table tbody tr td:first-child").css("color", "white");
    }
 } 
function payFees() {
  var studentId = document.getElementById("student_id").value; 
  var studentName = document.getElementById("student_name1").value;
  if (studentId) {
    var url = "pay_fees&student_id=" + studentId;
    var url = "pay_fees&upd=" + studentId;
      window.location.href = url;
  } else {
    var url = "pay_fees&student_name=" + studentName;
    var url = "pay_fees&upd=" + studentName;
    window.location.href = url;
  }
}
function payTrasportFees() {
  var studentId = document.getElementById("student_id").value; 
  var studentName = document.getElementById("student_name1").value;
  if (studentId) {
    // var url = "transport_fees&student_id=" + studentId;
    var url = "transport_fees&upd=" + studentId;
      window.location.href = url;
  } else {
    // var url = "transport_fees&student_name=" + studentName;
    var url = "transport_fees&upd=" + studentName;
    window.location.href = url;
  }
}

function payLastYearFees() {
  var studentId = document.getElementById("student_id").value; 
  var studentName = document.getElementById("student_name1").value;
  if (studentId) {
    var url = "last_year_fees_pay&last=" + studentId;
      window.location.href = url;
  } else {
    var url = "last_year_fees_pay&last=" + studentName;
    window.location.href = url;
  }
}






