<?php
require_once '../config/db.php';


header('Content-Type: application/json; charset=utf-8');

$cart_item_id = intval($_POST['cart_item_id'] ?? 0);
// Check cart item belongs to current user's cart
$cart = $mysqli->query("SELECT cart_id FROM carts WHERE usercode = '$usercode' LIMIT 1");
if (!$cart->num_rows)
    die("fail");
$cart_id = $cart->fetch_assoc()['cart_id'];

// Delete the item
$stmt = $mysqli->prepare("DELETE FROM cart_items WHERE cart_item_id=? AND cart_id=?");
$stmt->bind_param("ii", $cart_item_id, $cart_id);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Cart item deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Item not found or already deleted"]);
}