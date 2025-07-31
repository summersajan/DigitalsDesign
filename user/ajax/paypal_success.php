<?php
require_once 'paypal_config.php';
include_once '../../config/db.php';
require_once '../auth/Mailer.php';
$mailer = new Mailer();
header("Content-Type: text/html; charset=utf-8");


if (!$usercode)
    die("Session expired. Please log in again.");

if (!isset($_GET['paymentId'], $_GET['PayerID'])) {
    die("❌ Missing PayPal payment ID or Payer ID.");
}

$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

// STEP 1: Get PayPal Access Token
$tokenResult = getAccessToken($paypal_base_url, $paypal_client_id, $paypal_secret);
if (!$tokenResult['success']) {
    die("❌ Failed to obtain PayPal access token: " . $tokenResult['error']);
}
$accessToken = $tokenResult['access_token'];

// STEP 2: Execute payment
$paypal_base_url = rtrim($paypal_base_url, '/') . '/';
$executeUrl = $paypal_base_url . "v1/payments/payment/$paymentId/execute";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $executeUrl,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $accessToken"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode(['payer_id' => $payerId]),
    CURLOPT_RETURNTRANSFER => true
]);
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($response['state']) || strtolower($response['state']) !== 'approved') {
    die("❌ Payment not approved.");
}

// STEP 3: Extract payment info
$transactionId = $response['id'] ?? '';
$payerEmail = $response['payer']['payer_info']['email'] ?? '';
$amount = $response['transactions'][0]['amount']['total'] ?? 0;
$currency = strtoupper($response['transactions'][0]['amount']['currency'] ?? 'USD');
$payment_time = date('Y-m-d H:i:s', strtotime($response['create_time'] ?? 'now'));

// STEP 4: Prevent duplicate payment
$stmt = $mysqli->prepare("SELECT payment_id FROM payments WHERE transaction_id = ? AND payment_status = 'success' LIMIT 1");
$stmt->bind_param('s', $transactionId);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("⚠️ Payment already recorded. Transaction ID: $transactionId");
}
$stmt->close();

// STEP 5: Get latest cart
$stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ? ORDER BY updated_at DESC LIMIT 1");
$stmt->bind_param('s', $usercode);
$stmt->execute();
$stmt->bind_result($cart_id);
if (!$stmt->fetch()) {
    die("❌ No cart found for user.");
}
$stmt->close();

// STEP 6: Get cart items
$stmt = $mysqli->prepare("
    SELECT ci.product_id, ci.quantity, p.price 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = ?
");
$stmt->bind_param('i', $cart_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();

if (empty($cart_items)) {
    die("❌ Cart is empty, cannot create order.");
}

// STEP 7: Create order
$stmt = $mysqli->prepare("INSERT INTO orders (usercode, order_status, total_amount, created_at, updated_at) VALUES (?, 'paid', ?, NOW(), NOW())");
$stmt->bind_param('sd', $usercode, $amount);
$stmt->execute();
$order_id = $mysqli->insert_id;
$stmt->close();

// STEP 8: Insert order items
$stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
foreach ($cart_items as $item) {
    $stmt->bind_param('iidi', $order_id, $item['product_id'], $item['price'], $item['quantity']);
    $stmt->execute();
}
$stmt->close();

// STEP 9: Insert payment
$stmt = $mysqli->prepare("INSERT INTO payments (order_id, usercode, amount, payment_method, payment_status, transaction_id, paid_at) VALUES (?, ?, ?, 'paypal', 'success', ?, ?)");
$stmt->bind_param('isdss', $order_id, $usercode, $amount, $transactionId, $payment_time);
$stmt->execute();
$stmt->close();

// STEP 10: Grant digital file access
foreach ($cart_items as $item) {
    $stmt = $mysqli->prepare("SELECT file_id FROM digital_files WHERE product_id = ?");
    $stmt->bind_param('i', $item['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($file = $result->fetch_assoc()) {
        $stmt2 = $mysqli->prepare("INSERT INTO order_files (order_id, product_id, file_id) VALUES (?, ?, ?)");
        $stmt2->bind_param('iii', $order_id, $item['product_id'], $file['file_id']);
        $stmt2->execute();
        $stmt2->close();
    }
    $stmt->close();
}

// STEP 11: Remove cart items
$stmt = $mysqli->prepare("DELETE FROM cart_items WHERE cart_id = ?");
$stmt->bind_param('i', $cart_id);
$stmt->execute();
$stmt->close();

// STEP 12: Remove cart
$stmt = $mysqli->prepare("DELETE FROM carts WHERE cart_id = ?");
$stmt->bind_param('i', $cart_id);
$stmt->execute();
$stmt->close();

// STEP 13: Generate download links
$downloadLinks = [];
foreach ($cart_items as $ci) {
    $stmt = $mysqli->prepare("SELECT f.file_id, of.order_file_id 
        FROM digital_files f
        JOIN order_files of ON f.file_id = of.file_id AND of.order_id = ? AND of.product_id = ?
        WHERE f.product_id = ?");
    $stmt->bind_param('iii', $order_id, $ci['product_id'], $ci['product_id']);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $link = $mail_url . "/user/ajax/download_files.php?order_file_id=" . $row['order_file_id'];
        $downloadLinks[] = $link;
    }

    $stmt->close();
}

// STEP 14: Send Email Receipt
if ($mailer->sendPurchaseReceipt($_SESSION['user_email'], $order_id, $cart_items, $amount, $downloadLinks)) {
    echo "✅ Email sent successfully.";
    echo "<h2>✅ Payment Received<br>Order ID: $order_id<br>Redirecting...</h2>";
    echo "<script>setTimeout(() => { window.location.href = '../index.php'; }, 2500);</script>";
} else {
    echo "❌ Failed to send email, but payment is successful.";
}

