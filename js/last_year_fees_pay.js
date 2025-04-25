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

  $('#other_charges_recieved').keyup(function () {
    getTotalFeeToBeCollected();
    getScholarshipTotal();
    getCollectedFeesTotal();
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
  getAcademicYearList(); //Get  Academic Year List.
  setTimeout(() => {
    getFeesTableFunc();
  }, 5000);
});

function getFeesTableFunc() {
  var acdmcyear = $('#academic_year').val().split('-');
  var academicYear = (acdmcyear[0] - 1) + '-' + (acdmcyear[1] - 1);//getting current academic year and minus  one from it to show previous year.
  var admissionFormId = $('#admission_form_id').val();
  // var academicYear = $('#student_year_id').val();
  var medium = $('#student_medium').val();
  var studentType = $('#students_type').val();
  var standard = $('#standard_id').val();
  var student_extra_curricular = $('#student_extra_curricular').val();
  var fees_id = $('#fees_id').val();
  if (fees_id != '') {
    geteditFeesDetails(fees_id)
  }
  else {
    getReceiptCode(); //Receipt Number;
    getGroupFeesDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular);
  }

  // getExtraCurricularActivityDetails(admissionFormId, academicYear, medium, studentType, standard);
  // getAmenityFeesDetails(admissionFormId, academicYear, medium, studentType, standard);

  // setTimeout(() => { 
  //   functionAfterAjax();
  //   getTotalFeeToBeCollected();//Fees to be collected total.
  //   getScholarshipTotal(); //Scholarship amount.

  // }, 8000);
}

function getReceiptCode() {
  // get Pay Reciept Code
  $.ajax({
    url: "ajaxFiles/ajaxgetpaylastcode.php",
    data: {},
    cache: false,
    type: "post",
    dataType: "json",
    success: function (data) {
      $("#receipt_number").val(data);
    }
  });
}

function getGroupFeesDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular) {
  $.ajax({
    type: 'POST',
    url: 'FeesCollectionFile/grp/getGroupFeesDetailsForLastYear.php',
    data: { 'admissionFormId': admissionFormId, 'academicYear': academicYear, 'medium': medium, 'studentType': studentType, 'standard': standard },
    success: (function (reponse) {
      $('#temp_group_fees').empty();
      $('#temp_group_fees').html(reponse);

      getExtraCurricularActivityDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular);
    })
  })
}

function getExtraCurricularActivityDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular) {
  $.ajax({
    type: 'POST',
    url: 'FeesCollectionFile/extra/getExtraCurricularActivityDetailsForLastYear.php',
    data: { 'admissionFormId': admissionFormId, 'academicYear': academicYear, 'medium': medium, 'studentType': studentType, 'standard': standard, 'student_extra_curricular': student_extra_curricular },
    success: (function (reponse) {
      $('#temp_extra_curricular_fees').empty();
      $('#temp_extra_curricular_fees').html(reponse);

      getAmenityFeesDetails(admissionFormId, academicYear, medium, studentType, standard);
    })
  })
}

function getAmenityFeesDetails(admissionFormId, academicYear, medium, studentType, standard) {
  $.ajax({
    type: 'POST',
    url: 'FeesCollectionFile/amenity/getAmenityFeesDetailsForLastYear.php',
    data: { 'admissionFormId': admissionFormId, 'academicYear': academicYear, 'medium': medium, 'studentType': studentType, 'standard': standard },
    success: (function (reponse) {
      $('#temp_amenity_fees').empty();
      $('#temp_amenity_fees').html(reponse);
      getTransFeesDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular)
    })
  });
}

