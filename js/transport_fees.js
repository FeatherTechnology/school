// Document is ready
$(document).ready(function(){

  // Get the current year
  var currentYear = new Date().getFullYear();
  var user_academic_year = $('#user_academic_year').val();
  // Generate a list of academic years for the dropdown
  let dropdown = document.getElementById('academic_year');
  for (let i = currentYear; i >= currentYear - 4; i--) {
    let option = document.createElement('option');
    option.value = i + '-' + (i + 1);
    option.text = i + '-' + (i + 1);
    let selectValue = i + '-' + (i + 1);
    let selected = '';
    if(selectValue == user_academic_year){
      selected = 'selected';
    }
    option.selected = selected;
    dropdown.appendChild(option);
  }
  
  $('input[name="payment_mode"]').click(function(){
    var value = $(this).val();
    
    if(value == "cash_payment"){
      $("#cash_payment").show();
      $("#cheque_payment").hide();
      $("#neft_payment").hide();
  
    } else if(value == "cheque"){
      $("#cash_payment").hide();
      $("#cheque_payment").show();
      $("#neft_payment").hide();
    }
    else if(value == "neft"){
      $("#cash_payment").hide();
      $("#cheque_payment").hide();
      $("#neft_payment").show();
    }
  });
  
  $('.cashreceive').keyup(function(){
    var cash = ($(this).parent().parent().find('.cash').val()) * ($(this).val());
    $(this).parent().parent().find('.amount').val(cash);
    
    var totalAmount = getCollectedAmount();
    
    var feeCollected = $('#fees_collected').val();
    if(totalAmount > feeCollected){
      alert('Please Enter Less than Fees Collected.')
      $(this).parent().parent().find('.cashreceive').val('0');
      $(this).parent().parent().find('.amount').val('0');
      var calcTotalAmount = getCollectedAmount(); 
      $('#total_amount').val(calcTotalAmount);
    }else{
      $('#total_amount').val(totalAmount);
    }
  });//Denomination cash Calc
  
  $('#cheque_amount').keyup(function(){
    var cheque = $(this).val();
    var feeCollect = $('#fees_collected').val();
    if(cheque > feeCollect){
      alert('Please Enter Less than Fees Collected.')
      $(this).val('')
    }
  });//Denomination Cheque Calc 
  
  $('#neft_amount').keyup(function(){
    var neft = $(this).val(); 
    var fee_collect = $('#fees_collected').val();
    if(neft > fee_collect){
      alert('Please Enter Less than Fees Collected.')
      $(this).val('')
    }
  });//Denomination NEFT Calc 

}); //Document END///

$(function(){
  getReceiptCode(); //Receipt Number;
  getFeesTableFunc();
});

function getFeesTableFunc(){
  var academicYear = $('#academic_year').val();
  var admissionFormId = $('#admission_form_id').val();
  var medium = $('#student_medium').val();
  var studentType = $('#students_type').val();
  var standard = $('#standard_id').val(); 
  getTransportFeesDetails(admissionFormId, academicYear, medium, studentType, standard);
  setTimeout(() => { 
    functionAfterAjax();
    getTotalFeeToBeCollected();//Fees to be collected total.
    getScholarshipTotal(); //Scholarship amount.
    
  }, 1500);
}

function getReceiptCode(){
  // get Pay Reciept Code
  $.ajax({
    url: "ajaxFiles/ajaxgetpaytransportreceiptcode.php",
    data: {},
    cache: false,
    type: "post",
    dataType: "json",
  success: function (data) { 
    $("#receipt_number").val(data);
  }
  });
}

function getTransportFeesDetails(admissionFormId, academicYear, medium, studentType, standard){
  $.ajax({
    type : 'POST',
    url : 'TransportFeesMaster/getTransportFeesTable.php',
    data : {'admissionFormId': admissionFormId,'academicYear': academicYear,'medium': medium,'studentType': studentType,'standard': standard},
    success:(function(reponse){
      $('#transport_fees_table_body').empty();
      $('#transport_fees_table_body').html(reponse);
    })
  })
}

function functionAfterAjax(){

  //Check Amount, if 0 then set row as readonly
  $('.transportfeesamnt').each(function(){
    var row = $(this).closest('tr');
    if (parseFloat($(this).val()) <= 0) {
        row.find('input').prop('readonly', true);
    }
  })

  $('.transportfeesreceived, .transportfeesscholarship').keyup(function(){
    var feeamnt = parseInt($(this).parent().parent().find('.transportfeesreceived').val());
    var scholaramnt = parseInt($(this).parent().parent().find('.transportfeesscholarship').val());
    var grpfeeamnt = parseInt($(this).parent().parent().find('.transportfeesamnt').val());
    var totalCollectgrpFees = feeamnt + scholaramnt;
    var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);
    
    if(totalCollectgrpFees > grpfeeamnt){
      alert('Kindly Enter Less than or equal to Fees Amount');
      $(this).val("0");
      //To recalculate the balance to paid if amount entered greater value.
      var feeamnt = parseInt($(this).parent().parent().find('.transportfeesreceived').val());
      var scholaramnt = parseInt($(this).parent().parent().find('.transportfeesscholarship').val());
      var grpfeeamnt = parseInt($(this).parent().parent().find('.transportfeesamnt').val());
      var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);
      $(this).parent().parent().find('.transportfeesbalance').val(balanceFees);
      
    }else{
      $(this).parent().parent().find('.transportfeesbalance').val(balanceFees);
      
      getScholarshipTotal(); //Calc scholarship
      getCollectedFeesTotal(); //Calc Fees collect.
    }
  }); //Group fee calculation END.

} //after ajax function END.

//Total fee to be collected calc.
function getTotalFeeToBeCollected(){
  var getGrpFeesTotal = 0 ;
  $(".transportfeesamnt").each(function(){
    getGrpFeesTotal += parseInt($(this).val()||0);
  }); //Group Fees Table

  $('#fees_total').val(getGrpFeesTotal); //set value on Total fees to be collected.
}

//scholarship calc.
function getScholarshipTotal(){
  var getGrpScholarshipTotal = 0 ;
  $(".transportfeesscholarship").each(function(){
    getGrpScholarshipTotal += parseInt($(this).val()||0);
  }); //Group Fees Table
  
  // var totalScholarship = getGrpScholarshipTotal + getExtraScholarshipTotal + getAmenityScholarshipTotal;
  $('#fees_scholarship').val(getGrpScholarshipTotal); //set value on scholarship.
  var ToBeCollect = parseInt($('#fees_total').val()) - getGrpScholarshipTotal;
  $('#final_amount_recieved').val(ToBeCollect); //set value on Final Amount to be collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - parseInt($('#fees_collected').val());
  $('#fees_balance').val(balFees); //set value on Final Amount to be collected.
}

//Fees collected calc.
function getCollectedFeesTotal(){
  var getGrpCollectedFees = 0 ;
  $(".transportfeesreceived").each(function(){
    getGrpCollectedFees += parseInt($(this).val()||0);
  }); //Group Fees Table

  // var totalCollectedFees = getGrpCollectedFees + getExtraCollectedFees + getAmenityCollectedFees + getFeesReceivedToAddCollect;
  $('#fees_collected').val(getGrpCollectedFees); //set value on Fees Collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - getGrpCollectedFees;
  $('#fees_balance').val(balFees); //set value on Final Amount to be collected.
}

function getCollectedAmount(){
  var totalAmount = 0;
  $('.amount').each(function(){
    totalAmount += parseInt($(this).val()||0)
  });
  return totalAmount;
}