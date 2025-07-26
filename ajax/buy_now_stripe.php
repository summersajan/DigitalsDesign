<?php
require_once '../config/db.php';
header('Content-Type: application/json');
include '../user/ajax/stripe_config.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
header('Content-Type: application/json');



if (!$usercode) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}


$product_ids = $_POST['product_ids'] ?? [];
$quantities = $_POST['quantities'] ?? [];

if (!is_array($product_ids) || !is_array($quantities) || count($product_ids) !== count($quantities)) {
    echo json_encode(['error' => 'Invalid product data.']);
    exit;
}

$line_items = [];
$total_amount = 0.0;

// Prepare product details
$stmt = $mysqli->prepare("SELECT title, price FROM products WHERE product_id = ?");
foreach ($product_ids as $i => $pid) {
    $qty = intval($quantities[$i]);
    if ($qty < 1)
        continue;

    $pid = intval($pid);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->bind_result($title, $price);
    if ($stmt->fetch()) {
        $amount = round($price, 2);
        $total_amount += $amount * $qty;

        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => $title],
                'unit_amount' => intval($amount * 100), // In cents!
            ],
            'quantity' => $qty
        ];
    }
}
$stmt->close();

if (empty($line_items)) {
    echo json_encode(['error' => 'Cart is empty or invalid items.']);
    exit;
}

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => MAIN_URL . 'stripe_success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => MAIN_URL . 'stripe_cancel.php',
    ]);

    echo json_encode([
        'status' => 'success',
        'checkoutUrl' => $checkout_session->url
    ]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