function getTransFeesDetails(admissionFormId, academicYear, medium, studentType, standard, student_extra_curricular) {
  $.ajax({
    type: 'POST',
    url: 'FeesCollectionFile/grp/getTransportFeesDetailsForLastYear.php',
    data: { 'admissionFormId': admissionFormId, 'academicYear': academicYear, 'medium': medium, 'studentType': studentType, 'standard': standard },
    success: (function (reponse) {
      $('#last_year_transport_fees').empty();
      $('#last_year_transport_fees').html(reponse);
    })
  }).then(function () {
    functionAfterAjax();
    getTotalFeeToBeCollected();//Fees to be collected total.
    getScholarshipTotal(); //Scholarship amount.
  });
}
function functionAfterAjax() {

  //Check Amount, if 0 then set row as readonly
  $('.grpfeesamnt, .extrafeesamnt, .amenityfees, .transportfeeslastamnt').each(function () {

    var row = $(this).closest('tr');
    if (parseFloat($(this).val()) <= 0) {
      row.find('input').prop('readonly', true);
    }
  })

  $('.grpfeesreceived, .grpfeesscholarship').keyup(function () {
    var fees_id = $('#fees_id').val();
    var $row = $(this).closest('tr');
    var $thisField = $(this);

    if (fees_id != '') {
      validateGroupFeesAjax(fees_id, $thisField, $row);

    } else {
      var feeamnt = parseInt($(this).parent().parent().find('.grpfeesreceived').val());
      var scholaramnt = parseInt($(this).parent().parent().find('.grpfeesscholarship').val());
      var grpfeeamnt = parseInt($(this).parent().parent().find('.grpfeesamnt').val());
      var totalCollectgrpFees = feeamnt + scholaramnt;
      var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (totalCollectgrpFees > grpfeeamnt) {
        alert('Kindly Enter Less than or equal to Fees Amount');
        $(this).val("0");
        //To recalculate the balance to paid if amount entered greater value.
        var feeamnt = parseInt($(this).parent().parent().find('.grpfeesreceived').val());
        var scholaramnt = parseInt($(this).parent().parent().find('.grpfeesscholarship').val());
        var grpfeeamnt = parseInt($(this).parent().parent().find('.grpfeesamnt').val());
        var balanceFees = grpfeeamnt - (feeamnt + scholaramnt);
        $(this).parent().parent().find('.grpfeesbalance').val(balanceFees);

      } else {
        $(this).parent().parent().find('.grpfeesbalance').val(balanceFees);

        getScholarshipTotal(); //Calc scholarship
        getCollectedFeesTotal(); //Calc Fees collect.
      }
    }

  }); //Group fee calculation END.

  $('.extrafeesreceived, .extrafeesscholar').keyup(function () {
    var fees_id = $('#fees_id').val();
    var $row = $(this).closest('tr');
    var $thisField = $(this);

    if (fees_id != '') {
      validateExtraFeesAjax(fees_id, $thisField, $row);

    } else {
      var extrafeereceived = parseInt($(this).parent().parent().find('.extrafeesreceived').val());
      var extrascholaramnt = parseInt($(this).parent().parent().find('.extrafeesscholar').val());
      var extrafeeamnt = parseInt($(this).parent().parent().find('.extrafeesamnt').val());
      var totalCollectextraFees = extrafeereceived + extrascholaramnt;
      var extrabalanceFees = extrafeeamnt - (extrafeereceived + extrascholaramnt);

      if (totalCollectextraFees > extrafeeamnt) {
        alert('Kindly Enter Less than or equal to Fees Amount');
        $(this).val("0");
        //To recalculate the balance to paid if amount entered greater value.
        var extrafeereceived = parseInt($(this).parent().parent().find('.extrafeesreceived').val());
        var extrascholaramnt = parseInt($(this).parent().parent().find('.extrafeesscholar').val());
        var extrafeeamnt = parseInt($(this).parent().parent().find('.extrafeesamnt').val());
        var extrabalanceFees = extrafeeamnt - (extrafeereceived + extrascholaramnt);
        $(this).parent().parent().find('.extrafeesbalance').val(extrabalanceFees);

      } else {
        $(this).parent().parent().find('.extrafeesbalance').val(extrabalanceFees);

        getScholarshipTotal(); //Calc scholarship
        getCollectedFeesTotal(); //Calc Fees collect.
      }
    }
  }); //Extra curricular fee calculation END.

  $('.amenityfeesreceived, .amenityfeesscholar').keyup(function () {
    var fees_id = $('#fees_id').val();
    var $row = $(this).closest('tr');
    var $thisField = $(this);

    if (fees_id != '') {
      validateAmentityFeesAjax(fees_id, $thisField, $row);

    } else {
      var amenityfeereceived = parseInt($(this).parent().parent().find('.amenityfeesreceived').val());
      var amenityscholaramnt = parseInt($(this).parent().parent().find('.amenityfeesscholar').val());
      var amenityfeeamnt = parseInt($(this).parent().parent().find('.amenityfees').val());
      var totalCollectamenityFees = amenityfeereceived + amenityscholaramnt;
      var amenitybalanceFees = amenityfeeamnt - (amenityfeereceived + amenityscholaramnt);

      if (totalCollectamenityFees > amenityfeeamnt) {
        alert('Kindly Enter Less than or equal to Fees Amount');
        $(this).val("0");
        //To recalculate the balance to paid if amount entered greater value.
        var amenityfeereceived = parseInt($(this).parent().parent().find('.amenityfeesreceived').val());
        var extrascholaramnt = parseInt($(this).parent().parent().find('.amenityfeesscholar').val());
        var amenityfeeamnt = parseInt($(this).parent().parent().find('.amenityfees').val());
        var amenitybalanceFees = amenityfeeamnt - (amenityfeereceived + extrascholaramnt);
        $(this).parent().parent().find('.amenityfeesbalance').val(amenitybalanceFees);

      } else {
        $(this).parent().parent().find('.amenityfeesbalance').val(amenitybalanceFees);

        getScholarshipTotal(); //Calc scholarship
        getCollectedFeesTotal(); //Calc Fees collect.
      }
    }
  }); //Amenity fee calculation END.

  $('.transportfeeslastreceived, .transportfeeslastscholarship').keyup(function () {
    var fees_id = $('#fees_id').val();
    var $row = $(this).closest('tr');
    var $thisField = $(this);

    if (fees_id != '') {
      validateTransportFeesAjax(fees_id, $thisField, $row);

    } else {
      var transportfeereceived = parseInt($(this).parent().parent().find('.transportfeeslastreceived').val());
      var transportcholaramnt = parseInt($(this).parent().parent().find('.transportfeeslastscholarship').val());
      var transportfeeamnt = parseInt($(this).parent().parent().find('.transportfeeslastamnt').val());
      var totalCollectTransportFees = transportfeereceived + transportcholaramnt;
      var transportbalanceFees = transportfeeamnt - (transportfeereceived + transportcholaramnt);

      if (totalCollectTransportFees > transportfeeamnt) {
        alert('Kindly Enter Less than or equal to Fees Amount');
        $(this).val("0");
        //To recalculate the balance to paid if amount entered greater value.
        var transportfeereceived = parseInt($(this).parent().parent().find('.transportfeeslastreceived').val());
        var extrascholaramnt = parseInt($(this).parent().parent().find('.transportfeeslastscholarship').val());
        var transportfeeamnt = parseInt($(this).parent().parent().find('.transportfeeslastamnt').val());
        var transportbalanceFees = transportfeeamnt - (transportfeereceived + extrascholaramnt);
        $(this).parent().parent().find('.transportfeeslastbalance').val(transportbalanceFees);

      } else {
        $(this).parent().parent().find('.transportfeeslastbalance').val(transportbalanceFees);

        getScholarshipTotal(); //Calc scholarship
        getCollectedFeesTotal(); //Calc Fees collect.
      }
    }
  }); //Transport fee calculation END.
} //after ajax function END.

