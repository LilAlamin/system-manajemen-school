<?php
    if (!isset($_SESSION)) {
        session_start();
    }
   
    // Destroy session
    session_unset();
    session_destroy();

    // Redirect to Login Page
    header("Location: ../login.php");
    exit;
?>