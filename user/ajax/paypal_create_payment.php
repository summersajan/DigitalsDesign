<?php
include_once '../../config/db.php';
include_once 'paypal_config.php';


function getAccessToken($paypal_base_url, $paypal_client_id, $paypal_secret)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $paypal_base_url . "v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Accept-Language: en_US"
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $paypal_client_id . ":" . $paypal_secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch));
    curl_close($ch);
    return $response->access_token ?? null;
}



if (!isset($_POST['amount']) || empty($_POST['amount'])) {
    echo json_encode(["status" => "error", "message" => "Error"]);
    exit;
}

$amount = $_POST['amount']; // Get the dynamic amount

$accessToken = getAccessToken($paypal_base_url, $paypal_client_id, $paypal_secret);




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