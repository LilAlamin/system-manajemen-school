<?php
require_once('../partials/_connection.php');

if (isset($_POST['class_id'])) {
    $classId = $_POST['class_id'];

    // Fetch 'nama_seksi' from 'kelas' table
    // nama_seksi contains ids like "41,50"
    $class_sql = "SELECT `nama_seksi` FROM `kelas` WHERE `id_kelas` = '$classId'";
    $class_result = $conn->query($class_sql);

    if ($class_result && $class_result->num_rows > 0) {
        $class_row = $class_result->fetch_assoc();
        
        if (!empty($class_row['nama_seksi'])) {
            $section_ids = explode(',', $class_row['nama_seksi']);
            
            // Sanitize IDs just in case
            $section_ids = array_map('intval', $section_ids);
            
            if (!empty($section_ids)) {
                $ids_string = implode(',', $section_ids);
                
                // Fetch section details from 'seksi' table
                $section_sql = "SELECT `id_seksi`, `judul_seksi` FROM `seksi` WHERE `id_seksi` IN ($ids_string)";
                $section_result = $conn->query($section_sql);

                $section_data = array();
                if ($section_result) {
                    while ($section_row = $section_result->fetch_assoc()) {
                        $section_data[] = $section_row;
                    }
                }
                
                header('Content-Type: application/json');
                echo json_encode($section_data);
            } else {
                 echo json_encode([]);
            }
        } else {
            echo json_encode([]);
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['error' => 'Class not found']);
    }
}
?>
