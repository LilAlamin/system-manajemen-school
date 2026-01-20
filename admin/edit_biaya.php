<div class="row my-4">
    <div class="col-md-10 mx-auto">
        <h1 class="text-center my-5 bg-dark bg-gradient p-2 my-heading">Edit Fee</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_fee_id'])) {
                $edit_fee_id = $_GET['edit_fee_id'];
                $edit_sql = "SELECT * FROM `fee` WHERE fee_id = '$edit_fee_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tution_fee" class="form-label">Tution Fee</label>
                        <input type="text" class="form-control" id="tution_fee" name="tution_fee" value="<?= $edit_row['tution_fee'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="library_fee" class="form-label">Library Fee</label>
                        <input type="text" class="form-control" id="library_fee" name="library_fee" value="<?= $edit_row['library_fee'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="sports_fee" class="form-label">Sports Fee</label>
                        <input type="text" class="form-control" id="sports_fee" name="sports_fee" value="<?= $edit_row['sports_fee'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fee_amount" class="form-label">Fee Amount</label>
                        <input type="text" class="form-control" id="fee_amount" name="fee_amount" readonly value="<?= $edit_row['fee_amount'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="fee_class" class="form-label">Select Class</label>
                        <select id="fee_class" class="form-select" name="fee_class">
                            <option value="" selected>Select Class</option>
                            <?php
                            $fetch_class_sql = "SELECT * FROM class";
                            $class_result = $conn->query($fetch_class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>" <?php if ($edit_row['f_class_id'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                    <label for="fee_month" class="form-label">Select Month</label>
                    <select id="fee_month" class="form-select" name="fee_month">
                        <option value="" selected>Select Month</option>
                        <?php
                        for ($fee_month = 1; $fee_month <= 12; $fee_month++) {
                            $fee_month_name = "";
                            switch ($fee_month) {
                                case 1:
                                    $fee_month_name = "January";
                                    break;
                                case 2:
                                    $fee_month_name = "February";
                                    break;
                                case 3:
                                    $fee_month_name = "March";
                                    break;
                                case 4:
                                    $fee_month_name = "April";
                                    break;
                                case 5:
                                    $fee_month_name = "May";
                                    break;
                                case 6:
                                    $fee_month_name = "June";
                                    break;
                                case 7:
                                    $fee_month_name = "July";
                                    break;
                                case 8:
                                    $fee_month_name = "August";
                                    break;
                                case 9:
                                    $fee_month_name = "September";
                                    break;
                                case 10:
                                    $fee_month_name = "October";
                                    break;
                                case 11:
                                    $fee_month_name = "November";
                                    break;
                                case 12:
                                    $fee_month_name = "December";
                                    break;
                            }
                            ?>
                            <option value="<?= $fee_month ?>" <?php if ($edit_row['fee_month'] == $fee_month) { ?> selected <?php } ?>>
                                <?= $fee_month_name ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="mb-4 row">
                <div class="col-md-6">
                    <label for="fee_due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="fee_due_date" name="fee_due_date"
                    value="<?= $edit_row['fee_due_date'] ?>">
                </div>
                <div class="col-md-6">
                    <label for="fee_end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="fee_end_date" name="fee_end_date"
                    value="<?= $edit_row['fee_end_date'] ?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="fee_status" class="form-label">Fee Status &nbsp;&nbsp;&nbsp;</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($edit_row['fee_status'] == 'Unpaid') { ?> checked <?php } ?> type="radio" name="fee_status" id="unpaid" value="Unpaid">
                    <label class="form-check-label" for="male">Unpaid</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($edit_row['fee_status'] == 'Processing') { ?> checked <?php } ?> type="radio" name="fee_status" id="processing" value="Processing">
                    <label class="form-check-label" for="male">Processing</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($edit_row['fee_status'] == 'Paid') { ?> checked <?php } ?> type="radio" name="fee_status" id="paid" value="paid">
                    <label class="form-check-label" for="male">Paid</label>
                </div>
            </div>
            <?php } ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_fee" id="update_fee">Update</button>
                <a href="index.php?fee" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_fee'])) {;
    $tution_fee = $_POST['tution_fee'];
    $library_fee = $_POST['library_fee'];
    $sports_fee = $_POST['sports_fee'];
    $fee_amount = $_POST['fee_amount'];
    $fee_month = $_POST['fee_month'];
    $fee_due_date = $_POST['fee_due_date'];
    $fee_end_date = $_POST['fee_end_date'];
    $fee_class = $_POST['fee_class'];
    $fee_status = $_POST['fee_status'];

    $update_sql = "UPDATE `fee` SET `tution_fee` = '$tution_fee', `library_fee` = '$library_fee', `sports_fee` = '$sports_fee', `fee_amount` = '$fee_amount', `fee_month` = '$fee_month', `fee_due_date` = '$fee_due_date', `fee_end_date` = '$fee_end_date', `f_class_id` = '$fee_class', `fee_status` = '$fee_status' WHERE `fee_id` = '$edit_fee_id'";
    // echo $update_sql;
    // exit;
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Fee Record has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?fee';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Fee Record has not been Updated', 'error');
            });
        </script>
<?php
    }
}
?>

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