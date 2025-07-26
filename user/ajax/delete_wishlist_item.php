<?php
include_once '../../config/db.php';

header('Content-Type: application/json');

// Get raw input data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['wishlist_item_id'])) {
    echo json_encode(["success" => false, "message" => "Missing wishlist_item_id"]);
    exit;
}

$wishlist_item_id = intval($data['wishlist_item_id']);

// Delete the item from wishlist_items table
$stmt = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_item_id = ?");
$stmt->bind_param("i", $wishlist_item_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete item"]);
}

$stmt->close();
$mysqli->close();
?>