<?php
// guru/get_students_by_class.php
require_once '../partials/_connection.php'; // Ensure database connection is included

header('Content-Type: application/json');

if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    
    // Prevent SQL Injection - though typically prepared statements are better, 
    // sticking to the project's style ($conn->real_escape_string or direct if trusted context, but let's be safe)
    $class_id = $conn->real_escape_string($class_id);

    $sql = "SELECT id_siswa, nama_siswa FROM siswa WHERE kelas_siswa = '$class_id' ORDER BY nama_siswa ASC";
    $result = $conn->query($sql);

    $students = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = [
                'student_id' => $row['id_siswa'],
                'student_name' => $row['nama_siswa']
            ];
        }
    }

    echo json_encode(['students' => $students]);
} else {
    echo json_encode(['students' => []]);
}
?>
