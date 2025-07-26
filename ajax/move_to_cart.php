<?php
require_once '../config/db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$wishlist_item_id = intval($data['wishlist_item_id'] ?? 0);
$product_id = intval($data['product_id'] ?? 0);
$usercode = $_SESSION['usercode'] ?? '';

if (!$usercode || !$wishlist_item_id || !$product_id) {
    echo json_encode(["success" => false]);
    exit;
}

// Add to cart
$stmt = $mysqli->prepare("INSERT INTO cart_items (usercode, product_id, quantity, added_at) VALUES (?, ?, 1, NOW())");
$stmt->bind_param("si", $usercode, $product_id);
$stmt->execute();

// Delete from wishlist
$stmt = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_item_id = ?");
$stmt->bind_param("i", $wishlist_item_id);
$stmt->execute();

echo json_encode(["success" => true]);
