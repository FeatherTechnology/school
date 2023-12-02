// Document is ready
$(document).ready(function(){

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

  $("#cash_payment").show();

  // get Pay Reciept Code

        $.ajax({
          url: "ajaxgetpaylastcode.php",
          data: {},
          cache: false,
          type: "post",
          dataType: "json",
        success: function (data) { 
          $("#receipt_number").val(data);
        }
        });

        $('input[name="collection_info"]').click(function(){
          var value = $(this).val();
          
          if(value == "Cash Payment"){
            $("#cash_payment").show();
            $("#cheque_payment").hide();
            $("#neft_payment").hide();

          } else if(value == "Cheque"){
            $("#cash_payment").hide();
            $("#cheque_payment").show();
            $("#neft_payment").hide();
          }
          else if(value == "NEFT"){
            $("#cash_payment").hide();
            $("#cheque_payment").hide();
            $("#neft_payment").show();
          }
        });
   
        $(document).on("keyup", '.unit', function(){ 
          var qty = $(this).parents('tr').find('td .qty').val();
          var unit = $(this).parents('tr').find('td .unit').val();
          if(unit == ''){ 
            // var amount = parseInt(qty)*parseInt(unit);
            var process = $(this).parents('tr').find('td .amount').val('0');
            fnAlltotal();
        }else{
          var amount = parseInt(qty)*parseInt(unit);
          var process = $(this).parents('tr').find('td .amount').val(amount);
          fnAlltotal();
        }
        
        });
        
        function fnAlltotal(){
          var total=0
          var event_fee = $("#event_fee").val();
        
          $(".amount").each(function(){
               total += parseFloat($(this).val()||0);
          });
          $(".result").val(total);
          $("#balance").val(total-event_fee);
        }

      //  Alert Message Grater Than Amount entered
          $('.amount_recieved,.extra_amount_recieved,.amenity_amount_recieved').on('change', function() {
            var $row = $(this).closest('tr');
            var grp_amount = parseInt($row.find('.grp_amount').val());
            var amount_received = parseInt($row.find(this).val());

            var extra_amount = parseInt($row.find('.extra_amount').val());
            var extra_amount_received = parseInt($row.find(this).val());

            var amenity_amount = parseInt($row.find('.amenity_amount').val());
            var amenity_amount_received = parseInt($row.find(this).val());
            
            if (amount_received > grp_amount) {
              alert('Fees received cannot be greater than  amount due.');
              $(this).val('');
              $row.find(".amount_balance").val('0');

            }else if (extra_amount_received > extra_amount) {
              alert('Fees received cannot be greater than  amount due.');
              $(this).val('');
              $row.find(".extra_amount_balance").val('0');

            }else if (amenity_amount_received > amenity_amount) {
              alert('Fees received cannot be greater than  amount due.');
              $(this).val('');
              $row.find(".amenity_amount_balance").val('0');
            }

            
          });

          //  Alert Message Grater Than Amount entered
          $('.unit').on('change', function() { 
            var fees_collected = parseInt($('.fees_collected').val());
            var result = parseInt($('.result').val());
            if (result >fees_collected) {
              alert('Fees collected is greater than total!');
            } 
          });

            //  Alert Message Grater Than scholarship Amount entered
            $('.fees_scholarship').on('change', function() { 
              var fees_scholarship = parseInt($('.fees_scholarship').val());
              var fees_balance = parseInt($('.fees_balance').val());
              if (fees_scholarship >fees_balance) {
                alert('Scholarship Fees is greater than balance fees!');
                $( ".fees_scholarship" ).val('0');
                var fees_total1 = $('#fees_total').val(); 
                $('#final_amount_recieved').val(fees_total1);
                $('#final_received_fees_total').val(fees_total1);
    
          // total balance default value
              var fees_balance = $('#final_amount_recieved').val();
              
              $('#fees_balance').val(fees_balance);
              } 
              
            });

      // sum amountreceived
     
      $('.sum1').keyup(function(){
        var sum = 0;
        $('.sum1').each(function(){
          var value11 = $(this).val();
          if(!isNaN(value11) && value11 != ''){
            sum = parseInt(sum) + parseInt(value11);
          }
        })
        $('#fees_collected').val(sum);
        $('#final_fees_collected').val(sum);
        var final_amount_recieved = parseInt($('#final_amount_recieved').val() || 0) - sum; 
        $('#fees_balance').val(final_amount_recieved);
        $('#final_fees_balance').val(final_amount_recieved);
        
      });
      
       // grp amount
       var sumgrp = 0;
       $('#general_concessionTable .grp_amount').each(function() { 
        sumgrp += parseInt($(this).val());
       });
       
       $('#grp_fees_total').val(sumgrp);

       // extra amount
       var sumextra = 0;
       $('#general_concessionTable1 .extra_amount').each(function() { 
        sumextra += parseInt($(this).val());
       });
       
       $('#extra_fees_total').val(sumextra);

       // amenity amount
        var sumamenity = 0;
        $('#general_concessionTable2 .amenity_amount').each(function() {
        sumamenity += parseInt($(this).val());
        });

        $('#amenity_fees_total').val(sumamenity);


         // grp amount received
         function updateSum() {
          var sumgrpre = 0;
          $('#general_concessionTable .amount_recieved').each(function() { 
            sumgrpre += parseInt($(this).val()) || 0;
          });
          
          $('#grp_fees_total_received').val(sumgrpre);
        }
        // Attach the keyup event listener to the input fields
        $('#general_concessionTable .amount_recieved').on('keyup', function() {
          updateSum();
        });
        // Initial calculation on page load
        updateSum();


       // Define a function to calculate and update the sums
  function updateSums() {
    var sumextrare = 0;
    $('#general_concessionTable1 .extra_amount_recieved').each(function() { 
      sumextrare += parseInt($(this).val()) || 0;
    });
    
    $('#extra_fees_total_received').val(sumextrare);
    
    var sumamenityre = 0;
    $('#general_concessionTable2 .amenity_amount_recieved').each(function() {
      sumamenityre += parseInt($(this).val()) || 0;
    });
    
    $('#amenity_fees_total_received').val(sumamenityre);

  }
  
  // Attach the keyup event listener to the input fields
  $('#general_concessionTable1 .extra_amount_recieved, #general_concessionTable2 .amenity_amount_recieved').on('keyup', function() {
    updateSums();
  });
  
  // Initial calculation on page load
  updateSums();

  function updateBalance() {
   
    var sumgrpbalance = 0;
    $('#general_concessionTable .amount_balance').each(function() {
      sumgrpbalance += parseInt($(this).val()) || 0;
    });
    
    $('#grp_fees_balance').val(sumgrpbalance);

    var sumextrabalance = 0;
    $('#general_concessionTable1 .extra_amount_balance').each(function() { 
      sumextrabalance += parseInt($(this).val()) || 0; 
    });
    
    $('#extra_fees_balance').val(sumextrabalance);

    var sumamenitybalance = 0;
    $('#general_concessionTable2 .amenity_amount_balance').each(function() { 
      sumamenitybalance += parseInt($(this).val()) || 0; 
    });
    
    $('#amenity_fees_balance').val(sumamenitybalance);

  }

  
  
  // Attach the keyup event listener to the input fields
  $('#general_concessionTable .amount_recieved, #general_concessionTable1 .extra_amount_recieved, #general_concessionTable2 .amenity_amount_recieved').on('blur', function() {
    updateBalance();
  });

  updateBalance();

// Sum Concession
function updateConcession() {
   
  var sumgrpbalance = 0;
  $('#general_concessionTable .grp_concession_amount').each(function() {
    sumgrpbalance += parseInt($(this).val()) || 0;
  });
  
  $('#grp_concession_fees').val(sumgrpbalance);

  var sumextrabalance = 0;
  $('#general_concessionTable1 .extra_concession_amount').each(function() { 
    sumextrabalance += parseInt($(this).val()) || 0; 
  });
  
  $('#extra_concession_fees').val(sumextrabalance);

  var sumamenitybalance = 0;
  $('#general_concessionTable2 .amenity_concession_amount').each(function() { 
    sumamenitybalance += parseInt($(this).val()) || 0; 
  });
  
  $('#amenity_concession_fees').val(sumamenitybalance);

}



// Attach the keyup event listener to the input fields
$('#general_concessionTable .grp_concession_amount, #general_concessionTable1 .extra_concession_amount, #general_concessionTable2 .amenity_concession_amount').on('blur', function() {
  updateConcession();
});

updateConcession();

      // sum amount
     
      var sum = 0;
      $('#general_concessionTable .grp_amount, .extra_amount, .amenity_amount').each(function() {
          sum += parseInt($(this).val());
      });
      
      $('#fees_total').val(sum);
      $('#final_fees_total').val(sum);
      
      $(document).on("keyup", '.other_charges_recieved, .fees_scholarship', function() { 
          var fees_total = sum + parseInt($('.other_charges_recieved').val() || 0);

          $('#fees_total').val(fees_total);
          $('#final_amount_recieved').val(fees_total);
          $('#fees_balance').val(fees_total);
          $('#final_fees_balance').val(fees_total);

          var fees_scholarship = parseInt($('.fees_scholarship').val() || 0);
          var final_amount_recieved = fees_total - fees_scholarship;
          $('.final_amount_recieved').val(final_amount_recieved);
          $('.final_received_fees_total').val(final_amount_recieved);

          var final_amount_recieved1 = parseInt($('#final_amount_recieved').val() || 0); 
          var fees_collected =  final_amount_recieved1 - parseInt($('#fees_collected').val() || 0); 

          $('#fees_balance').val(final_amount_recieved);
          $('#fees_balance').val(fees_collected);
          $('#final_fees_balance').val(fees_collected);
          $('#final_fees_balance').val(fees_collected);
          
      });

      $(document).on("keyup", '.fees_scholarship', function() { 
          
        var fees_scholarship = $('#fees_scholarship').val();

        $('#final_concession_fees_total').val(fees_scholarship);
      });

      // final amount received default value
          var fees_total1 = $('#fees_total').val(); 
          $('#final_amount_recieved').val(fees_total1);
          $('#final_received_fees_total').val(fees_total1);

      // total balance default value
          var fees_balance = $('#final_amount_recieved').val();
          
          $('#fees_balance').val(fees_balance);
          $('#final_fees_balance').val(fees_balance);
         
          var $row = $(this).closest('tr');
          var default_fees_balance = $('.grp_amount').val(); 
          $row.find('.amount_balance').val(default_fees_balance);

          // balance amount for each row
          $(document).on("blur", '.amount_recieved,.grp_concession_amount', function(){
              var $row = $(this).closest('tr'); 
              var grp_amount = parseInt($row.find('.grp_amount').val(), 10);
              var amount_recieved = parseInt($row.find('.amount_recieved').val(), 10);
              var grp_concession_amount = parseInt($row.find('.grp_concession_amount').val(), 10);
              var amount_balance = grp_amount - (amount_recieved + grp_concession_amount);
              if (amount_balance === 0) {
                $row.find('.grp_concession_amount').prop('readonly', true);
            } else {
                $row.find('.grp_concession_amount').prop('readonly', false);
            }
              $row.find('.amount_balance').val(amount_balance);
              
            });
            $(document).on("blur", '.extra_concession_amount,.extra_amount_recieved', function(){ 
              var $row = $(this).closest('tr');
              var extra_amount = parseInt($row.find('.extra_amount').val(), 10);
              var extra_amount_recieved = parseInt($row.find('.extra_amount_recieved').val(), 10);
              var extra_concession_amount = parseInt($row.find('.extra_concession_amount').val(), 10);
              var extra_amount_balance = extra_amount - (extra_amount_recieved + extra_concession_amount);
              if (extra_amount_balance === 0) {
                $row.find('.extra_concession_amount').prop('readonly', true);
            } else {
                $row.find('.extra_concession_amount').prop('readonly', false);
            }
              $row.find('.extra_amount_balance').val(extra_amount_balance);
            });
            $(document).on("blur", '.amenity_concession_amount,.amenity_amount_recieved', function(){ 
              var $row = $(this).closest('tr');
              var amenity_amount = parseInt($row.find('.amenity_amount').val(), 10);
              var amenity_amount_recieved = parseInt($row.find('.amenity_amount_recieved').val(), 10);
              var amenity_concession_amount = parseInt($row.find('.amenity_concession_amount').val(), 10);
              var amenity_amount_balance = amenity_amount - (amenity_amount_recieved + amenity_concession_amount);
              if (amenity_amount_balance === 0) {
                $row.find('.amenity_concession_amount').prop('readonly', true);
            } else {
                $row.find('.amenity_concession_amount').prop('readonly', false);
            }
              $row.find('.amenity_amount_balance').val(amenity_amount_balance);
            });

  
       // Find all instances of the amount_balance input
    $('input.grp_amount,extra_amount,amenity_amount').each(function() {
      // Check if the amount_balance value is 0
      if ($(this).val() === '0') {
        // Set the transport_concession_amount and amount_recieved inputs to readonly
        $(this).closest('tr').find('input.grp_concession_amount,extra_concession_amount,.amenity_concession_amount, input.amount_recieved,.extra_amount_recieved,.amenity_amount_recieved').prop('readonly', true);
        $(this).closest('tr').find('.grp_concession_amount').val('0');
        $(this).closest('tr').find('.extra_concession_amount').val('0');
        $(this).closest('tr').find('.amenity_concession_amount').val('0');
        $(this).closest('tr').find('.amount_recieved').val('0');
        $(this).closest('tr').find('.extra_amount_recieved').val('0');
        $(this).closest('tr').find('.amenity_amount_recieved').val('0');
        $(this).closest('tr').find('.amount_balance').val('0');
        $(this).closest('tr').find('.extra_amount_balance').val('0');
        $(this).closest('tr').find('.amenity_amount_balance').val('0');
      } else {
        // Remove the readonly attribute from the transport_concession_amount and amount_recieved inputs
        $(this).closest('tr').find('input.grp_concession_amount,extra_concession_amount,.amenity_concession_amount, input.amount_recieved,.extra_amount_recieved,.amenity_amount_recieved').prop('readonly', false);
      }
    });

    $(document).on("change", '.amount_balance,.grp_concession_amount', function(){ 
      var $row = $(this).closest('tr');
      var amount_balance = parseInt($row.find('.amount_balance').val(), 10); 
      var grp_concession_amount = parseInt($row.find('.grp_concession_amount').val(), 10);
      var amount_balance1 = amount_balance - grp_concession_amount;
      $row.find('.amount_balance').val(amount_balance1);
      if (amount_balance1 === 0) {
        $row.find('.amount_recieved').prop('readonly', true);
    } else {
        $row.find('.amount_recieved').prop('readonly', false);
    }
    });

    $(document).on("change", '.extra_amount_balance,.extra_concession_amount', function(){ 
      var $row = $(this).closest('tr');
      var extra_amount_balance = parseInt($row.find('.extra_amount_balance').val(), 10); 
      var extra_concession_amount = parseInt($row.find('.extra_concession_amount').val(), 10);
      var amount_balance1 = extra_amount_balance - extra_concession_amount;
      $row.find('.extra_amount_balance').val(amount_balance1);
      if (amount_balance1 === 0) {
        $row.find('.extra_amount_recieved').prop('readonly', true);
    } else {
        $row.find('.extra_amount_recieved').prop('readonly', false);
    }
    });

    $(document).on("change", '.amenity_amount_balance,.amenity_concession_amount', function(){ 
      var $row = $(this).closest('tr');
      var amenity_amount_balance = parseInt($row.find('.amenity_amount_balance').val(), 10); 
      var amenity_concession_amount = parseInt($row.find('.amenity_concession_amount').val(), 10);
      var amount_balance1 = amenity_amount_balance - amenity_concession_amount;
      $row.find('.amenity_amount_balance').val(amount_balance1);
      if (amount_balance1 === 0) {
        $row.find('.amenity_amount_recieved').prop('readonly', true);
    } else {
        $row.find('.amenity_amount_recieved').prop('readonly', false);
    }
    });

    $('.concession_amount').change(function() {
      var sum2 = 0;
      $('.concession_amount').each(function() {
        var value11 = $(this).val();
        if (!isNaN(value11) && value11 != '') {
          sum2 = parseInt(sum2) + parseInt(value11);
        }
      });
    
      var final_amount = parseInt($('#fees_total').val() || 0) - sum2;
      $('#final_amount_recieved').val(final_amount);
    
      var fees_collected = final_amount - parseInt($('#fees_collected').val() || 0);
      $('#fees_balance').val(fees_collected);
    });
    
    
       
  
  $('#submitpayfees').click(function () {	
                $('.amount_recieved, .extra_amount_recieved, .amenity_amount_recieved').each(function(){
                  if($(this).val() == ''){
                    $(this).parent().prev().prev().prev().removeAttr('value');
                    $(this).parent().prev().prev().children().removeAttr('value');
                    $(this).parent().prev().children().removeAttr('value');
                    $(this).parent().next().find('input').val('');

                  }
                  
                })
            });
        
  });


   

	