<?php
require_once '../config/db.php';
header('Content-Type: application/json; charset=utf-8');


// Get the cart for this user
$cart = $mysqli->query("SELECT cart_id FROM carts WHERE usercode = '$usercode' LIMIT 1");
if (!$cart->num_rows) {
    echo json_encode([]);
    exit;
}
$cart_id = $cart->fetch_assoc()['cart_id'];
// Get cart items and join with product info
$result = $mysqli->query(
    "SELECT ci.cart_item_id, ci.product_id, ci.quantity,
            p.title, p.price, pi.image_url
        FROM cart_items ci
        JOIN products p ON p.product_id = ci.product_id
        LEFT JOIN product_images pi ON pi.product_id = p.product_id AND pi.is_main = 1
        WHERE ci.cart_id = $cart_id"
);
$items = [];
while ($row = $result->fetch_assoc())
    $items[] = $row;

echo json_encode($items);