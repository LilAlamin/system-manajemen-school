<?php
// Delete Period
if (isset($_GET['delete_fee_id'])) {
    $delete_fee_id = $_GET['delete_fee_id'];
    $delete_fee_sql = "DELETE FROM `fee` WHERE fee_id = '$delete_fee_id' ";
    if ($conn->query($delete_fee_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Fee Record has been Deleted Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?fee';
                });
            })
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Fee Record has not been Deleted', 'error');
            });
        </script>
<?php
    }
}
?>

<div class="row col-md-12 mx-auto my-5">
    <h1 class="text-center fs-1 mt-3 bg-dark bg-gradient p-2 my-heading">Fee Record</h1>
    <div class="mb-3">
        <a href="index.php?add_fee" class="btn btn-outline-info mb-3 float-end"> <i class="fas fa-plus-square"> Add Fee</i></a>
        <nav class="navbar">
            <form method="post" class="d-flex">
                <select class="form-select" name="feeStatusFilter" id="feeStatusFilter">
                    <option selected disabled>Select Fee Status</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Processing">Processing</option>
                    <option value="Paid">Paid</option>
                    <option value="All">All</option>
                </select>
                <button class="btn btn-success mx-2" name="fee_filer" type="submit">Filter</button>
            </form>
        </nav>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Class</th>
                <th scope="col">Student Name</th>
                <th scope="col">Fee Month</th>
                <th scope="col">Fee Amount</th>
                <th scope="col">Due Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Fee Status</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['fee_filer'])) {
                $fee_filer = $_POST['feeStatusFilter'];
                if($fee_filer === "All"){
                    $fee_sql = "SELECT * FROM `fee`";
                } else {
                    $fee_sql = "SELECT * FROM `fee` WHERE fee_status = '$fee_filer'";
                }
            } else{
                $fee_sql = "SELECT * FROM `fee`";
            }
                $fee_result = $conn->query($fee_sql);
                $sno = 1;
                while ($fee_row = $fee_result->fetch_assoc()) {
            ?>
                    <tr>
                        <th scope="row"><?= $sno++ ?></th>
                        <td>
                            <?php
                            $fee_class_id = $fee_row['f_class_id'];
                            $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$fee_class_id' ";
                            $class_result = $conn->query($fetch_class_sql);
                            $fetch_class_row = $class_result->fetch_assoc();
                            echo $fetch_class_row['class_name'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $fee_student_id = $fee_row['f_student_id'];
                            $fetch_student_sql = "SELECT student_name FROM students WHERE student_id = '$fee_student_id' ";
                            $student_result = $conn->query($fetch_student_sql);
                            $fetch_student_row = $student_result->fetch_assoc();
                            echo $fetch_student_row['student_name'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $fee_month = $fee_row['fee_month'];
                            $months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                            if ($fee_month >= 1 && $fee_month <= 12) {
                                echo $months[$fee_month];
                            } else {
                                echo "Invalid month"; // Add error handling for invalid values if needed
                            }
                            ?>
                        </td>
                        <td> <?= $fee_row['fee_amount'] ?> </td>
                        <td> <?= $fee_row['fee_due_date'] ?> </td>
                        <td> <?= $fee_row['fee_end_date'] ?> </td>
                        <td> <?= $fee_row['fee_status'] ?> </td>
                        <td> <?= $fee_row['created_at'] ?> </td>
                        <td>
                            <a class="btn btn-warning mx-1" href="index.php?edit_fee_id=<?= $fee_row['fee_id'] ?>"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger mx-1" href="index.php?delete_fee_id=<?= $fee_row['fee_id'] ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#feeStatusFilter").on("change", function() {
            var selectedStatus = $(this).val();
            // Call a function to filter fee records based on selectedStatus
            filterFeeRecords(selectedStatus);
        });
    });

    function filterFeeRecords(status) {
        // Use AJAX to send a request to the server with the selectedStatus
        $.ajax({
            type: "GET",
            url: "filter_fee_records.php",
            data: {
                status: status
            },
            success: function(response) {
                // Update the fee records table with the filtered data
                $("#feeRecordsTable").html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    }
</script>