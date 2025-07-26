<?php
header('Content-Type: application/json');
include '../../config/db.php';


$token = $_POST['token'] ?? '';
$newPassword = $_POST['password'] ?? ''; // Fix this line

if (empty($token) || empty($newPassword)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing token or new password.']);
    exit;
}


if (empty($token) || empty($newPassword)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing token or new password.']);
    exit;
}

try {
    $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE verification_token = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed (SELECT): " . $mysqli->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token.']);
        $stmt->close();
        exit;
    }

    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = $mysqli->prepare("UPDATE users SET password_hash = ?, verification_token = '', login_attempts = 0 WHERE user_id = ?");
    if (!$update) {
        throw new Exception("Prepare failed (UPDATE): " . $mysqli->error);
    }

    $update->bind_param("si", $hashedPassword, $userId);

    if ($update->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password reset successful.']);
    } else {
        throw new Exception("Execute failed (UPDATE): " . $update->error);
    }

    $update->close();
    $mysqli->close();

} catch (Exception $e) {
    // Show the exact error in JSON response (visible in browser/console)
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
