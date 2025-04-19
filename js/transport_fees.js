// Document is ready
$(document).ready(function () {

  $('input[name="payment_mode"]').click(function () {
    var value = $(this).val();

    if (value == "cash_payment") {
      $("#cash_payment").show();
      $("#cheque_payment").hide();
      $("#neft_payment").hide();

    } else if (value == "cheque") {
      $("#cash_payment").hide();
      $("#cheque_payment").show();
      $("#neft_payment").hide();
    }
    else if (value == "neft") {
      $("#cash_payment").hide();
      $("#cheque_payment").hide();
      $("#neft_payment").show();
    }
  });

  $('.cashreceive').keyup(function () {
    var cash = ($(this).parent().parent().find('.cash').val()) * ($(this).val());
    $(this).parent().parent().find('.amount').val(cash);

    var totalAmount = getCollectedAmount();

    var feeCollected = $('#fees_collected').val();
    if (totalAmount > feeCollected) {
      alert('Please Enter Less than Fees Collected.')
      $(this).parent().parent().find('.cashreceive').val('0');
      $(this).parent().parent().find('.amount').val('0');
      var calcTotalAmount = getCollectedAmount();
      $('#total_amount').val(calcTotalAmount);
    } else {
      $('#total_amount').val(totalAmount);
    }
  });//Denomination cash Calc

  $('#cheque_amount').keyup(function () {
    var cheque = $(this).val();
    var feeCollect = $('#fees_collected').val();
    if (cheque > feeCollect) {
      alert('Please Enter Less than Fees Collected.')
      $(this).val('')
    }
  });//Denomination Cheque Calc 

  $('#neft_amount').keyup(function () {
    var neft = $(this).val();
    var fee_collect = $('#fees_collected').val();
    if (neft > fee_collect) {
      alert('Please Enter Less than Fees Collected.')
      $(this).val('')
    }
  });//Denomination NEFT Calc 

}); //Document END///

$(function () {

  getFeesTableFunc();
  getAcademicYearList(); //Get  Academic Year List.
});

function getFeesTableFunc() {
  var academicYear = $('#user_academic_year').val();
  var admissionFormId = $('#admission_form_id').val();
  var medium = $('#student_medium').val();
  var studentType = $('#students_type').val();
  var standard = $('#standard_id').val();
  var fees_id = $('#fees_id').val();
  if (fees_id != '') {
    geteditFeesDetails(fees_id)
  }
  else {
    getReceiptCode(); //Receipt Number;
    getTransportFeesDetails(admissionFormId, academicYear, medium, studentType, standard);
  }


}

function getReceiptCode() {
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

function getTransportFeesDetails(admissionFormId, academicYear, medium, studentType, standard) {
  $.ajax({
    type: 'POST',
    url: 'TransportFeesMaster/getTransportFeesTable.php',
    data: { 'admissionFormId': admissionFormId, 'academicYear': academicYear, 'medium': medium, 'studentType': studentType, 'standard': standard },
    success: (function (reponse) {
      $('#transport_fees_table_body').empty();
      $('#transport_fees_table_body').html(reponse);
    })
  }).then(function () {
    functionAfterAjax();
    getTotalFeeToBeCollected();//Fees to be collected total.
    getScholarshipTotal(); //Scholarship amount.
  });
}

function functionAfterAjax() {

  //Check Amount, if 0 then set row as readonly
  $('.transportfeesamnt').each(function () {
    var row = $(this).closest('tr');
    if (parseFloat($(this).val()) <= 0) {
      row.find('input').prop('readonly', true);
    }
  })

  $('.transportfeesreceived, .transportfeesscholarship').keyup(function () {
    var fees_id = $('#fees_id').val();
    var $row = $(this).closest('tr');
    var $thisField = $(this);

    if (fees_id != '') {
      validateTransportFeesAjax(fees_id, $thisField, $row);

    } else {
      var feeamnt = parseInt($(this).parent().parent().find('.transportfeesreceived').val());
      var scholaramnt = parseInt($(this).parent().parent().find('.transportfeesscholarship').val());
      var grpfeeamnt = parseInt($(this).parent().parent().find('.transportfeesamnt').val());
      var totalCollectgrpFees = feeamnt + scholaramnt;
      var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (totalCollectgrpFees > grpfeeamnt) {
        alert('Kindly Enter Less than or equal to Fees Amount');
        $(this).val("0");
        //To recalculate the balance to paid if amount entered greater value.
        var feeamnt = parseInt($(this).parent().parent().find('.transportfeesreceived').val());
        var scholaramnt = parseInt($(this).parent().parent().find('.transportfeesscholarship').val());
        var grpfeeamnt = parseInt($(this).parent().parent().find('.transportfeesamnt').val());
        var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);
        $(this).parent().parent().find('.transportfeesbalance').val(balanceFees);

      } else {
        $(this).parent().parent().find('.transportfeesbalance').val(balanceFees);

        getScholarshipTotal(); //Calc scholarship
        getCollectedFeesTotal(); //Calc Fees collect.
      }
    }
  }); //Group fee calculation END.

} //after ajax function END.

//Total fee to be collected calc.
function getTotalFeeToBeCollected() {
  var getGrpFeesTotal = 0;
  $(".transportfeesamnt").each(function () {
    getGrpFeesTotal += parseInt($(this).val() || 0);
  }); //Group Fees Table

  $('#fees_total').val(getGrpFeesTotal); //set value on Total fees to be collected.
}

