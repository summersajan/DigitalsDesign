<?php

include '../../config/db.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Invalid verification token");
}

// Check token validity and fetch user_id and usercode
$stmt = $mysqli->prepare("SELECT user_id, usercode FROM users WHERE verification_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Invalid verification token");
}

$stmt->bind_result($userId, $usercode);
$stmt->fetch();
$stmt->close();

// Mark as verified
$update = $mysqli->prepare("UPDATE users SET is_verified = 1, verification_token = 0, login_attempts = 0 WHERE user_id = ?");
$update->bind_param("i", $userId);

if ($update->execute() && $update->affected_rows > 0) {
    // Store usercode in session

    $_SESSION['digital_usercode'] = $usercode;
    // Redirect to dashboard
    header("Location: ../index.php");
} else {
    die("Failed to verify account");
}

$update->close();
exit;
?>