//Total fee to be collected calc.
function getTotalFeeToBeCollected() {
  var getGrpFeesTotal = 0;
  $(".grpfeesamnt").each(function () {
    getGrpFeesTotal += parseInt($(this).val() || 0);
  }); //Group Fees Table

  var getExtraFeesTotal = 0;
  $(".extrafeesamnt").each(function () {
    getExtraFeesTotal += parseInt($(this).val() || 0);
  }); //Extra curricular Activities Fees Table

  var getAmenityFeesTotal = 0;
  $(".amenityfees").each(function () {
    getAmenityFeesTotal += parseInt($(this).val() || 0);
  }); //Amenity Fees Table
  var getTransportFeesTotal = 0;
  $(".transportfeeslastamnt").each(function () {
    getTransportFeesTotal += parseInt($(this).val() || 0);
  }); //Transport Fees Table
  var getFeesReceived = parseInt($('#other_charges_recieved').val());

  var totalFees = getGrpFeesTotal + getExtraFeesTotal + getAmenityFeesTotal + getTransportFeesTotal + getFeesReceived;
  $('#fees_total').val(totalFees); //set value on Total fees to be collected.
}

//scholarship calc.
function getScholarshipTotal() {
  var getGrpScholarshipTotal = 0;
  $(".grpfeesscholarship").each(function () {
    getGrpScholarshipTotal += parseInt($(this).val() || 0);
  }); //Group Fees Table

  var getExtraScholarshipTotal = 0;
  $(".extrafeesscholar").each(function () {
    getExtraScholarshipTotal += parseInt($(this).val() || 0);
  }); //Extra curricular Activities Fees Table

  var getAmenityScholarshipTotal = 0;
  $(".amenityfeesscholar").each(function () {
    getAmenityScholarshipTotal += parseInt($(this).val() || 0);
  }); //Amenity Fees Table
  var getTransScholarshipTotal = 0;
  $(".transportfeeslastscholarship").each(function () {
    getTransScholarshipTotal += parseInt($(this).val() || 0);
  }); //Transport Fees Table
  var totalScholarship = getGrpScholarshipTotal + getExtraScholarshipTotal + getAmenityScholarshipTotal + getTransScholarshipTotal;
  $('#fees_scholarship').val(totalScholarship); //set value on scholarship.
  var ToBeCollect = parseInt($('#fees_total').val()) - totalScholarship;
  $('#final_amount_recieved').val(ToBeCollect); //set value on Final Amount to be collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - parseInt($('#fees_collected').val());
  $('#fees_balance').val(balFees); //set value on Final Amount to be collected.
}

