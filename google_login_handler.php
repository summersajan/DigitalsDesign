<?php
require_once 'vendor/autoload.php'; // Google SDK via Composer
include 'config/db.php';

header('Content-Type: application/json; charset=utf-8');

function generate_uuid_v4()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

$payload = $_POST['credential'] ?? null;

if (!$payload) {
    echo json_encode(['success' => false, 'error' => 'Missing credential']);
    exit;
}

$client = new Google_Client(['client_id' => $google_client_id]); // Set your client ID
$ticket = $client->verifyIdToken($payload);

if ($ticket) {
    $email = $ticket['email'];
    $name = $ticket['name'] ?? '';

    // Check if user already exists
    $stmt = $mysqli->prepare("SELECT user_id, usercode FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $usercode);
        $stmt->fetch();
    } else {
        $stmt->close();
        $password_hash = '';
        $verification_token = '';
        $is_verified = 1;
        $usercode = generate_uuid_v4();

        $stmt_insert = $mysqli->prepare("INSERT INTO users (name, email, password_hash, verification_token, is_verified, usercode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("ssssis", $name, $email, $password_hash, $verification_token, $is_verified, $usercode);

        if (!$stmt_insert->execute()) {
            echo json_encode(['success' => false, 'error' => 'Registration failed.']);
            exit;
        }
        $stmt_insert->close();
    }

    $_SESSION['user_digital_product'] = $usercode;
    $_SESSION['user_email'] = $email;
    $redirectUrl = $_SESSION['return_url'] ?? 'index.php';
    unset($_SESSION['return_url']); // clear after use
    echo json_encode(['success' => true, 'message' => 'Login successful', 'redirect' => $redirectUrl]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid token']);
}
?>