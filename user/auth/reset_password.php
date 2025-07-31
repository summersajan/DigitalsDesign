<?php
include '../../config/db.php';
require_once 'Mailer.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
    exit;
}

// Check if user exists
$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'No user found with this email.']);
    $stmt->close();
    exit;
}

$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

// Generate secure token
$token = bin2hex(random_bytes(32));

// Store token in DB
$update = $mysqli->prepare("UPDATE users SET verification_token = ? WHERE user_id = ?");
$update->bind_param("si", $token, $userId);
$update->execute();
$update->close();

// Send email
$resetUrl = $mail_url . '/user/auth/reset_password_handler.php?token=' . urlencode($token);

$mailer = new Mailer();
$sent = $mailer->sendLinkEmail($email, 'reset', $resetUrl);

if ($sent === 1) {
    echo json_encode(['status' => 1, 'message' => 'Password reset link sent to your email.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send reset email.']);
}
?>