$(document).ready(function() {
  $('#no_of_terms').change(function() {
    var selectedNumber = $(this).val();
    var tranamount = $('#transport_amount').val();
    console.log("selectedNumber",tranamount);
    var divamountbymonth = Math.round(parseInt(tranamount) / parseInt(selectedNumber));
    var inputField = '';
    for (var i = 1; i <= selectedNumber; i++) {
      inputField += '<input class="form-control" placeholder="Particulars" type="text" name="item_details[]" required><br><input class="form-control" placeholder="Amount" type="number" name="due_amount[]" value="'+divamountbymonth+'" required ><br><input class="form-control" type="date" name="due_date[]" required><br><br>';
    }
    $('#input-container').html(inputField);
  });

  // Trigger the change event on page load
  // $('#no_of_terms').trigger('change');
});                                     
