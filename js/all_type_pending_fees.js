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
        e.preventDefault();

        const selectedTerm = $('#fee_type').val();
        const selectedStudent = $('#student_name1').val(); // student dropdown
        const table = $('#show_student_allPending_list');
        const academicYear = $('#academic_year').val();

        if (selectedTerm == "0") {
            alert("Please select Term");
            return;
        }

        $('#printArea').empty();

        table.find("tbody tr").each(function () {

            const cells = $(this).find("td");
            if (cells.length === 0) return;

            // ❌ Skip Grand Total row
            if ($(this).text().toLowerCase().includes("grand total")) {
                return;
            }

            const studentName = cells.eq(2).text().trim();
            const stdSection = cells.eq(3).text().trim();

            // ✅ STUDENT FILTER
            if (selectedStudent != "0" && studentName !== selectedStudent) {
                return;
            }

            function getAmount(index) {
                return parseFloat(cells.eq(index).text().replace(/,/g, '')) || 0;
            }

            // Common Fees
            let lastYear = getAmount(5);
            let admission = getAmount(6);
            let uniform = getAmount(7);
            let books = getAmount(8);
            let eca = getAmount(15);

            // Tuition
            let t1 = getAmount(9);
            let t2 = getAmount(10);
            let t3 = getAmount(11);

            // Transport
            let tr1 = getAmount(12);
            let tr2 = getAmount(13);
            let tr3 = getAmount(14);

            let total = 0;
            let tuitionTotal = 0;
            let transportTotal = 0;

            if (selectedTerm == "1") {
                tuitionTotal = t1;
                transportTotal = tr1;
            }
            if (selectedTerm == "2") {
                tuitionTotal = t1 + t2;
                transportTotal = tr1 + tr2;
            }
            if (selectedTerm == "3") {
                tuitionTotal = t1 + t2 + t3;
                transportTotal = tr1 + tr2 + tr3;
            }

            total = lastYear + admission + uniform + books + eca + tuitionTotal + transportTotal;

            if (total <= 0) return;
            let tuitionColumns = "";
            let transportColumns = "";
            let tuitionValues = "";
            let transportValues = "";

            // Term I
            if (selectedTerm == "1" || selectedTerm == "2" || selectedTerm == "3") {
                tuitionColumns += "<th>Term I</th>";
                transportColumns += "<th>Term I</th>";
                tuitionValues += `<td>${t1}</td>`;
                transportValues += `<td>${tr1}</td>`;
            }

            // Term II
            if (selectedTerm == "2" || selectedTerm == "3") {
                tuitionColumns += "<th>Term II</th>";
                transportColumns += "<th>Term II</th>";
                tuitionValues += `<td>${t2}</td>`;
                transportValues += `<td>${tr2}</td>`;
            }

            // Term III
            if (selectedTerm == "3") {
                tuitionColumns += "<th>Term III</th>";
                transportColumns += "<th>Term III</th>";
                tuitionValues += `<td>${t3}</td>`;
                transportValues += `<td>${tr3}</td>`;
            }
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB');
            const message = `
        <div style="margin-bottom:30px; font-family:Arial;">

            <div style="display:flex; justify-content:space-between;">
                <strong>Reminder:</strong>
                <strong>Date:${formattedDate}</strong>
            </div>

            <p>Dear Parents/Guardians,</p>

            <p>
                This is a gentle reminder to pay the 
                <strong>Pending Fees
                for the academic year ${academicYear} </strong> 
                for <strong>${studentName} (${stdSection})</strong>.
            </p>

           <table border="1" width="100%" cellpadding="6" cellspacing="0"
    style="border-collapse:collapse; text-align:center;">

    <tr>
        <th rowspan="2">Last Year</th>
        <th rowspan="2">Admission</th>
        <th rowspan="2">Books</th>
        <th rowspan="2">Uniform</th>
        <th colspan="${(selectedTerm)}">Tuition</th>
        <th colspan="${(selectedTerm)}">Transport</th>
        <th rowspan="2">ECA</th>
        <th rowspan="2">Total Amount Payable</th>
    </tr>

    <tr>
        ${tuitionColumns}
        ${transportColumns}
    </tr>

    <tr>
        <td>${lastYear}</td>
        <td>${admission}</td>
        <td>${books}</td>
        <td>${uniform}</td>
        ${tuitionValues}
        ${transportValues}
        <td>${eca}</td>
        <td><strong>${total}</strong></td>
    </tr>

</table>

            <br>
            <p>Please ensure timely payment to avoid any inconvenience.</p>
            <p>Thank you for your cooperation.</p>

            <hr>
        </div>
        `;

            $('#printArea').append(message);

        });

        if ($('#printArea').children().length === 0) {
            alert("No pending fees found.");
            return;
        }
        $('body').addClass('reminder-print');
        $('#printArea').show();
        window.print();
        setTimeout(() => {
            $('#printArea').hide();
            $('body').removeClass('reminder-print');
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
                    $('#fee_type').val('0').trigger('change'); // reset fee type dropdown
                    $('#showStudentFeesPendingList').empty();
                    $('#showStudentFeesPendingList').html(response);
                    // 🔥 Initialize DataTable AFTER loading table
                    let table = $('#show_student_allPending_list').DataTable();

                    // 🔥 Populate student dropdown AFTER table is ready
                    let studentSet = new Set();

                    $('#student_name1').empty()
                        .append('<option value="0">Select Student Name</option>');

                    $('#show_student_allPending_list tbody tr').each(function () {

                        let cells = $(this).find('td');
                        if (cells.length === 0) return;

                        let studentName = cells.eq(2).text().trim();

                        let hasPending = false;

                        // Fee column indexes
                        let feeIndexes = [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];

                        feeIndexes.forEach(function (index) {
                            let amount = parseFloat(cells.eq(index).text()) || 0;
                            if (amount > 0) {
                                hasPending = true;
                            }
                        });

                        if (studentName !== '' && hasPending) {
                            studentSet.add(studentName);
                        }

                    });

                    studentSet.forEach(name => {
                        $('#student_name1').append(
                            `<option value="${name}">${name}</option>`
                        );
                    });

                    $('#student_name1').trigger('change'); // refresh select2
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