//Fees collected calc.
function getCollectedFeesTotal() {
  var getGrpCollectedFees = 0;
  $(".grpfeesreceived").each(function () {
    getGrpCollectedFees += parseInt($(this).val() || 0);
  }); //Group Fees Table

  var getExtraCollectedFees = 0;
  $(".extrafeesreceived").each(function () {
    getExtraCollectedFees += parseInt($(this).val() || 0);
  }); //Extra curricular Activities Fees Table

  var getAmenityCollectedFees = 0;
  $(".amenityfeesreceived").each(function () {
    getAmenityCollectedFees += parseInt($(this).val() || 0);
  }); //Amenity Fees Table

  var getTransCollectedFees = 0;
  $(".transportfeeslastreceived").each(function () {
    getTransCollectedFees += parseInt($(this).val() || 0);
  }); //Transport Fees Table
  var getFeesReceivedToAddCollect = parseInt($('#other_charges_recieved').val());

  var totalCollectedFees = getGrpCollectedFees + getExtraCollectedFees + getAmenityCollectedFees + getTransCollectedFees + getFeesReceivedToAddCollect;
  $('#fees_collected').val(totalCollectedFees); //set value on Fees Collected.
  var balFees = parseInt($('#final_amount_recieved').val()) - totalCollectedFees;
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
    url: 'FeesCollectionFile/grp/editLastYearPayFees.php',
    data: { 'fees_id': fees_id },
    dataType: 'json',
    success: (function (res) {
      var groupFeesHtml = res.group;
      var extraFeesHtml = res.extra;
      var amenityFeesHtml = res.amenity;
      var transportFeesHtml = res.transport;
      var academicYear = res.academic_year;
      var receiptNo = res.receipt_no;
      var receiptDate = res.receipt_date;
      var payment_mode = res.payment_mode;
      var fees_collected = res.fees_collected;
      var scholarship = res.scholarship;
      var denomination = res.denomination;
      // Use these values as needed
      $('#academic_year').val(academicYear);
      $('#receipt_number').val(receiptNo);
      $('#receipt_date').val(receiptDate);
      $('#temp_group_fees').empty();
      $('#temp_extra_curricular_fees').empty();
      $('#temp_amenity_fees').empty();
      $('#last_year_transport_fees').empty();

      $('#temp_group_fees').append(groupFeesHtml);
      $('#temp_extra_curricular_fees').append(extraFeesHtml);
      $('#temp_amenity_fees').append(amenityFeesHtml);
      $('#last_year_transport_fees').append(transportFeesHtml);
      $('#fees_scholarship').val(scholarship);
      $('#fees_collected').val(fees_collected);

      $('input[name="payment_mode"][value="' + payment_mode + '"]').prop('checked', true);
      if (payment_mode == "cash_payment") {
        $("#cash_payment").show();
        $("#cheque_payment").hide();
        $("#neft_payment").hide();
    } else if (payment_mode == "cheque") {
        $("#cash_payment").hide();
        $("#cheque_payment").show();
        $("#neft_payment").hide();
    } else if (payment_mode == "neft") {
        $("#cash_payment").hide();
        $("#cheque_payment").hide();
        $("#neft_payment").show();
    }

        $('#cheque_number').val(denomination.cheque_number);
        $('#cheque_amount').val(denomination.cheque_amount);
        $('#cheque_date').val(denomination.cheque_date);
        $('#cheque_bank_name').val(denomination.cheque_bank_name);
        $('#cheque_ledger_name').val(denomination.ledger_ref_id);
        $('#neft_ledger_name').val(denomination.ledger_ref_id);
        $('#neft_number').val(denomination.neft_ref_number);
        $('#neft_amount').val(denomination.neft_amount);
        $('#neft_date').val(denomination.neft_tran_date);
        $('#neft_bank_name').val(denomination.neft_bank_name);
        $('#receive_five_hundred').val(denomination.no_five_hundred).trigger('keyup');
        $('#receive_two_hundred').val(denomination.no_two_hundred).trigger('keyup');
        $('#receive_hundred').val(denomination.no_hundred).trigger('keyup');
        $('#receive_fifty').val(denomination.no_fifty).trigger('keyup');
        $('#receive_twenty').val(denomination.no_twenty).trigger('keyup');
        $('#receive_ten').val(denomination.no_ten).trigger('keyup');
        $('#receive_five').val(denomination.no_five).trigger('keyup');
        $('#total_amount').val(denomination.total_amount);

    })
  }).then(function () {
    functionAfterAjax();
    getTotalFeeToBeCollected();//Fees to be collected total. 
    getScholarshipTotal(); //Scholarship amount. 
  });
}

