<?php

session_start();
if (isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == TRUE) {
} else {
    header('Location: ../login.php');
}

require_once('../partials/_connection.php');

// Insert notice
if (isset($_POST['add'])) {
    $notice_title = $_POST['notice_title'];
    $notice_desc = $_POST['notice_desc'];
    $notice_class = $_POST['notice_class'];
    $post_id = $_SESSION['teacher_id'] . 555;

    $teacher_gender = $_SESSION['teacher_gender'];
    $teacher_name = $_SESSION['teacher_name'];
    $gender = ($teacher_gender === 'Male') ? 'Sir ' : (($teacher_gender === 'Female') ? 'Miss ' : '');
    $posted_by = $gender . $teacher_name;
    if($_POST['notice_class'] == 'all'){
        $sql = "INSERT INTO `notice` (`notice_title`, `notice_desc`, `posted_by`, `n_post_id`, `notice_date`) VALUES ('$notice_title', '$notice_desc', '$posted_by', '$post_id', current_timestamp());";
      } else{
        $sql = "INSERT INTO `notice` (`notice_title`, `notice_desc`, `n_class_id`, `posted_by`, `n_post_id`, `notice_date`) VALUES ('$notice_title', '$notice_desc','$notice_class', '$posted_by', '$post_id',  current_timestamp());";
      }
    if ($conn->query($sql)) {
        echo 'success';
    } else {
        echo 'error: ' . $conn->error;
    }
} else {
    echo 'error: Invalid request';
}