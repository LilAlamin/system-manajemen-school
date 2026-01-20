<div class="remove-video-margin">
    <div class="video-parent">
        <video playinline autoplay muted loop>
            <source src="../sms/assets/videos/study.mp4">
        </video>
        <div class="video-overlay"></div>
    </div>
    <div class="video-content">
        <h1 class="my-content">Welcome to iSchool</h1>
        <small class="my-content my-3">Learn and Implement</small>
        <br>
        <?php
            // Start the session
            if (!isset($_SESSION)) {
                session_start();
            }

            if (isset($_SESSION['student_login']) && $_SESSION['student_login'] == TRUE) {
                echo '<a href="siswa/index.php" class="btn btn-danger mt-2">My Profile</a>';
            } elseif (isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == TRUE) {
                echo '<a href="guru/index.php" class="btn btn-danger mt-2">My Profile</a>';
            } elseif (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == TRUE) {
                echo '<a href="admin/index.php" class="btn btn-danger mt-2">My Profile</a>';
            } else {
                echo '<a href="" class="btn btn-danger mt-2">Get Started</a>';
            }
        ?>
    </div>
</div>