function validateGroupFeesAjax(fees_id, $thisField, $row) {
  const groupFeeData = [];
  var admissionFormId = $('#admission_form_id').val();
  $('#temp_group_fees tr').each(function () {
    const feesMasterId = $(this).find('input[name="grpid[]"]').val();
    const receivedAmount = parseFloat($(this).find('.grpfeesreceived').val()) || 0;
    const scholarshipAmount = parseFloat($(this).find('.grpfeesscholarship').val()) || 0;

    groupFeeData.push({
      fees_master_id: feesMasterId,
      received: receivedAmount,
      scholarship: scholarshipAmount
    });
  });

  $.ajax({
    url: 'FeesCollectionFile/grp/editLastYearValidation.php',
    type: 'POST',
    data: {
      admissionFormId: admissionFormId,
      admission_fees_ref_id: fees_id,
      group_fees_data: groupFeeData
    },
    dataType: 'json',
    success: function (response) {
      const feeamnt = parseFloat($row.find('.grpfeesreceived').val()) || 0;
      const scholaramnt = parseFloat($row.find('.grpfeesscholarship').val()) || 0;
      const grpfeeamnt = parseFloat($row.find('.grpfeesamnt').val()) || 0;
      const balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (response.status === 'error') {
        alert(response.message);
        $thisField.val(0);
      }

      const updatedFee = parseFloat($row.find('.grpfeesreceived').val()) || 0;
      const updatedScholar = parseFloat($row.find('.grpfeesscholarship').val()) || 0;
      const updatedBalance = grpfeeamnt - (updatedFee + updatedScholar);
      $row.find('.grpfeesbalance').val(updatedBalance);

      getScholarshipTotal();
      getCollectedFeesTotal();
    },
    error: function () {
      alert('Server error! Please try again.');
    }
  });
}
function validateAmentityFeesAjax(fees_id, $thisField, $row) {
  const amenity_fees_data = [];
  var admissionFormId = $('#admission_form_id').val();
  $('#temp_amenity_fees tr').each(function () {
    const feesMasterId = $(this).find('input[name="amenityAmntid[]"]').val();
    const receivedAmount = parseFloat($(this).find('.amenityfeesreceived').val()) || 0;
    const scholarshipAmount = parseFloat($(this).find('.amenityfeesscholar').val()) || 0;

    amenity_fees_data.push({
      fees_master_id: feesMasterId,
      received: receivedAmount,
      scholarship: scholarshipAmount
    });
  });

  $.ajax({
    url: 'FeesCollectionFile/grp/editLastYearValidation.php',
    type: 'POST',
    data: {
      admissionFormId: admissionFormId,
      admission_fees_ref_id: fees_id,
      amenity_fees_data: amenity_fees_data
    },
    dataType: 'json',
    success: function (response) {
      const feeamnt = parseFloat($row.find('.amenityfeesreceived').val()) || 0;
      const scholaramnt = parseFloat($row.find('.amenityfeesscholar').val()) || 0;
      const grpfeeamnt = parseFloat($row.find('.amenityfees').val()) || 0;
      const balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (response.status === 'error') {
        alert(response.message);
        $thisField.val(0);
      }

      const updatedFee = parseFloat($row.find('.amenityfeesreceived').val()) || 0;
      const updatedScholar = parseFloat($row.find('.amenityfeesscholar').val()) || 0;
      const updatedBalance = grpfeeamnt - (updatedFee + updatedScholar);
      $row.find('.amenityfeesbalance').val(updatedBalance);

      getScholarshipTotal();
      getCollectedFeesTotal();
    },
    error: function () {
      alert('Server error! Please try again.');
    }
  });
}
function validateExtraFeesAjax(fees_id, $thisField, $row) {
  const extra_fees_data = [];
  var admissionFormId = $('#admission_form_id').val();
  $('#temp_extra_curricular_fees tr').each(function () {
    const feesMasterId = $(this).find('input[name="extraAmntid[]"]').val();
    const receivedAmount = parseFloat($(this).find('.extrafeesreceived').val()) || 0;
    const scholarshipAmount = parseFloat($(this).find('.extrafeesscholar').val()) || 0;

    extra_fees_data.push({
      fees_master_id: feesMasterId,
      received: receivedAmount,
      scholarship: scholarshipAmount
    });
  });

  $.ajax({
    url: 'FeesCollectionFile/grp/editLastYearValidation.php',
    type: 'POST',
    data: {
      admissionFormId: admissionFormId,
      admission_fees_ref_id: fees_id,
      extra_fees_data: extra_fees_data
    },
    dataType: 'json',
    success: function (response) {
      const feeamnt = parseFloat($row.find('.extrafeesreceived').val()) || 0;
      const scholaramnt = parseFloat($row.find('.extrafeesscholar').val()) || 0;
      const grpfeeamnt = parseFloat($row.find('.extrafeesamnt').val()) || 0;
      const balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (response.status === 'error') {
        alert(response.message);
        $thisField.val(0);
      }

      const updatedFee = parseFloat($row.find('.extrafeesreceived').val()) || 0;
      const updatedScholar = parseFloat($row.find('.extrafeesscholar').val()) || 0;
      const updatedBalance = grpfeeamnt - (updatedFee + updatedScholar);
      $row.find('.extrafeesbalance').val(updatedBalance);

      getScholarshipTotal();
      getCollectedFeesTotal();
    },
    error: function () {
      alert('Server error! Please try again.');
    }
  });
}
function validateTransportFeesAjax(fees_id, $thisField, $row) {
  const transport_fees_data = [];
  var admissionFormId = $('#admission_form_id').val();
  $('#last_year_transport_fees tr').each(function () {
    const feesMasterId = $(this).find('input[name="particularId[]"]').val();
    const receivedAmount = parseFloat($(this).find('.transportfeeslastreceived').val()) || 0;
    const scholarshipAmount = parseFloat($(this).find('.transportfeeslastscholarship').val()) || 0;

    transport_fees_data.push({
      fees_master_id: feesMasterId,
      received: receivedAmount,
      scholarship: scholarshipAmount
    });
  });

  $.ajax({
    url: 'FeesCollectionFile/grp/editLastYearValidation.php',
    type: 'POST',
    data: {
      admissionFormId: admissionFormId,
      admission_fees_ref_id: fees_id,
      transport_fees_data: transport_fees_data
    },
    dataType: 'json',
    success: function (response) {
      const feeamnt = parseFloat($row.find('.transportfeeslastreceived').val()) || 0;
      const scholaramnt = parseFloat($row.find('.transportfeeslastscholarship').val()) || 0;
      const grpfeeamnt = parseFloat($row.find('.transportfeeslastamnt').val()) || 0;
      const balanceFees = grpfeeamnt - (feeamnt + scholaramnt);

      if (response.status === 'error') {
        alert(response.message);
        $thisField.val(0);
      }

      const updatedFee = parseFloat($row.find('.transportfeeslastreceived').val()) || 0;
      const updatedScholar = parseFloat($row.find('.transportfeeslastscholarship').val()) || 0;
      const updatedBalance = grpfeeamnt - (updatedFee + updatedScholar);
      $row.find('.transportfeeslastbalance').val(updatedBalance);

      getScholarshipTotal();
      getCollectedFeesTotal();
    },
    error: function () {
      alert('Server error! Please try again.');
    }
  });
}