// Document is ready
$(document).ready(function () {
    $('#fee_type').change(function () {
        let selectedType = $(this).val();
        if (selectedType !== "0") {
            $('#reminderPrint').show();
        } else {
            $('#reminderPrint').hide();
        }
    });

    $('#reminderPrint').hide();

    // Show print button when a fee type is selected
    $('#fee_type').change(function () {
        const selectedType = $(this).val();
        $('#reminderPrint').toggle(selectedType !== "0");
    });

    // Handle Print Button Click
    $('#printButton').click(function (e) {
        e.preventDefault(); // Prevent form submit if button is inside a form
        const selectedType = $('#fee_type').val();
        const table = $('#show_student_allPending_list');
        let reminderTitle = '';
        let columnIndex = 0;

        switch (selectedType) {
            case "1": reminderTitle = "Last Year Fees Payment"; columnIndex = 5; break;
            case "2": reminderTitle = "Admission Fees Payment"; columnIndex = 6; break;
            case "3": reminderTitle = "Uniform Fees Payment"; columnIndex = 7; break;
            case "4": reminderTitle = "Book Fees Payment"; columnIndex = 8; break;
            case "5": reminderTitle = "Group - First Term Fees Payment"; columnIndex = 9; break;
            case "6": reminderTitle = "Group - Second Term Fees Payment"; columnIndex = 10; break;
            case "7": reminderTitle = "Group - Third Term Fees Payment"; columnIndex = 11; break;
            case "8": reminderTitle = "Transport - First Term Payment"; columnIndex = 12; break;
            case "9": reminderTitle = "Transport - Second Term Payment"; columnIndex = 13; break;
            case "10": reminderTitle = "Transport - Third Term Payment"; columnIndex = 14; break;
            case "11": reminderTitle = "ECA Fees Payment"; columnIndex = 15; break;
            default: alert("Invalid fee type selected."); return;
        }

        $('#printArea').empty();

        table.find("tbody tr").each(function () {
            const cells = $(this).find("td");
            if (cells.length === 0) return;

            const amount = parseFloat(cells.eq(columnIndex).text()) || 0;
            const studentName = cells.eq(2).text().trim();
            const stdSection = cells.eq(3).text().trim();

            // ✅ Skip rows with no student name
            if (amount > 0 && studentName !== "") {
                const message = `
                <div class="reminder-card">
                    <h4>Reminder: ${reminderTitle}</h4>
                    <p>Dear Parents/Guardians,</p>
                    <p>This is a gentle reminder to pay the ${reminderTitle.toLowerCase()} for 2025-26 ‐ <strong>${studentName} (${stdSection})</strong> -[<strong>₹${amount}</strong> ]</p>
                    <p>Please ensure timely payment to avoid any inconvenience.</p>
                    <p>Thank you for your co-operation.</p>
                    <hr>
                </div>
            `;
                $('#printArea').append(message);
            }
        });

        if ($('#printArea').children().length === 0) {
            alert("No pending reminders for the selected type.");
            $('#fee_type').val('0'); // or $('#fee_type').prop('selectedIndex', 0);

            $('#reminderPrint').hide();
            return;
        }
        $('body').addClass('reminder-print');
        $('#printArea').show();
        window.print();

        setTimeout(() => {
            $('#printArea').hide();
            $('body').removeClass('reminder-print');
           $('#fee_type').val('0'); // or $('#fee_type').prop('selectedIndex', 0);

            $('#reminderPrint').hide();
        }, 1000);
    });


    $('#standard').change(function () {
        let standardID = $(this).val();
        let academicYear = $('#academic_year').val();
        let medium = $('#medium').val();

        $.ajax({
            type: 'POST',
            data: { "standardID": standardID, "academicYear": academicYear, "medium": medium },
            url: 'reports/class_wise_report/getSectionList.php',
            dataType: 'json',
            success: function (response) {
                $('#section').empty();
                $('#section').append("<option value='0'>Select option</option>");
                for (var i = 0; i < response.length; i++) {
                    $('#section').append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                }
            }
        })
    });

    $('#pendingFees_table_view').click(function () {
        let academicyear = $('#academic_year').val();
        let stdMedium = $('#medium').val();
        let stdStandard = $('#standard').val();
        let stdSection = $('#section').val();

        if (academicyear != '0' && stdMedium != '0' && stdStandard != '0' && stdSection != '0') {
            $.ajax({
                type: 'POST',
                data: { "academicyear": academicyear, "stdMedium": stdMedium, "stdStandard": stdStandard, "stdSection": stdSection },
                url: 'reports/fees_details_report/allPendingFeesDetails.php',
                success: function (response) {
                    $('#listCard').show();
                    $('.rem_type').show();
                    $('#showStudentFeesPendingList').empty();
                    $('#showStudentFeesPendingList').html(response);
                }
            })
        } else {
            $('#showStudentFeesPendingList').empty();
            $('#listCard').hide();
            $('.rem_type').hide();
            alert("Kindly select All Fields!");
        }
    });

}); //Document END//


$(function () {
    getStandardList(); //Getting standard list from database.
    getAcademicYearList(); //Get  Academic Year List.
});

function getStandardList() { //Getting standard list from database.
    $.ajax({
        type: 'POST',
        data: {},
        url: 'ajaxFiles/getStandardList.php',
        dataType: 'json',
        success: function (response) {
            $('#standard').empty();
            $('#standard').append("<option value='0'>Select option</option>");
            for (var i = 0; i < response.length; i++) {
                $('#standard').append("<option value='" + response[i]['std_id'] + "'>" + response[i]['std'] + "</option>");
            }
        }
    })
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
            for (var i = 0; i < response.length; i++) {

                $('#academic_year').append("<option value='" + response[i]['academicyear'] + "'>" + response[i]['academicyear'] + "</option>");
            }
        }
    })
}