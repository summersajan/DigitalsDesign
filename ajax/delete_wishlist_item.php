<?php
require_once '../config/db.php';
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['wishlist_item_id'] ?? 0);

if ($id > 0) {
    $stmt = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
