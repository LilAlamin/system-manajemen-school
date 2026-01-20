<?php
// Include your database connection code here
require_once('../partials/_connection.php');

if (isset($_POST['subject_ids'])) {
    $subjectIds = $_POST['subject_ids']; // $subjectIds is already an array

    // Initialize an array to store subjects
    $subjects = array();

    foreach ($subjectIds as $subjectId) {
        // Replace this with your SQL query to fetch subject names based on IDs
        $query = "SELECT subject_id, subject_name FROM `subject` WHERE subject_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $subjectId);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                // Add the subject to the subjects array
                $subjects[] = $row;
            }
        }
    }

    // Set the Content-Type header to indicate JSON response
    header('Content-Type: application/json');

    // Send the subjects array as JSON
    echo json_encode($subjects);
}
?>
