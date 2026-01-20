<?php
require_once('../partials/_connection.php');
// Retrieve the student's ID from the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    
    // Use correct table 'siswa' and column 'id_siswa'
    $fetch_student_sql = "SELECT * FROM siswa WHERE id_siswa = '$student_id' ";
    $student_result = $conn->query($fetch_student_sql);
    
    if ($student_result && $student_result->num_rows > 0) {
        $student_row = $student_result->fetch_assoc();
        // Start a session for the student
        if (!isset($_SESSION)) {
             session_start();
        }
        
        // Disable parent login to avoid conflicts or handle multi-auth (usually one active user per session is safer)
        // But here it seems to want to "switch" to student.
        // Let's set student login true.
        $_SESSION['student_login'] = TRUE;
        $_SESSION['student_id'] = $student_row['id_siswa'];
        $_SESSION['student_name'] = $student_row['nama_siswa'];
        $_SESSION['student_email'] = $student_row['email_siswa'];
        $_SESSION['student_rollno'] = $student_row['id_sims'];
        $_SESSION['student_class'] = $student_row['kelas_siswa'];
        $_SESSION['student_pic'] = $student_row['foto_siswa'];

        echo "<script> window.location.href='../siswa/index.php?profil' </script>";
        exit;
    } else {
         echo "Data siswa tidak ditemukan.";
    }
} else {
    // Handle the case when no student ID is provided in the URL
    echo "Please select a student from the parent dashboard.";
}
?>
