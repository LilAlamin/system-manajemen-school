<?php
// Include your database connection code here
require_once('../partials/_connection.php');

if (isset($_POST['class_id'])) {
    $classId = $_POST['class_id'];
    
    // Replace this with your SQL query to fetch subject_name for the class
    $query = "SELECT subject_name FROM class WHERE class_id = $classId";
    
    $result = $conn->query($query);
    
    if ($row = $result->fetch_assoc()) {
        // Send the subject_name directly as JSON
        echo json_encode(array('subject_name' => $row['subject_name']));
    }
}
?>

