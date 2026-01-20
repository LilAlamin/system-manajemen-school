<?php
// Generate Random Transaction Id
function generateUniqueTransactionID($length = 20)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $transactionID = '';
    for ($i = 0; $i < $length; $i++) {
        $transactionID .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $transactionID;
}

// Convert 'mm/dd/yyyy' format to 'YYYY-MM-DD' format
function convertToMySQLDate($date)
{
    $parts = explode('/', $date);
    if (count($parts) === 3) {
        list($month, $day, $year) = $parts;
        return "$year-$month-$day";
    }
    return false; // Invalid date format
}

// Insert Class
if (isset($_POST['create_fee'])) {
    $tution_fee = $_POST['tution_fee'];
    $library_fee = $_POST['library_fee'];
    $sports_fee = $_POST['sports_fee'];
    $fee_amount = $_POST['fee_amount'];
    $fee_month = $_POST['fee_month'];
    $fee_due_date = $_POST['fee_due_date'];
    $fee_end_date = $_POST['fee_end_date'];
    $fee_class = $_POST['fee_class'];
    $transaction_id = generateUniqueTransactionID();

    $due_date_mysql = convertToMySQLDate($due_date); // Convert to 'YYYY-MM-DD' format

    // Similarly, convert and compare the end date
    $due_date = $_POST['fee_due_date'];
    $due_date_mysql = convertToMySQLDate($due_date); // Convert to 'YYYY-MM-DD' format

    // Convert the end date and compare it to the due date
    $end_date = $_POST['fee_end_date'];
    $end_date_mysql = convertToMySQLDate($end_date); // Convert to 'YYYY-MM-DD' format

    if ($end_date_mysql <= $due_date_mysql) {
        // End date is not after the due date, show an error message
?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'End date must be after the due date.',
                    'error')
            });
        </script>

    <?php
    }

    $check_sql = "SELECT * FROM `fee` WHERE `f_class_id` = '$fee_class' AND `fee_month` = '$fee_month'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Display an error message for duplicate entry
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Duplicate entry!',
                    'The fee record already exists for this class.',
                    'error')
            });
        </script>
        <?php
    } else {
        $insert_fee_sql = "INSERT INTO `fee` (`tution_fee`, `sports_fee`, `library_fee`, `fee_amount`, `fee_month`, `fee_due_date`, `fee_end_date`, `f_class_id`, `transaction_id`, `created_at`) VALUES ('$tution_fee', '$sports_fee', '$library_fee', '$fee_amount', '$fee_month', '$fee_due_date', '$fee_end_date', '$fee_class', '$transaction_id', current_timestamp());";
        // echo $insert_fee_sql;
        // exit;
        if ($conn->query($insert_fee_sql)) {

        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Fee has been Added Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?fee';
                    });
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Error!',
                        'Fee has not been Inserted!',
                        'error')
                });
            </script>
<?php
        }
    }
}
?>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading" style="background-color: #4598c7; color: white;">Gennerate Fee</h1>
            <form method="post" enctype='multipart/form-data' id="payFee">
                <div class="row mt-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tution_fee" class="form-label">Tution Fee</label>
                            <input type="number" class="form-control" id="tution_fee" name="tution_fee" required placeholder="Tution Fee">
                        </div>
                        <div class="col-md-4">
                            <label for="library_fee" class="form-label">Library Fee</label>
                            <input type="number" class="form-control" id="library_fee" name="library_fee" placeholder="Library Fee">
                        </div>
                        <div class="col-md-4">
                            <label for="sports_fee" class="form-label">Sports Fee</label>
                            <input type="number" class="form-control" id="sports_fee" name="sports_fee" placeholder="Sports Fee">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fee_amount" class="form-label">Fee Total Amount</label>
                            <input type="number" class="form-control" id="fee_amount" name="fee_amount" value="<?= $total_amount ?>" readonly placeholder="Fee Total Amount">
                        </div>
                        <div class="col-md-4">
                            <label for="s" class="form-label">Select Class</label>
                            <select id="fee_class" class="form-select" name="fee_class" required>
                                <option value="" selected disabled>Select Class</option>
                                <?php
                                $class_sql = "SELECT * FROM `class`";
                                $class_result = $conn->query($class_sql);
                                while ($class_row = $class_result->fetch_assoc()) {
                                ?>
                                    <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="fee_month" class="form-label">Select Month</label>
                            <select id="fee_month" class="form-select" name="fee_month" required>
                                <option value="" disabled selected>Select Month</option>
                                <?php
                                $months = array(
                                    "January", "February", "March", "April", "May", "June", "July",
                                    "August", "September", "October", "November", "December"
                                );
                                for ($i = 0; $i < 12; $i++) {
                                ?>
                                    <option value="<?= $i + 1 ?>"><?= $months[$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fee_due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="fee_due_date" name="fee_due_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fee_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="fee_end_date" name="fee_end_date" required>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_fee" id="create_fee">Create Fee</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
                </h6>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to calculate the total fee amount using jQuery
    function calculateTotal() {
        var tuitionFee = parseFloat($('#tution_fee').val()) || 0;
        var libraryFee = parseFloat($('#library_fee').val()) || 0;
        var sportsFee = parseFloat($('#sports_fee').val()) || 0;
        var totalFee = tuitionFee + libraryFee + sportsFee;

        // Update the fee amount field with the calculated total using jQuery
        $('#fee_amount').val(totalFee);
    }

    // Attach the calculateTotal function to the input fields' change event
    $('#tution_fee, #library_fee, #sports_fee').on('input', calculateTotal);
</script>