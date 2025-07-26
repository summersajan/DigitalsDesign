<?php
require_once '../config/db.php';
header('Content-Type: application/json; charset=utf-8');
$user_id = 2; // Replace with real login/session logic

// Get the cart for this user
$cart = $mysqli->query("SELECT cart_id FROM carts WHERE user_id = $user_id LIMIT 1");


$cart_id = $cart->fetch_assoc()['cart_id'];

echo json_encode($cart_id);
