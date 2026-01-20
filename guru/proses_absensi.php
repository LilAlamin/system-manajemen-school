<?php
require_once('../partials/_connection.php');

if (isset($_POST['studentAttendance']) && isset($_POST['teacher_id']) && isset($_POST['class_id'])) {
    $studentAttendance = $_POST['studentAttendance'];
    $teacher_id = $_POST['teacher_id'];
    $class_id = $_POST['class_id'];
    $attendance_date = date("Y-m-d");

    $success = true; 

    foreach ($studentAttendance as $student_id => $status) {
        $sql = "INSERT INTO `attendance` (`a_teacher_id`, `a_class_id`, `a_student_id`, `attendance_status`, `attendance_date`) VALUES ('$teacher_id', '$class_id', '$student_id', '$status', '$attendance_date')";
        
        if (!$conn->query($sql)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo 'success';
    } else {
        echo 'error: ' . $conn->error;
    }

    $conn->close();
}
?>
