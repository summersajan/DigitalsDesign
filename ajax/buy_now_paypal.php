<?php
require_once '../config/db.php';
header('Content-Type: application/json');
include '../user/ajax/paypal_config.php';

if (!$usercode) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
$quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

if (!is_array($product_ids) || !is_array($quantities) || count($product_ids) !== count($quantities) || empty($product_ids)) {
    echo json_encode(['success' => false, 'error' => 'Invalid cart']);
    exit;
}

$total = 0.0;
$items = [];

// prepare statement for getting product info
$stmt = $mysqli->prepare("SELECT title, price FROM products WHERE product_id=?");

for ($i = 0; $i < count($product_ids); $i++) {
    $pid = (int) $product_ids[$i];
    $qty = (int) $quantities[$i];
    if ($pid < 1 || $qty < 1)
        continue;
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->bind_result($title, $price);
    if ($stmt->fetch()) {
        $item_total = $price * $qty;
        $total += $item_total;
        $items[] = [
            "name" => $title,
            "sku" => (string) $pid,
            "price" => number_format($price, 2, '.', ''),
            "currency" => "USD",
            "quantity" => $qty
        ];
    }
}
$stmt->close();

if ($total <= 0 || empty($items)) {
    echo json_encode(['success' => false, 'error' => 'Nothing to checkout']);
    exit;
}

$accessToken = getAccessToken();
if (!$accessToken) {
    echo json_encode(["status" => "error", "message" => "Failed to get access token"]);
    exit;
}

// use a PayPal payment structure that supports several items (item_list)
$paymentData = [
    "intent" => "sale",
    "payer" => ["payment_method" => "paypal"],
    "transactions" => [
        [
            "amount" => [
                "total" => number_format($total, 2, '.', ''),
                "currency" => "USD"
            ],
            "item_list" => [
                "items" => $items
            ],
            "description" => "Cart Purchase - $" . number_format($total, 2, '.', '')
        ]
    ],
    "redirect_urls" => [
        "return_url" => MAIN_URL . "paypal_success.php",
        "cancel_url" => MAIN_URL . "paypal_cancel.php"
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, PAYPAL_BASE_URL . "v1/payments/payment");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = json_decode(curl_exec($ch));
curl_close($ch);

if (isset($response->links)) {
    foreach ($response->links as $link) {
        if ($link->rel === "approval_url") {
            echo json_encode(["status" => "success", "approveUrl" => $link->href]);
            exit;
        }
    }
}

echo json_encode(["status" => "error", "message" => "Could not create PayPal payment"]);
?>