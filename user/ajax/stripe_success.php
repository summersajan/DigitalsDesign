<?php
require_once 'stripe_config.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);


include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line

require_once '../auth/Mailer.php';
$mailer = new Mailer();

if (!$usercode) {
    die("❌ Missing session or user not logged in.");
}

$sessionId = $_GET['session_id'];

// STEP 1: Get Stripe session
try {
    $session = \Stripe\Checkout\Session::retrieve($sessionId);
    $paymentIntentId = $session->payment_intent;

    // Get full payment info
    $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
    $customerEmail = $session->customer_details['email'];
    $amount = $paymentIntent->amount_received / 100; // convert cents to dollars
    $currency = strtoupper($paymentIntent->currency);
    $payment_time = date('Y-m-d H:i:s', $paymentIntent->created);

    $transactionId = $paymentIntent->id;

} catch (Exception $e) {
    die("❌ Stripe error: " . $e->getMessage());
}

// STEP 2: Check for duplicate transaction
$stmt = $mysqli->prepare("SELECT payment_id FROM payments WHERE transaction_id = ? AND payment_status = 'success' LIMIT 1");
$stmt->bind_param('s', $transactionId);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("⚠️ Payment already recorded. Transaction ID: $transactionId");

}
$stmt->close();

// STEP 3: Get latest cart for user
$stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ? ORDER BY updated_at DESC LIMIT 1");
$stmt->bind_param('s', $usercode);
$stmt->execute();
$stmt->bind_result($cart_id);
if (!$stmt->fetch()) {
    die("No cart found for user.");
}
$stmt->close();

// STEP 4: Get cart items & prices
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

// STEP 5: Create order
$stmt = $mysqli->prepare("INSERT INTO orders (usercode, order_status, total_amount, created_at, updated_at) VALUES (?, 'paid', ?, NOW(), NOW())");
$stmt->bind_param('sd', $usercode, $amount);
$stmt->execute();
$order_id = $mysqli->insert_id;
$stmt->close();

// STEP 6: Insert order_items
$stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
foreach ($cart_items as $item) {
    $stmt->bind_param('iidi', $order_id, $item['product_id'], $item['price'], $item['quantity']);
    $stmt->execute();
}
$stmt->close();

// STEP 7: Insert payment
$stmt = $mysqli->prepare("INSERT INTO payments (order_id, usercode, amount, payment_method, payment_status, transaction_id, paid_at) VALUES (?, ?, ?, 'stripe', 'success', ?, ?)");
$stmt->bind_param('isdss', $order_id, $usercode, $amount, $transactionId, $payment_time);
$stmt->execute();
$stmt->close();

// STEP 8: Grant digital file access
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



// --- Step 11: Remove cart items
$stmt = $mysqli->prepare("DELETE FROM cart_items WHERE cart_id = ?");
$stmt->bind_param('i', $cart_id);
if (!$stmt->execute())
    die("SQL error (cart_items delete): " . $stmt->error);
$stmt->close();


// --- Step 12: Remove carts
$stmt = $mysqli->prepare("DELETE FROM carts WHERE cart_id = ?");
$stmt->bind_param('i', $cart_id);
if (!$stmt->execute())
    die("SQL error (cart_items delete): " . $stmt->error);
$stmt->close();


$downloadLinks = [];

foreach ($cart_items as $ci) {

    $stmt = $mysqli->prepare("SELECT f.file_id, of.order_file_id 
        FROM digital_files f
        JOIN order_files of ON f.file_id = of.file_id AND of.order_id = ? AND of.product_id = ?
        WHERE f.product_id = ?");
    $stmt->bind_param('iii', $order_id, $ci['product_id'], $ci['product_id']);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo "<p>❌ No match for product_id: {$ci['product_id']}</p>";
    }

    while ($row = $res->fetch_assoc()) {
        $link = $mail_url . "/user/ajax/download_files.php?order_file_id=" . $row['order_file_id'];
        $downloadLinks[] = $link;

    }

    $stmt->close();
}

if ($mailer->sendPurchaseReceipt($_SESSION['user_email'], $order_id, $cart_items, $amount, $downloadLinks)) {
    echo "✅ Email sent successfully.";
    echo "<h2>✅ Payment Received<br>Order ID: $order_id<br>Redirecting...</h2>";
    echo "<script>setTimeout(() => { window.location.href = '../index.php'; }, 2500);</script>";
} else {
    echo "❌ Failed to send email. but payment is successful.";
}

?>