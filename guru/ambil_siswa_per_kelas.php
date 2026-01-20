<?php
// Include your database connection code here
require_once('../partials/_connection.php');

if (isset($_POST['class_id'])) {
    $classId = $_POST['class_id'];

    // Replace this with your SQL query to fetch students for the class
    $query = "SELECT student_id, student_name FROM students WHERE student_class = $classId";

    $result = $conn->query($query);

    $students = array();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    // Set the Content-Type header to indicate JSON response
    header('Content-Type: application/json');

    // Send the students array as JSON
    echo json_encode(array('students' => $students));
}
?>
