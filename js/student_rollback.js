$(document).ready(function() {// Select all checkboxes when the "select all" checkbox is checked
$('#select-all').click(function() {
  $('.checkbox').prop('checked', this.checked);
  updateUnselectedTable();
});

// Select the "select all" checkbox if all checkboxes are checked
$('.checkbox').click(function() {
  if ($('.checkbox:checked').length === $('.checkbox').length) {
    $('#select-all').prop('checked', true);
  } else {
    $('#select-all').prop('checked', false);
  }
  updateUnselectedTable();
});

// Function to update the unselected data table
function updateUnselectedTable() {
  var unselectedTableBody = $('#unselected_table tbody');
  unselectedTableBody.empty();

  // Iterate over the data and check if each row's checkbox is checked or not
  $('#student_rollback_info tbody tr').each(function() {
    var checkbox = $(this).find('.checkbox'); // Find the checkbox element within the row

    // Check if the checkbox is not checked
    if (!checkbox.prop('checked')) {
      var rowData = $(this).find('td:not(:first-child):not(:last-child)').map(function() {
        return $(this).text();
      }).get(); // Get the data of the unselected row excluding the first and last columns

      var newRow = $('<tr></tr>'); // Create a new row for the unselected table

      // Iterate over the row data and build the HTML table cells
      rowData.forEach(function(cellData) {
        var cell = $('<td></td>'); // Create a new table cell
        cell.text(cellData); // Set the cell text content
        newRow.append(cell); // Append the cell to the row
      });

      unselectedTableBody.append(newRow); // Append the row to the unselected table body
    }
  });
}

// Call the updateUnselectedTable function initially to populate the unselected table
updateUnselectedTable();

// Destroy the DataTable instance
var studentTable = $('#student_rollback_info').DataTable();
studentTable.destroy();

// Convert DataTable to a normal HTML table
var tableBody = $('#student_rollback_info tbody');
tableBody.empty();

// Get the data from the original table rows
$('#student_rollback_info tbody tr').each(function() {
  var rowData = $(this).find('td:not(:first-child):not(:last-child)').map(function() {
    return $(this).text();
  }).get(); // Get the data of the row excluding the first and last columns

  var newRow = $('<tr></tr>'); // Create a new row for the HTML table

  // Iterate over the row data and build the HTML table cells
  rowData.forEach(function(cellData) {
    var cell = $('<td></td>'); // Create a new table cell
    cell.text(cellData); // Set the cell text content
    newRow.append(cell); // Append the cell to the row
  });

  tableBody.append(newRow); // Append the row to the HTML table body
});

$('#submitFailList').click(function() {
  if ($('.checkbox').length === $('.checkbox:checked').length) {
    alert('All students are pass');
  } else {
    // Clear the existing rows in the unselected table
    $('#unselected_table tbody').empty();
    
    // Iterate over the checkboxes in the first table
    $('#student_rollback_info tbody input[type="checkbox"]').each(function() {
      if (!$(this).prop('checked')) {
        // Get the corresponding row data
        var rowData = $(this).closest('tr').find('td:not(:first-child):not(:last-child)').map(function() {
          return $(this).text();
        }).get();
        
        // Create a new row in the unselected table and append the data
        var newRow = $('<tr></tr>');
        rowData.forEach(function(cellData) {
          newRow.append('<td>' + cellData + '</td>');
        });
        
        // Append the new row to the unselected table body
        $('#unselected_table tbody').append(newRow);
      }
    });
    
    // Show the unselected table
    $('#unselected_table').show();
  }
});

$('#standard').change(function () {  
  var standard = $("#standard").val();
  if(standard.length != 0) {
           $.ajax({ 
             url: 'FeesCollectionFile/grp/ajaxgetStudentList.php',
             type: 'post',
             data: {"standard":standard},
             dataType: 'json',
             success:function(response){
               // clear the section dropdown and add a default option
               $('#section').empty();
               $('#section').append("<option value=''>Select Section</option>");
               
              // loop through the section list in the response and add options to the section dropdown
                 for (var i = 0; i < response.section.length; i++) { 
                   $('#section').append("<option value='" + response.section[i] + "'>" + response.section[i] + "</option>");
                 }
              }
           });
        }
    });

    $('#section').change(function () {  
      var standard = $("#standard").val();
      var section = $("#section").val();
      if(standard.length != 0 && section.length != 0) {
               $.ajax({ 
                 url: 'ajaxStudentRollBackFetch.php',
                 type: 'post',
                 data: {"standard":standard,"section":section},
                 dataType: 'json',
                 success:function(response){
                  
                  }
               });
            }
        });
});
