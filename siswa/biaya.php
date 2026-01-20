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
                window.location.href = 'index.php?biaya';
        });
    })

        </script>
    <?php
    } 
    else {
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
    <h1 class="text-center fs-1 mt-3 bg-primary bg-gradient p-2 my-heading">Fee Record</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Fee Month</th>
                <th scope="col">Fee Amount</th>
                <th scope="col">Due Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Fee Status</th>
                <th scope="col">Pay Now</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $student_class = $_SESSION['student_class'];
            $student_id = $_SESSION['student_id'];
            $fee_sql = "SELECT * FROM `fee` WHERE f_class_id = $student_class";
            $fee_result = $conn->query($fee_sql);
            $sno = 1;
            while ($fee_row = $fee_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> 
                        <?php
                            $fee_month = $fee_row['fee_month'];
                            $months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                            if ($fee_month >= 1 && $fee_month <= 12) {
                                echo $months[$fee_month];
                            } else {
                                echo "Invalid month"; 
                            }
                        ?> 
                    </td>
                    <td> <?= $fee_row['fee_amount'] ?> </td>
                    <td> <?= $fee_row['fee_due_date'] ?> </td>
                    <td> <?= $fee_row['fee_end_date'] ?> </td>
                    <td> <?= $fee_row['fee_status'] ?> </td>
                    <?php 
                        if($fee_row['fee_status'] == "Unpaid"){
                    ?>
                    <td> <a class="btn btn-secondary mx-1" href="index.php?pay_fee_id=<?= $fee_row['fee_id'] ?>"><i class="fa fa-dollar"> Pay Now</i></a> <td>
                        <?php  } else if($fee_row['fee_status'] == "Processing") {  ?>
                            
                            <td> <a class="btn btn-warning mx-1" href="#"><i class="fa fa-clock"> Processing</i></a> <td>
                    <?php }  else{  ?> 
                            <td> <a class="btn btn-success mx-1" href="#"><i class="fa fa-check-circle"> Paid</i></a> <td>
                    <?php }  ?>
                        <a class="btn btn-warning mx-1" href="index.php?edit_fee_id=<?= $fee_row['fee_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_fee_id=<?= $fee_row['fee_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>