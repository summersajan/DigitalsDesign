<?php
include '../../config/db.php';
require_once 'Mailer.php';





$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    exit;
}




// Check if user exists and verification status
$stmt = $mysqli->prepare("SELECT user_id, login_attempts, is_verified FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    $stmt->close();
    exit;
}

$stmt->bind_result($userId, $attempts, $isVerified);
$stmt->fetch();
$stmt->close();

// Check if account is already verified
if ($isVerified) {
    echo json_encode(['status' => 'error', 'message' => 'Account is already verified.']);
    exit;
}

// Check if account is locked (too many attempts)
if ($attempts >= 4) {
    echo json_encode(['status' => 'error', 'message' => 'Account locked. Too many verification attempts.']);
    exit;
}

// Generate new token
$token = bin2hex(random_bytes(32));

// Update verification attempts
$attempts++;
$update = $mysqli->prepare("UPDATE users SET verification_token = ?,  login_attempts = ? WHERE user_id = ?");
$update->bind_param("sss", $token, $attempts, $userId);

if (!$update->execute() || $update->affected_rows <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update verification data.']);
    $update->close();
    exit;
}
$update->close();



$resetLink = $mail_url . 'user/auth/verify_token.php?token=' . urlencode($token);


require_once 'Mailer.php'; // Adjust the path as necessary



$mailer = new Mailer();
$mailResult = $mailer->sendLinkEmail($email, 'verification', $resetLink);
$response['status'] = 1;
if ($mailResult === 1) {
    echo json_encode(['status' => 1, 'message' => 'Email sent successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
}
?>