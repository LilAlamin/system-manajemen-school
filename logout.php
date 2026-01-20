<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['student_login']) || $_SESSION['teacher_login'] || $_SESSION['admin_login']) {
        // header("location: ../index.php");
        // echo "<script> window.location.href='index.php' </script>";
    }
    //session_start();

    session_unset();
    session_destroy();

    // header("location: ../index.php");
    echo "<script> window.location.href='index.php' </script>";
?>