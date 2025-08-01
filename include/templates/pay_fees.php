<?php
if (isset($_SESSION['curdateFromIndexPage'])) {
    $curdate = $_SESSION['curdateFromIndexPage'];
}
if (isset($_SESSION["academic_year"])) {
    $academicyear = $_SESSION["academic_year"];
}
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
}
if (isset($_SESSION["school_id"])) {
    $school_id = $_SESSION["school_id"];
}

if (isset($_POST['submitpayfees']) && $_POST['submitpayfees'] != '') {

    $fees_id = isset($_POST['fees_id']) ? $_POST['fees_id'] : '';

    if (!empty($fees_id)) {
        // Update case
        $addPayfeesCreation = $userObj->updatePayFees($mysqli, $userid, $school_id);
    } else {
        // Add case
        $addPayfeesCreation = $userObj->addPayFees($mysqli, $userid, $school_id);
    }

    if ($addPayfeesCreation == '-1') {
        echo "<script>alert('Pay Fees Already Inserted!');</script>";
    } else if ($addPayfeesCreation == '2') {
        echo "<script>alert('Pay Fees Failed!');</script>";
    } else {
        $payFeesId = $addPayfeesCreation['FeesLastInsertId'];
        $admissionFormId = $addPayfeesCreation['admission_form_id'];
?>
        <script>
            const payFeesId = '<?php echo $payFeesId; ?>';
            const admissionFormId = '<?php echo $admissionFormId; ?>';

            setTimeout(() => {
                print_temp_fees(payFeesId,admissionFormId);
            }, 1000);

            function print_temp_fees(payFeesid, admissionFormId) {
                const printWindow = window.open('', '_blank');
                if (printWindow) {
                    $.ajax({
                        url: 'ajaxFiles/pay_fees_print.php',
                        type: 'POST',
                        data: {
                            payFeesid: payFeesid
                        },
                        cache: false,
                        success: function(html) {
                            printWindow.document.open();
                            printWindow.document.write(html);
                            printWindow.document.close();
                            printWindow.print();

                            // Redirect after print (if it's an update case)
                            <?php if (!empty($fees_id)) { ?>
                                setTimeout(function() {
                                    window.location.href = 'fees_collection&studid=' + admissionFormId;
                                }, 500);
                            <?php } ?>
                        },
                        error: function() {
                            printWindow.close();
                            alert('Failed to load print content.');
                        }
                    });
                } else {
                    alert('Popup blocked. Please allow popups for this website.');
                }
            }
        </script>
<?php
    }
}

if (isset($_GET['pagename'])) {
    $pagename = $_GET['pagename'];
}
if (isset($_GET['upd'])) {
    $admission_id = $_GET['upd'];
    $feesid = isset($_GET['feesid']) && !empty($_GET['feesid']) ? $_GET['feesid'] : '';

    $getTempAdmissionDetails = $userObj->getStudentCreation($mysqli, $admission_id);

    if ($getTempAdmissionDetails > 0) {
        $studentrollno = $getTempAdmissionDetails['studentrollno'];
        $student_name = $getTempAdmissionDetails['student_name'];
        $standard_name = $getTempAdmissionDetails['standard_name'];
        $stdid = $getTempAdmissionDetails['standards'];
        $year_id = $getTempAdmissionDetails['academic_year'];
        $medium = $getTempAdmissionDetails['medium'];
        $studentstype = $getTempAdmissionDetails['studentstype'];
        $extra_curricular = $getTempAdmissionDetails['extra_curr'];
    }
}
?>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">School Fee Receipt</li>
    </ol>
    <a href=" <?php if ($pagename == 'stdcreation') { ?> edit_student_creation <?php } else { ?> fees_collection&studid=<?php if (isset($admission_id)) echo $admission_id;
                                                                                                                    } ?>">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>

