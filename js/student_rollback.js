$(document).ready(function () {
  
  // Select all checkboxes when the "select all" checkbox is checked
  $('#select-all').click(function () {
    $('.checkbox').prop('checked', this.checked);
    updateUnselectedTable();
    if(this.checked == true){
      // hide the unselected table if select all student.
      $('#unselected_table').hide();
    }
  });

  $('#submitFailList').click(function () {
    if ($('.checkbox').length === $('.checkbox:checked').length) {
      alert('All students are pass');

    } else {
      updateUnselectedTable();

      // Show the unselected table
      $('#unselected_table').show();

    }
  });

  $('#standard').change(function () {
    var standard = $("#standard").val();
    if (standard.length != 0) {
      $.ajax({
        url: 'FeesCollectionFile/grp/ajaxgetStudentList.php',
        type: 'post',
        data: { "standard": standard },
        dataType: 'json',
        success: function (response) {
          // clear the section dropdown and add a default option
          $('#section').empty();
          $('#section').append("<option value=''>Select Section</option>");

          // loop through the section list in the response and add options to the section dropdown
          for (var i = 0; i < response.section.length; i++) {
            $('#section').append("<option value='" + response.section[i] + "'>" + response.section[i] + "</option>");
          }
        }
      });
    }else{
      $('#section').empty();
      // getStudentListForRollBack('','', 1); //1 =showing All students in initially.
    }
  });

  $('#section').change(function () {
    var standard = $("#standard").val();
    var section = $("#section").val();
    if (standard.length != 0 && section.length != 0) {
      getStudentListForRollBack(standard,section, 2); //2 =selecting standard and section to show particular std students.
    }
  });

  $('#submitschool_creation').click(function(e){
    event.preventDefault();

    var studentID = $('input[type="checkbox"]:checked').map(function() {
      return $(this).closest('tr').find('input[name="studentId[]"]').val();
  }).get();
    var standardID = $('input[type="checkbox"]:checked').map(function() {
      return $(this).closest('tr').find('input[name="stdId[]"]').val();
  }).get();

    $.ajax({
      type: 'POST',
      data: {'student_id': studentID, 'standard_id': standardID},
      url: 'ajaxFiles/submitRollBackForm.php',
      dataType: 'json',
      success: function(result) {
        if(result.status == 'success'){
          alert("Successfully Roll Backed!");
          
        }else{
          alert("Roll Back Failed!");
        }

        var standard = $("#standard").val();
        if(standard !=''){
          var section = $("#section").val();
          getStudentListForRollBack(standard, section, 2)
        }else{
          // getStudentListForRollBack('', '', 1)
        }
        // window.location.href= "student_rollback.php";
      }
    });

  });//submit student rollback form 

});//Document END.

$(function () {
  getStandardList(); //Get standard list from database.
  // getStudentListForRollBack('','', 1); //1 =showing All students in initially.

})


function getStandardList() { //Getting standard list from database.
  var hrCls = ['13','19','20','21','22','23'];
  $.ajax({
    type: 'POST',
    data: {},
    url: 'ajaxFiles/getStandardList.php',
    dataType: 'json',
    success: function (response) {
      $('#standard').empty();
      $('#standard').append("<option value=''>Select Standard</option>");
      for (var i = 0; i < response.length; i++) {
        var stdIdString = response[i]['std_id'].toString(); // Convert std_id to string
        if (hrCls.indexOf(stdIdString) === -1) { 
          $('#standard').append("<option value='" + response[i]['std_id'] + "'>" + response[i]['std'] + "</option>");
        }
      }
    }
  });
}

  // Function to update the unselected data table
  function updateUnselectedTable() {
    // Clear the existing rows in the unselected table
    $('#unselected_tbody').empty();

    // Iterate over the data and check if each row's checkbox is checked or not
    $('#student_rollback_info tbody tr').each(function () {
      var checkbox = $(this).find('.checkbox'); // Find the checkbox element within the row

      // Check if the checkbox is not checked
      if (!checkbox.prop('checked')) {
        var rowData = $(this).find('td:not(:first-child):not(:last-child)').map(function () {
          return $(this).text();
        }).get(); // Get the data of the unselected row excluding the first and last columns

        var newRow = $('<tr></tr>'); // Create a new row for the unselected table
        // Iterate over the row data and build the HTML table cells
        rowData.forEach(function (cellData) {
          newRow.append('<td>' + cellData + '</td>'); // Append the cell to the row
        });

        $('#unselected_tbody').append(newRow); // Append the row to the unselected table body
      }
    });

  }

  function getStudentListForRollBack(standard, section, type){
    $.ajax({
      url: 'ajaxStudentRollBackFetch.php',
      type: 'post',
      data: { "standard": standard, "section": section, "type": type },
      //  dataType: 'json',
      success: function (response) {
        $('#studentRollBackList').empty();
        $('#studentRollBackList').html(response);

        funcAfterAjaxCall();//initializing some function  after ajax call completes successfully.

        // hide the unselected table if select all student.
        $('#unselected_table').hide();
      }
    });
  }

  function funcAfterAjaxCall(){
    // Select the "select all" checkbox if all checkboxes are checked
    $('.checkbox').click(function () {
      if ($('.checkbox:checked').length === $('.checkbox').length) {
        $('#select-all').prop('checked', true);
        // hide the unselected table if select all student.
        $('#unselected_table').hide();
      } else {
        $('#select-all').prop('checked', false);
      }
      updateUnselectedTable();
    });
  }