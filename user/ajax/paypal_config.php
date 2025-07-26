<?php
define('PAYPAL_CLIENT_ID', 'ASZISxafDlkgZUov1Pz1DlHJnqhQFWO3X8lgHrczKUUk5jwt8iFNUsx2WpGqUgn1kQjL9F2CBYJqUv-P');
define('PAYPAL_SECRET', 'EHGNZY4Ir3dS7VwqdgCIvrCyToWUy9vSD2mSjOP7KkD9xda5sTOVMso4dtMcgm9nlZUSFQK4-qbR93Jv');
define('PAYPAL_BASE_URL', 'https://api-m.sandbox.paypal.com/'); // Change to live URL when going live

define('MAIN_URL', 'http://localhost/digitalProduct/user/ajax/');
function getAccessToken()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, PAYPAL_BASE_URL . "v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Accept-Language: en_US"
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch));
    curl_close($ch);
    return $response->access_token ?? null;
}
?>