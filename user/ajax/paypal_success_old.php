<?php
require_once 'paypal_config.php';
include_once '../../config/db.php';
require_once '../auth/Mailer.php';
$mailer = new Mailer();
header("Content-Type: text/html; charset=utf-8"); // Add this line


// Helpful debugging: show all errors


// --- Step 0: Initial Checks
if (!isset($_GET['paymentId'], $_GET['PayerID'])) {
    die("Payment failed or canceled (missing paymentId/PayerID).");
}



if (!$usercode)
    die("Session expired. Please log in again.");

// Gather GET payment params
$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

// --- Step 1: Get PayPal access token
$accessToken = getAccessToken();
if (!$accessToken) {
    die("Could not get PayPal access token.");
}

// --- Step 2: Execute the Payment
$executeData = ["payer_id" => $payerId];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, PAYPAL_BASE_URL . "v1/payments/payment/$paymentId/execute");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($executeData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($response['state']) || $response['state'] !== "approved") {
    echo "<pre>PayPal API result:\n" . print_r($response, true) . "</pre>";
    die("❌ Payment failed. If any amount is deducted, please contact support.");
}

// --- Step 3: Extract Payment Info
$transactionId = $response['id'];
$payerEmail = $response['payer']['payer_info']['email'];
$amount = $response['transactions'][0]['amount']['total'];
$currency = $response['transactions'][0]['amount']['currency'];
$payment_time = date('Y-m-d H:i:s', strtotime($response['create_time']));

// --- Step 4: Prevent duplicate transaction
$stmt = $mysqli->prepare("SELECT payment_id FROM payments WHERE transaction_id = ? AND payment_status = 'success' LIMIT 1");
$stmt->bind_param('s', $transactionId);
if (!$stmt->execute())
    die("SQL error (duplicate check): " . $stmt->error);
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("⚠️ Payment already recorded. Transaction ID: $transactionId");
}
$stmt->close();

// --- Step 5: Get latest cart for user
$stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ? ORDER BY updated_at DESC LIMIT 1");
$stmt->bind_param('s', $usercode);
if (!$stmt->execute())
    die("SQL error (cart lookup): " . $stmt->error);
$stmt->bind_result($cart_id);
if (!$stmt->fetch())
    die("No cart found for user.");
$stmt->close();

echo "<pre>DEBUG: cart_id = $cart_id</pre>";

// --- Step 6: Get all cart items and their prices
$stmt = $mysqli->prepare("
    SELECT ci.product_id, ci.quantity, p.price 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = ?
");
$stmt->bind_param('i', $cart_id);
if (!$stmt->execute())
    die("SQL error (cart_items): " . $stmt->error);
$res = $stmt->get_result();
$cart_items = [];
$calc_total = 0;
while ($row = $res->fetch_assoc()) {
    $cart_items[] = $row;
    $calc_total += $row['price'] * $row['quantity'];
}
$stmt->close();

echo "<pre>DEBUG: cart_items = " . print_r($cart_items, 1) . "</pre>";

if (empty($cart_items))
    die("No cart items found for this cart. Cannot create order.");

// --- Step 7: Create Order
$stmt = $mysqli->prepare("INSERT INTO orders (usercode, order_status, total_amount, created_at, updated_at) VALUES (?, 'paid', ?, NOW(), NOW())");
$stmt->bind_param('sd', $usercode, $amount);
if (!$stmt->execute())
    die("SQL error (insert orders): " . $stmt->error);
$order_id = $mysqli->insert_id;
$stmt->close();

echo "<pre>DEBUG: order_id = $order_id</pre>";
if (!$order_id)
    die("Order insert failed -- got no order_id!");

// --- Step 8: Insert Order Items
$stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
foreach ($cart_items as $ci) {
    $stmt->bind_param('iidi', $order_id, $ci['product_id'], $ci['price'], $ci['quantity']);
    if (!$stmt->execute()) {
        die("SQL error (order_items, product " . $ci['product_id'] . "): " . $stmt->error);
    }
}
$stmt->close();



$stmt = $mysqli->prepare("INSERT INTO payments (order_id, usercode, amount, payment_method, payment_status, transaction_id, paid_at) VALUES (?, ?, ?, 'paypal', 'success', ?, ?)");
$stmt->bind_param('isdss', $order_id, $usercode, $amount, $transactionId, $payment_time);
if (!$stmt->execute())
    die("SQL error (payments): " . $stmt->error);
$stmt->close();


// --- Step 10: Grant digital file access (order_files)
foreach ($cart_items as $ci) {
    $stmt = $mysqli->prepare("SELECT file_id FROM digital_files WHERE product_id = ?");
    $stmt->bind_param('i', $ci['product_id']);
    if (!$stmt->execute())
        die("SQL error (digital_files lookup): " . $stmt->error);
    $res = $stmt->get_result();
    while ($file = $res->fetch_assoc()) {
        $stmt2 = $mysqli->prepare("INSERT INTO order_files (order_id, product_id, file_id) VALUES (?, ?, ?)");
        $stmt2->bind_param('iii', $order_id, $ci['product_id'], $file['file_id']);
        if (!$stmt2->execute()) {
            die("SQL error (order_files, product " . $ci['product_id'] . " file " . $file['file_id'] . "): " . $stmt2->error);
        }
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
    $stmt = $mysqli->prepare("SELECT file_id FROM digital_files WHERE product_id = ?");
    $stmt->bind_param('i', $ci['product_id']);
    if (!$stmt->execute())
        die("SQL error (digital_files lookup): " . $stmt->error);
    $res = $stmt->get_result();

    while ($file = $res->fetch_assoc()) {
        // Insert into order_files and fetch its ID
        $stmt2 = $mysqli->prepare("INSERT INTO order_files (order_id, product_id, file_id) VALUES (?, ?, ?)");
        $stmt2->bind_param('iii', $order_id, $ci['product_id'], $file['file_id']);
        if (!$stmt2->execute()) {
            die("SQL error (order_files): " . $stmt2->error);
        }

        $order_file_id = $stmt2->insert_id; // Get the generated ID
        $stmt2->close();

        // Build download link with order_file_id
        $downloadLinks[] = $mail_url . "/user/ajax/download_files.php?order_file_id={$order_file_id}";
    }
    $mailer->sendPurchaseReceipt($payerEmail, $order_id, $cart_items, $amount, $downloadLinks);
    $stmt->close();
}




// --- Done!
echo "<h2>Thank you! Payment received.<br>
Order ID: $order_id<br>
You will be redirected shortly...</h2>";

echo "<script>
setTimeout(function(){
    window.location.href = '../index.php';
}, 2500); 
</script>";
?>