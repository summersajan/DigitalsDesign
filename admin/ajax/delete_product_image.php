<?php
require_once 'db.php';

$image_id = intval($_POST['image_id'] ?? 0);

if ($image_id <= 0) {
    echo "Invalid image id";
    exit;
}

$stmt = $mysqli->prepare("SELECT image_url FROM product_images WHERE image_id = ?");
$stmt->bind_param("i", $image_id);
$stmt->execute();
$stmt->bind_result($image_url);
if ($stmt->fetch()) {
    $file_path = __DIR__ . '/../../' . $image_url;
    if (file_exists($file_path))
        @unlink($file_path);
}
$stmt->close();

$stmt = $mysqli->prepare("DELETE FROM product_images WHERE image_id = ?");
$stmt->bind_param("i", $image_id);
if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Failed";
}
?>