<div class="main-container">
    <!--------form start-->
    <form id="admission_fee_form" name="admission_fee_form" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="admission_form_id" id="admission_form_id" value="<?php if (isset($admission_id)) echo $admission_id; ?>">
        <input type="hidden" class="form-control" name="user_academic_year" id="user_academic_year" value="<?php if (isset($academicyear)) echo $academicyear; ?>">
        <input type="hidden" class="form-control" name="student_year_id" id="student_year_id" value="<?php if (isset($year_id)) echo $year_id; ?>">
        <input type="hidden" class="form-control" name="student_medium" id="student_medium" value="<?php if (isset($medium)) echo $medium; ?>">
        <input type="hidden" class="form-control" name="students_type" id="students_type" value="<?php if (isset($studentstype)) echo $studentstype; ?>">
        <input type="hidden" class="form-control" name="student_extra_curricular" id="student_extra_curricular" value="<?php if (isset($extra_curricular)) echo $extra_curricular; ?>">
        <input type="hidden" class="form-control" name="fees_id" id="fees_id" value="<?php echo $feesid ?? ''; ?>">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Receipt Number</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="receipt_number" id="receipt_number" placeholder="Receipt Number" readonly>
                                </div>
                            </div>

                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Receipt Date</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="date" name="receipt_date" id="receipt_date" value="<?php if (isset($curdate)) echo $curdate; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>

                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Reg Number</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="register_number" id="register_number" value="<?php if (isset($studentrollno)) echo $studentrollno; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label class="label">Academic Year</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <select type="text" class="form-control" id="academic_year" name="academic_year">
                                        <option value="">Select Academic Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>

                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label class="label">Student Name</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="student_name" id="student_name" value="<?php if (isset($student_name)) echo $student_name; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label class="label">Standard</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="standard" id="standard" value="<?php if (isset($standard_name)) echo $standard_name; ?>" readonly>
                                    <input type="hidden" class="form-control" name="standard_id" id="standard_id" value="<?php if (isset($stdid)) echo $stdid; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Group Fees</th>
                                            <th>Amount (In Rs)</th>
                                            <th>Fees Received</th>
                                            <th>Scholarship/Concession</th>
                                            <th>Balance to be Paid</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp_group_fees"> </tbody>
                                </table>

                                <table class="table table-bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Extra Curricular</th>
                                            <th>Amount (In Rs)</th>
                                            <th>Fees Received</th>
                                            <th>Scholarship/Concession</th>
                                            <th>Balance to be Paid</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp_extra_curricular_fees"> </tbody>
                                </table>

                                <table class="table table-bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Amenity Fees</th>
                                            <th>Amount (In Rs)</th>
                                            <th>Fees Received</th>
                                            <th>Scholarship/Concession</th>
                                            <th>Balance to be Paid</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp_amenity_fees"> </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label">Other Charges</label>
                                    <input type="text" class="form-control" name="other_charges" id="other_charges">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12" style="visibility:hidden"></div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label">Fees Received</label>
                                    <input type="number" class="form-control" name="other_charges_recieved" id="other_charges_recieved" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <table id="tottable" style="width: 50%;">
                                <tr>
                                    <td style="color:#66c2ff">Summary Details</td>
                                    <td style="color:#66c2ff">Amount (In Rs)</td>
                                </tr>
                                <tr>
                                    <td>Total fees to be collected</td>
                                    <td><input type="number" class="form-control" name="fees_total" id="fees_total" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td>Scholarship/Concession</td>
                                    <td><input type="number" class="form-control" name="fees_scholarship" id="fees_scholarship" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td>Final amount to be collect</td>
                                    <td><input type="number" class="form-control" name="final_amount_recieved" id="final_amount_recieved" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td>Fees collected</td>
                                    <td><input type="number" class="form-control" name="fees_collected" id="fees_collected" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td>Balance to be paid</td>
                                    <td><input type="number" class="form-control" name="fees_balance" id="fees_balance" value="0" readonly></td>
                                </tr>
                            </table>
                        </div><br><br>

                        <div class="card-header" style="background-image: linear-gradient(white, #e6d9cc);">
                            <div class="card-title">Payment Denomination</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mr-3">Payment Mode:</label>
                                    <div class="form-check form-check-inline align-items-center">
                                        <input type="radio" name="payment_mode" id="cash" value="cash_payment" class="form-check-input" checked>
                                        <label class="form-check-label mr-3" for="cash">Cash Payment</label>

                                        <input type="radio" name="payment_mode" id="cheque" value="cheque" class="form-check-input">
                                        <label class="form-check-label mr-3" for="cheque">Cheque</label>

                                        <input type="radio" name="payment_mode" id="neft" value="neft" class="form-check-input">
                                        <label class="form-check-label" for="neft">Transfer (NEFT)</label>
                                    </div>
                                </div>
                            </div> </br>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div id="cash_payment">
                                    <table class="table responsive-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Cash</th>
                                                <th>Receive</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <tr>
                                                <td><input type="number" class="form-control cash" name="cash_two_thousand" id="cash_two_thousand" value="2000" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_two_thousand" id="receive_two_thousand" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_two_thousand" id="amount_two_thousand" value="" readonly></td>
                                            </tr> -->
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_five_hundred" id="cash_five_hundred" value="500" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_five_hundred" id="receive_five_hundred" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_five_hundred" id="amount_five_hundred" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_two_hundred" id="cash_two_hundred" value="200" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_two_hundred" id="receive_two_hundred" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_two_hundred" id="amount_two_hundred" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_hundred" id="cash_hundred" value="100" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_hundred" id="receive_hundred" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_hundred" id="amount_hundred" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_fifty" id="cash_fifty" value="50" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_fifty" id="receive_fifty" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_fifty" id="amount_fifty" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_twenty" id="cash_twenty" value="20" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_twenty" id="receive_twenty" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_twenty" id="amount_twenty" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_ten" id="cash_ten" value="10" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_ten" id="receive_ten" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_ten" id="amount_ten" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control cash" name="cash_five" id="cash_five" value="5" readonly></td>
                                                <td><input type="number" class="form-control cashreceive" name="receive_five" id="receive_five" value=""></td>
                                                <td><input type="number" class="form-control amount" name="amount_five" id="amount_five" value="0" readonly></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Total:</td>
                                                <td><input type="number" class="form-control" name="total_amount" id="total_amount" value="0" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="cheque_payment" style="display:none" tabindex="11">
                                    <table class="table custom-table">
                                        <tbody>
                                            <tr>
                                                <td>Cheque Number</td>
                                                <td><input type="text" tabindex="13" class="form-control" name="cheque_number" id="cheque_number"></td>
                                            </tr>
                                            <tr>
                                                <td>Amount</td>
                                                <td><input type="text" tabindex="14" class="form-control" name="cheque_amount" id="cheque_amount"></td>
                                            </tr>
                                            <tr>
                                                <td>Cheque Date</td>
                                                <td><input type="date" tabindex="15" class="form-control" name="cheque_date" id="cheque_date"></td>
                                            </tr>
                                            <tr>
                                                <td>Bank Name</td>
                                                <td><input type="text" tabindex="16" class="form-control" name="cheque_bank_name" id="cheque_bank_name"></td>
                                            </tr>
                                            <tr>
                                                <td>Ledger</td>
                                                <td>
                                                    <div class="form-group">
                                                        <select tabindex="1" type="text" class="form-control" id="cheque_ledger_name" name="cheque_ledger_name" tabindex="1">
                                                            <option value="">Select ledger</option>
                                                            <option value="2022-2023">2022 - 2023</option>
                                                            <option value="2023-2024">2023 - 2024</option>
                                                            <option value="2024-2025">2024 - 2025</option>
                                                            <option value="2025-2026">2025 - 2026</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="neft_payment" style="display:none;" tabindex="11">
                                    <table class="table custom-table">
                                        <tbody>
                                            <tr>
                                                <td>NEFT Ref Number</td>
                                                <td><input type="text" tabindex="13" class="form-control" name="neft_number" id="neft_number"></td>
                                            </tr>
                                            <tr>
                                                <td>Amount</td>
                                                <td><input type="text" tabindex="14" class="form-control" name="neft_amount" id="neft_amount"></td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Date</td>
                                                <td><input type="date" tabindex="15" class="form-control" name="neft_date" id="neft_date"></td>
                                            </tr>
                                            <tr>
                                                <td>Bank Name</td>
                                                <td><input type="text" tabindex="16" class="form-control" name="neft_bank_name" id="neft_bank_name"></td>
                                            </tr>
                                            <tr>
                                                <td>Ledger</td>
                                                <td>
                                                    <div class="form-group">
                                                        <select tabindex="1" type="text" class="form-control" id="neft_ledger_name" name="neft_ledger_name" tabindex="1">
                                                            <option value="">Select Ledger</option>
                                                            <option value="2022-2023">2022 - 2023</option>
                                                            <option value="2023-2024">2023 - 2024</option>
                                                            <option value="2024-2025">2024 - 2025</option>
                                                            <option value="2025-2026">2025 - 2026</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                            <div class="text-right">
                                <div>
                                    <button type="submit" tabindex="19" name="submitpayfees" id="submitpayfees" class="btn btn-primary" value="submit" tabindex="10">Submit</button>
                                    <!-- <button type="reset"  tabindex="21" class="btn btn-outline-secondary">Cancel</button>  -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </form>
</div>