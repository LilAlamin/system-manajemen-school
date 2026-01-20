<div class="container my-3">
    <div class="row">
        <h1 class="text-center my-heading"><?= $course_title ?></h1>
        <?php
            require_once('_connection.php');
            $sql = "SELECT * FROM `course` LIMIT 6";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card-deck mt-2 col-md-4">
            <a href="" class="btn" style="text-align: left; padding: 0px; margin: 0px;"></a>
            <div class="card" style="width: 18rem;">
                <img src="./images/course_images/<?= $row['course_img'] ?>" class="card-img-top" alt="card-picture" height="200px">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['course_name'] ?></h5>
                    <p class="card-text"><?= $row['course_desc'] ?></p>
                </div>
                <div class="card-footer">
                    <p class="card-text d-inline"> Price: <small><del><?= $row['course_sale_price'] ?></del></small>
                        <span class="fw-bold"><?= $row['course_original_price'] ?></span>
                    </p>
                    <a href="course_detail.php?course_id=<?= $row['course_id'] ?>" class="btn btn-primary text-white fw-bold float-end mt-2">Enroll</a>
                </div>
            </div>
        </div>
        <?php
            }
        }
        else{
            echo 'No Records';
        }
        ?>
    </div>
</div>
<div class="text-center my-2">
    <a href="./courses.php" class="btn btn-danger btn-sm">View All Courses</a>
</div>
</div>