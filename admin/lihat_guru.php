<?php
if (isset($_GET['view_teacher_id'])) {
    $view_teacher_id = $_GET['view_teacher_id'];
    $view_sql = "SELECT * FROM `teachers` WHERE teacher_id = '$view_teacher_id'";
    $view_result = $conn->query($view_sql);
    if (!$view_result) {
        echo "Error. $conn->error;";
    } else {
        $teacher_row = $view_result->fetch_assoc();
?>
        <div class="container my-5">
            <div class="card">
                <div class="card-header bg-dark bg-gradient text-white">
                    <h3 class="text-center my-3 my-heading">View Teacher All Record</h3>
                </div>
                <div class="card-body fs-5">
                    <?php foreach ($teacher_row as $field => $value) { ?>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">
                                <?= ucwords(str_replace('_', ' ', $field)) ?>
                            </div>
                            <div class="col-md-8">
                                <?= $value ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <a href="index.php?teacher" class="btn btn-danger mb-5">Back</a>
        </div>
<?php
    }
}
?>

