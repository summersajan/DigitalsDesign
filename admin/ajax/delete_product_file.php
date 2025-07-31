<?php
require_once 'db.php';

$file_id = intval($_POST['file_id'] ?? 0);

if ($file_id > 0) {
    // Get file path before deletion
    $stmt = $mysqli->prepare("SELECT file_url FROM digital_files WHERE file_id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $file_path = __DIR__ . '/../../' . $row['file_url'];

        // Delete from database
        $stmt2 = $mysqli->prepare("DELETE FROM digital_files WHERE file_id = ?");
        $stmt2->bind_param("i", $file_id);

        if ($stmt2->execute()) {
            // Delete physical file
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo "ok";
        } else {
            echo "Database error";
        }
    } else {
        echo "File not found";
    }
} else {
    echo "Invalid file ID";
}
?>