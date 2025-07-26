<?php
include '../../config/db.php';
require 'Mailer.php'; // Adjust path as needed

header('Content-Type: application/json');

$testEmail = 'amazingpuzzle70@gmail.com';
$token = bin2hex(random_bytes(32)); // Dummy token
$verifyUrl = $mail_url . '/verify_email.php?token=' . urlencode($token);

$mailer = new Mailer();
$result = $mailer->sendLinkEmail($testEmail, 'verification', $verifyUrl);

if ($result === 1) {
    echo json_encode([
        'status' => 1,
        'message' => 'Test verification email sent successfully to ' . $testEmail
    ]);
} else {
    echo json_encode([
        'status' => 0,
        'message' => 'Failed to send test email. Check SMTP config, credentials, or PHPMailer errors.'
    ]);
}
