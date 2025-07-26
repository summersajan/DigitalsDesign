<?php
include 'config/db.php';


echo json_encode([
    'client_id' => $google_client_id,
    'api_key' => $google_auth_api_key
]);
