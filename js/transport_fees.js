// Document is ready
$(document).ready(function(){
  sum15='0';
  $('.amount').each(function() {
    sum15 += parseInt($(this).val());
  });
  // // Get the current year
  // var currentYear = new Date().getFullYear();

  // // Generate a list of academic years for the dropdown
  // var dropdown = document.getElementById('academic_year');
  // for (var i = currentYear; i >= currentYear - 4; i--) {
  //   var option = document.createElement('option');
  //   option.value = i + '-' + (i + 1);
  //   option.text = i + '-' + (i + 1);
  //   dropdown.appendChild(option);
  // }
  setTimeout(function(){
  $("input.amount_balance").each(function(){
     var value = parseInt($(this).val());
    //  console.log("value",value);
     if (value == 0){
      $(this).closest('tr').find('input.amount_recieved, input.transport_concession_amount').prop('readonly', true);
     }else{
      $(this).closest('tr').find('input.amount_recieved, input.transport_concession_amount').prop('readonly', false);
      
  }
});
},1000)

    // Find all instances of the amount_balance input
    $('input.grp_amount').each(function() {
      // Check if the amount_balance value is 0
      if ($(this).val() === '0') {
        // Set the transport_concession_amount and amount_recieved inputs to readonly
        $(this).closest('tr').find('input.transport_concession_amount, input.amount_recieved').prop('readonly', true);
        // $(this).closest('tr').find('.transport_concession_amount').val('0');
        // $(this).closest('tr').find('.amount_recieved').val('0');
        // $(this).closest('tr').find('.amount_balance').val('0');
      } else {
        // Remove the readonly attribute from the transport_concession_amount and amount_recieved inputs
        $(this).closest('tr').find('input.transport_concession_amount, input.amount_recieved').prop('readonly', false);
      }
    });
  

  $("#cash_payment").show();

  // get Pay Reciept Code

        $.ajax({
          url: "ajaxgetpaytransportreceiptcode.php",
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
          $('.amount_recieved').on('change', function() {
            var $row = $(this).closest('tr');
            var grp_amount = parseInt($row.find('.grp_amount').val());
            var amount_received = parseInt($row.find(this).val());

            if (amount_received > grp_amount) {
              alert('Fees received cannot be greater than  amount due.');
              $(this).val('');
              $row.find(".amount_balance").val('0');
              $('#fees_collected').val('0');
              $('#fees_balance').val(sum);

            }

            
          });

             

          //   //  Alert Message Grater Than scholarship Amount entered
          //   $('.fees_scholarship').on('change', function() { 
          //     var fees_scholarship = parseInt($('.fees_scholarship').val());
          //     var fees_balance = parseInt($('.fees_balance').val());
          //     if (fees_scholarship >fees_balance) {
          //       alert('Scholarship Fees is greater than balance fees!');
          //       $( ".fees_scholarship" ).val('0');
          //       var fees_total1 = $('#fees_total').val(); 
          //     $('#final_amount_recieved').val(fees_total1);
    
          // // total balance default value
          //     var fees_balance = $('#final_amount_recieved').val();
              
          //     $('#fees_balance').val(fees_balance);
          //     } 
              
          //   });

      // // sum amountreceived
     
      // $('.sum1').keyup(function(){
      //   var sum = 0;
      //   $('.sum1').each(function(){
      //     var value11 = $(this).val();
      //     if(!isNaN(value11) && value11 != ''){
      //       sum = parseInt(sum) + parseInt(value11);
      //     }
      //   })
      //   $('#fees_collected').val(sum);
      //   $('#transport_received_fees_total').val(sum);
      //   var final_amount_recieved = parseInt($('#final_amount_recieved').val() || 0) - sum; 
      //   $('#fees_balance').val(final_amount_recieved);
        
      // });
// sum keyup concession amount
      // $('.transport_concession_amount').keyup(function(){
      //   var sum = 0;
      //   $('.transport_concession_amount').each(function(){
      //     var value11 = $(this).val();
      //     if(!isNaN(value11) && value11 != ''){
      //       sum = parseInt(sum) + parseInt(value11);
      //     }
      //   })
       
      //   $('#transport_concession_fees_total').val(sum);
      // });

      // $('.transport_concession_amount').change(function(){
      //   var sum2 = 0;
      //   $('.transport_concession_amount').each(function(){
      //     var value11 = $(this).val();
      //     if(!isNaN(value11) && value11 != ''){
      //       sum2 = parseInt(sum2) + parseInt(value11); 
            
      //     }
      //   })

      //   var final_amount = parseInt($('#fees_total').val() || 0) - sum2;
      //   $('#final_amount_recieved').val(final_amount);

      //   var fees_collected =  final_amount - parseInt($('#fees_collected').val() || 0); 
        
      //   $('#fees_balance').val(fees_collected);
        
        
      // });

          
      // sum amount
     
      var sum = 0;
     
      $('#general_concessionTable .grp_amount').each(function() {
          sum += parseInt($(this).val());
      });
      var sum14 = 0;
      $('#general_concessionTable .transport_concession_amount,.transport_concession_amount12').each(function() {
        sum14 += parseInt($(this).val());
      });
      var sum13 = 0;
      $('#general_concessionTable .amount_recieved,.amount_recieved12').each(function() {
        sum13 += parseInt($(this).val());
      });
      var sum12 = 0;
      $('#general_concessionTable .amount_balance').each(function() {
        sum12 += parseInt($(this).val());
      });
      
      console.log("grp_amount",sum);
      console.log("amount_recieved",sum13);
      console.log("transport_concession_amount",sum14);
      console.log("amount_balance",sum12);
      $("#fees_total").val(sum);
      $("#transport_fees_total").val(sum);
      $("#final_amount_recieved").val(sum - sum14);
      $("#transport_concession_fees_total").val(sum14);
      $("#transport_concession_fees_total").val();
      $("#fees_collected").val(sum13);
      $("#fees_balance").val(sum12);
      sum17=0;
          $('#general_concessionTable .transport_concession_amount').each(function() {
          sum17 += parseInt($(this).val());
      });
      $("#transport_concession_amount").val(sum17);

      sum18=0;
          $('#general_concessionTable .amount_recieved').each(function() {
          sum18 += parseInt($(this).val());
      });
      $("#transport_received_fees_total").val(sum18); 



      // $('#fees_total').val(sum);
      // $('#transport_fees_total').val(sum);
          
      //       $(document).on("keyup", '.other_charges_recieved, .fees_scholarship', function() { 
      //     var fees_total = sum + parseInt($('.other_charges_recieved').val() || 0);
          
      //     $('#fees_total').val(fees_total);
      //     $('#transport_fees_total').val(fees_total);
      //     $('#final_amount_recieved').val(fees_total);
      //     $('#fees_balance').val(fees_total);

      //     var fees_scholarship = parseInt($('.fees_scholarship').val() || 0);
      //     var final_amount_recieved = fees_total - fees_scholarship;
      //     $('.final_amount_recieved').val(final_amount_recieved);
          
      //     var final_amount_recieved1 = parseInt($('#final_amount_recieved').val() || 0); 
      //     var fees_collected =  final_amount_recieved1 - parseInt($('#fees_collected').val() || 0); 

      //     $('#fees_balance').val(final_amount_recieved);
      //     $('#fees_balance').val(fees_collected);

      // });

      // // final amount received default value
      //     var fees_total1 = $('#fees_total').val(); 
      //     $('#final_amount_recieved').val(fees_total1);

      // // total balance default value
      //     var fees_balance = $('#final_amount_recieved').val();

      //     $('#fees_balance').val(fees_balance);
          // var sum = 0;

          // $('.amount_recieved').each(function() {
          //   var value = $(this).val();
          //   if (value !== '') {
          //     sum += parseInt(value);
          //   }
          // });

          // var sum2 =0;
          // $('.transport_concession_amount').each(function() {
          //   var value = $(this).val();
          //   if (value !== '') {
          //     sum2 += parseInt(value);
          //   }
          // });

          // var sum3 =0;
          // $('.amount_balance').each(function() {
          //   var value = $(this).val();
          //   if (value !== '') {
          //     sum3 += parseInt(value);
          //   }
          // });

          // // console.log(`${sum}, ${sum2}`);
          // $('#final_amount_recieved').val(fees_total1 - sum2);
          // $('#fees_collected').val(sum);
          // $('#fees_balance').val(sum3);

          // balance amount for each row
//  // balance amount for each row
//  $(document).on("blur", '.amount_recieved,.grp_concession_amount', function(){
//   var $row = $(this).closest('tr'); 
//   var grp_amount = parseInt($row.find('.grp_amount').val(), 10);
//   var amount_recieved = parseInt($row.find('.amount_recieved').val(), 10);
//   var grp_concession_amount = parseInt($row.find('.grp_concession_amount').val(), 10);
//   var grp_concession_amount12 = parseInt($row.find('.grp_concession_amount12').val(), 10);
//   var amount_balance12 = parseInt($row.find('.amount_balance12').val(), 10);
//   var sub = parseInt($row.find('.amount_recieved12').val(), 10);
//   var ans = grp_amount - (amount_recieved + grp_concession_amount12 + grp_concession_amount) ;
//   var amount_balance = ans - sub;
//      if (amount_balance === 0) {
//     $row.find('.amount_recieved').prop('readonly', true);
//     $row.find('.grp_concession_amount').prop('readonly', true);
// } else {
//     $row.find('.grp_concession_amount').prop('readonly', false);
// }
//   $row.find('.amount_balance').val(amount_balance);

// });
          // $(document).on("blur", '.grp_amount, .amount_recieved', function(){ 
          //   var $row = $(this).closest('tr');
          //   var grp_amount = parseInt($row.find('.grp_amount').val(), 10);
          //   var amount_recieved = parseInt($row.find('.amount_recieved').val(), 10);
          //   var transport_concession_amount = parseInt($row.find('.transport_concession_amount').val(), 10);
          //   var transport_concession_amount12 = parseInt($row.find('.transport_concession_amount12').val(), 10);
          //   var amount_balance12 = parseInt($row.find('.amount_balance12').val(), 10);
          //  var sub = parseInt($row.find('.amount_recieved12').val(), 10);
          //  var ans = grp_amount - (amount_recieved + transport_concession_amount12 + transport_concession_amount) ;
          //  console.log("ans",ans);
          //  var amount_balance = ans - sub;
          //  console.log("amount_balance",amount_balance);

          //   // var amount_balance = grp_amount - amount_recieved;
          //   if (amount_balance === 0) {
          //     $row.find('.transport_concession_amount').prop('readonly', true);
          // } else {
          //     $row.find('.transport_concession_amount').prop('readonly', false);
          // }
          // $row.find('.amount_balance').val(amount_balance);
          
          // });
          
          // $(document).on("change", '.amount_balance,.transport_concession_amount', function(){

          //   var $row = $(this).closest('tr');
          //   var amount_balance = parseInt($row.find('.amount_balance').val(), 10); 
          //   var sub = parseInt($row.find('.amount_recieved12').val(), 10);
          //   var transport_concession_amount = parseInt($row.find('.transport_concession_amount').val(), 10);
          //   var amount_balance1 = amount_balance  - transport_concession_amount;
          //   $row.find('.amount_balance').val(amount_balance1);

          //   console.log("amount_balance1",amount_balance1);
          //   if (amount_balance1 === 0) {
          //     $row.find('.amount_recieved').prop('readonly', true);
          //     $row.find('.transport_concession_amount').prop('readonly', true);
          // } else {
          //     $row.find('.amount_recieved').prop('readonly', false);
          //     $row.find('.transport_concession_amount').prop('readonly', false);

          // }
      
          // });
          
          // var $row = $(this).closest('tr');
          // var default_fees_balance = $('.grp_amount').val(); 
          // $row.find('.amount_balance').val(default_fees_balance);
      
          //   $('.extra_amount_recieved').blur(function(){ 
          //   $('.extra_amount_recieved').each(function(){
          //     if($(this).val() == ''){
          //       $(this).parent().prev().prev().prev().removeAttr('value');
          //       $(this).parent().prev().prev().children().removeAttr('value');
          //       $(this).parent().prev().children().removeAttr('value');
          //       $(this).parent().next().find('input').val('');

          //     }
          //   });

          // });

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

// balance amount for each row
$(document).on("blur", '.amount_recieved,.transport_concession_amount', function(){
  var $row = $(this).closest('tr'); 
  var grp_amount = parseInt($row.find('.grp_amount').val(), 10);
  var amount_recieved = parseInt($row.find('.amount_recieved').val(), 10);
  var grp_concession_amount = parseInt($row.find('.transport_concession_amount').val(), 10);
  var grp_concession_amount12 = parseInt($row.find('.transport_concession_amount12').val(), 10);
  var amount_balance12 = parseInt($row.find('.amount_balance12').val(), 10);
  var sub = parseInt($row.find('.amount_recieved12').val(), 10);
  var ans = grp_amount - (amount_recieved + grp_concession_amount12 + grp_concession_amount) ;
  var amount_balance = ans - sub;
     if (amount_balance === 0) {
    $row.find('.amount_recieved').prop('readonly', true);
    $row.find('.transport_concession_amount').prop('readonly', true);
    } else {
    $row.find('.amount_recieved').prop('readonly', false);
    $row.find('.transport_concession_amount').prop('readonly', false);
}
  $row.find('.amount_balance').val(amount_balance);
  calac();
});
function calac(){

  var sum = 0;
   
  $('#general_concessionTable .grp_amount').each(function() {
      sum += parseInt($(this).val());
  });
  var sum14 = 0;
  $('#general_concessionTable .transport_concession_amount,.transport_concession_amount12').each(function() {
    sum14 += parseInt($(this).val());
  });
  var sum13 = 0;
  $('#general_concessionTable .amount_recieved,.amount_recieved12').each(function() {
    sum13 += parseInt($(this).val());
  });
  var sum12 = 0;
  $('#general_concessionTable .amount_balance').each(function() {
    sum12 += parseInt($(this).val());
  });
  sum17=0;
  $('#general_concessionTable .transport_concession_amount').each(function() {
    sum17 += parseInt($(this).val());
  });
  sum18=0;
  $('#general_concessionTable .amount_recieved').each(function() {
  sum18 += parseInt($(this).val());
});
  $("#transport_received_fees_total").val(sum18); 
  $("#fees_total").val(sum);
  $("#transport_fees_total").val(sum);
  $("#final_amount_recieved").val(sum - sum14);
  $("#transport_concession_fees_total").val(sum17);
  $("#transport_concession_fees_total").val();
  $("#fees_collected").val(sum13);
  $("#fees_balance").val(sum12);


}
//  Alert Message Grater Than Amount entered
$('.unit').on('change', function() { 

  var fees_collected = parseInt($('#final_amount_recieved').val());
  var result = parseInt($('.result').val());
  if (result > fees_collected) {
    alert('Fees collected is greater than total!');
  }
 
});

	