<?php
require_once('../partials/_connection.php');

$subjectName = $_GET['subjectName'];

// Use $subjectName to fetch exam data from your database
// Modify the SQL query accordingly based on your database structure
$sql = "SELECT * FROM `exam` WHERE subject_name = '$subjectName'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $output = '<table class="table table-hover table-bordered">';
    $output .= '<thead class="table-light">';
    $output .= '<tr>';
    $output .= '<th scope="col">Title</th>';
    $output .= '<th scope="col">Total Marks</th>';
    $output .= '<th scope="col">Obtained Marks</th>';
    $output .= '<th scope="col">Percentage</th>';
    $output .= '</tr>';
    $output .= '</thead>';
    $output .= '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>';
        $output .= '<td>' . $row['exam_name'] . '</td>';
        $output .= '<td>' . $row['total_marks'] . '</td>';
        $output .= '<td>' . $row['obtained_marks'] . '</td>';
        $percentage = ($row['obtained_marks'] / $row['total_marks']) * 100;
        $output .= '<td>' . round($percentage, 2) . '%</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody>';
    $output .= '</table>';
} else {
    $output = '<p>No exam data available for this subject.</p>';
}

// Close the database connection
$conn->close();

echo $output;
?>
