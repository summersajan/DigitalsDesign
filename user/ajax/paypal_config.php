<?php
include_once '../config/db.php';



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

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => 'cURL Error: ' . $error_msg
        ];
    }

    curl_close($ch);

    $response = json_decode($result);

    if ($httpCode !== 200 || isset($response->error)) {
        return [
            'success' => false,
            'http_code' => $httpCode,
            'error' => $response->error_description ?? $response->error ?? 'Unknown error',
            'response' => $response
        ];
    }

    return [
        'success' => true,
        'access_token' => $response->access_token
    ];
}

?>