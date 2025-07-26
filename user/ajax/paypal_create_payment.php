<?php
include 'paypal_config.php';

if (!isset($_POST['amount']) || empty($_POST['amount'])) {
    echo json_encode(["status" => "error", "message" => "Error"]);
    exit;
}

$amount = $_POST['amount']; // Get the dynamic amount





$accessToken = getAccessToken();
if (!$accessToken) {
    echo json_encode(["status" => "error", "message" => "Failed to get access token"]);
    exit;
}

$paymentData = [
    "intent" => "sale",
    "payer" => ["payment_method" => "paypal"],
    "transactions" => [
        [
            "amount" => [
                "total" => $amount,
                "currency" => "USD"
            ],
            "description" => "Plan Purchase - $" . $amount
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
            echo json_encode(["status" => "success", "redirect_url" => $link->href]);
            exit;
        }
    }
}

echo json_encode(["status" => "error", "message" => "Could not create PayPal payment"]);
?>