//scholarship calc.
function getScholarshipTotal() {
  var getGrpScholarshipTotal = 0;
  $(".transportfeesscholarship").each(function () {
    getGrpScholarshipTotal += parseInt($(this).val() || 0);
  }); //Group Fees Table

  // var totalScholarship = getGrpScholarshipTotal + getExtraScholarshipTotal + getAmenityScholarshipTotal;
  $('#fees_scholarship').val(getGrpScholarshipTotal); //set value on scholarship.
  var ToBeCollect = parseInt($('#fees_total').val()) - getGrpScholarshipTotal;
  $('#final_amount_recieved').val(ToBeCollect); //set value on Final Amount to be collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - parseInt($('#fees_collected').val());
  $('#fees_balance').val(balFees); //set value on Final Amount to be collected.
}

//Fees collected calc.
function getCollectedFeesTotal() {
  var getGrpCollectedFees = 0;
  $(".transportfeesreceived").each(function () {
    getGrpCollectedFees += parseInt($(this).val() || 0);
  }); //Group Fees Table

  // var totalCollectedFees = getGrpCollectedFees + getExtraCollectedFees + getAmenityCollectedFees + getFeesReceivedToAddCollect;
  $('#fees_collected').val(getGrpCollectedFees); //set value on Fees Collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - getGrpCollectedFees;
  $('#fees_balance').val(balFees); //set value on Final Amount to be collected.
}

function getCollectedAmount() {
  var totalAmount = 0;
  $('.amount').each(function () {
    totalAmount += parseInt($(this).val() || 0)
  });
  return totalAmount;
}

function getAcademicYearList() { //Getting academic_year list from database.
  $.ajax({
    type: 'POST',
    data: {},
    url: 'ajaxFiles/getAcademicYearList.php',
    dataType: 'json',
    success: function (response) {
      $('#academic_year').empty();
      $('#academic_year').append("<option value=''>Select Academic Year</option>");
      var user_academic_year = $('#user_academic_year').val();
      for (var i = 0; i < response.length; i++) {
        var selected = '';
        if (user_academic_year == response[i]['academicyear']) {
          selected = 'selected';
        }

        $('#academic_year').append("<option value='" + response[i]['academicyear'] + "' " + selected + ">" + response[i]['academicyear'] + "</option>");
      }
    }
  })
}
function geteditFeesDetails(fees_id) {
  $.ajax({
    type: 'POST',
    url: 'TransportFeesMaster/editTransportFeesTable.php',
    data: { 'fees_id': fees_id },
    dataType: 'json',
    success: (function (res) {
      var groupFeesHtml = res.group;
      var academicYear = res.academic_year;
      var receiptNo = res.receipt_no;
      var receiptDate = res.receipt_date;
      var payment_mode = res.payment_mode;
      var fees_collected = res.fees_collected;
      var scholarship = res.scholarship;
      // Use these values as needed
      $('#academic_year').val(academicYear);
      $('#receipt_number').val(receiptNo);
      $('#receipt_date').val(receiptDate);
      $('#transport_fees_table_body').empty();
      $('#transport_fees_table_body').append(groupFeesHtml);
      $('#fees_scholarship').val(scholarship);
      $('#fees_collected').val(fees_collected);

      $('input[name="payment_mode"][value="' + payment_mode + '"]').prop('checked', true);

    })
  }).then(function () {
    functionAfterAjax();
    getTotalFeeToBeCollected();//Fees to be collected total. 
    getScholarshipTotal(); //Scholarship amount. 
  });
}
function validateTransportFeesAjax(fees_id, $thisField, $row) {
  const transport_fees_data = [];
  var admissionFormId = $('#admission_form_id').val();
  $('#transport_fees_table_body tr').each(function () {
    const feesMasterId = $(this).find('input[name="particularId[]"]').val();
    const receivedAmount = parseFloat($(this).find('.transportfeesreceived').val()) || 0;
    const scholarshipAmount = parseFloat($(this).find('.transportfeesscholarship').val()) || 0;

    transport_fees_data.push({
      fees_master_id: feesMasterId,
      received: receivedAmount,
      scholarship: scholarshipAmount
    });
  });

  $.ajax({
    url: 'TransportFeesMaster/editTransportValidation.php',
    type: 'POST',
    data: {
      admissionFormId: admissionFormId,
      admission_fees_ref_id: fees_id,
      transport_fees_data: transport_fees_data
    },
    dataType: 'json',
    success: function (response) {
      const feeamnt = parseFloat($row.find('.transportfeesreceived').val()) || 0;
      const scholaramnt = parseFloat($row.find('.transportfeesscholarship').val()) || 0;
      const grpfeeamnt = parseFloat($row.find('.transportfeesamnt').val()) || 0;
      const balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (response.status === 'error') {
        alert(response.message);
        $thisField.val(0);
      }

      const updatedFee = parseFloat($row.find('.transportfeesreceived').val()) || 0;
      const updatedScholar = parseFloat($row.find('.transportfeesscholarship').val()) || 0;
      const updatedBalance = grpfeeamnt - (updatedFee + updatedScholar);
      $row.find('.transportfeesbalance').val(updatedBalance);

      getScholarshipTotal();
      getCollectedFeesTotal();
    },
    error: function () {
      alert('Server error! Please try again.');
    }
  });
}