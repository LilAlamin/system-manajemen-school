<?php
require_once('partials/_connection.php');

$result = $conn->query("SHOW COLUMNS FROM orang_tua");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . "\n";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
