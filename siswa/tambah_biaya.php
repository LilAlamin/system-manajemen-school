<div class="container-fluid my-3">
    <div class="row card">
        <div class="col-md-8 mx-auto card shadow my-5">
            <h1 class="text-center bg-primary bg-gradient p-2 my-heading" style="background-color: #4598c7; color: white;">Pay Fee</h1>
            <form method="post" enctype='multipart/form-data' id="payFee">
                <?php
                if (isset($_GET['pay_fee_id'])) {
                    $pay_fee_id = $_GET['pay_fee_id'];
                    $add_sql = "SELECT * FROM `fee` WHERE fee_id = '$pay_fee_id'";
                    $add_result = $conn->query($add_sql);
                    $add_row = $add_result->fetch_assoc();
                ?>
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tution_fee" class="form-label">Tution Fee</label>
                                <input type="number" class="form-control" id="tution_fee" name="tution_fee" value="<?= $add_row['tution_fee'] ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="library_fee" class="form-label">Library Fee</label>
                                <input type="number" class="form-control" id="library_fee" name="library_fee" value="<?= $add_row['library_fee'] ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="sports_fee" class="form-label">Sports Fee</label>
                                <input type="number" class="form-control" id="sports_fee" name="sports_fee" value="<?= $add_row['sports_fee'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fee_amount" class="form-label">Fee Total Amount</label>
                                <input type="number" class="form-control" id="fee_amount" name="fee_amount" value="<?= $add_row['fee_amount'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="fee_month" class="form-label">Month</label>
                                <?php
                                $fee_month = $add_row['fee_month'];
                                $months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                ?>
                                <input type="text" class="form-control" id="fee_month" name="fee_month" value="<?= $months[$fee_month]; ?>" readonly>
                                <input type="hidden" class="form-control" id="fee_month_id" name="fee_month_id" value="<?= $add_row['fee_month']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="transaction_id" class="form-label">Transaction Id</label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id" value="<?= $add_row['transaction_id'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select id="payment_method" class="form-select" name="payment_method" required>
                                <option value="" selected disabled>Payment Method</option>
                                <?php
                                $payment_methods = ["Debit Card", "Credit Card", "Jazz Cash", "Eaasypaisa", "Sadapay"];
                                for ($i = 0; $i < 5; $i++) {
                                ?>
                                    <option value="<?= $i + 1 ?>"><?= $payment_methods[$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6" id="card_number_field" style="display: none;">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="number" class="form-control" id="card_number" name="card_number" required>
                            </div>
                            <div class="col-md-6" id="card_password_field" style="display: none;">
                                <label for="card_password" class="form-label">Card Password</label>
                                <input type="password" class="form-control" id="card_password" name="card_password" required>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="mt-2 text-center mb-5">
                        <button type="submit" class="btn btn-primary" name="pay_fee" id="pay_fee" on>Pay Now</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                    </h6>
            </form>
        </div>
    </div>
</div>

<?php
// Insert Class
if (isset($_POST['pay_fee'])) {
    $student_id = $_SESSION['student_id'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $fee_month_id = $_POST['fee_month_id'];
    $fee_month = $_POST['fee_month'];
    $student_id = $_SESSION['student_id'];
    $update_status = "UPDATE `fee` SET `f_student_id` = '$student_id', `fee_status` = 'Processing', `payment_method` = '$payment_method', `f_student_id` = '$student_id', `fee_submit_date` = current_timestamp() WHERE `fee_id` = '$pay_fee_id'";
    // echo $update_status;
    // exit;
    if ($conn->query($update_status)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Fee Submitted Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?biaya';
                });
            });
        </script>
        <?php
        $check_sql = "SELECT * FROM `fee` WHERE `transaction_id` = '$transaction_id' AND `fee_month` = '$fee_month_id' AND `fee_id` = '$pay_fee_id'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            // Display an error message for duplicate entry
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Duplicate entry!',
                        `You already paid fee for ${$fee_month}.`,
                        'error')
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Error!',
                        'Fee not Submitted',
                        'error')
                });
            </script>;
<?php
        }
    }
}
?>

<script>
    $(document).ready(function() {
        // Listen for changes in the payment method select
        $("#payment_method").change(function() {
            // Get the selected payment method
            var selectedMethod = $(this).val();

            // Update the field labels based on the selected payment method
            if (selectedMethod == 1) {
                $("#card_number_field label").text("Debit Card Number");
                $("#card_password_field label").text("Debit Card Pin");
            } else if (selectedMethod == 2) {
                $("#card_number_field label").text("Credit Card Number");
                $("#card_password_field label").text("Credit Card Pin");
            } else if (selectedMethod == 3) {
                $("#card_number_field label").text("JazzCash Number");
                $("#card_password_field label").text("JazzCash Pin");
            } else if (selectedMethod == 4) {
                $("#card_number_field label").text("EasyPaisa Number");
                $("#card_password_field label").text("EasyPaisa Pin");
            } else if (selectedMethod == 5) {
                $("#card_number_field label").text("SadaPay Number");
                $("#card_password_field label").text("SadaPay Pin");
            }

            // Show the fields
            $("#card_number_field").show();
            $("#card_password_field").show();
        });
    });
</script>