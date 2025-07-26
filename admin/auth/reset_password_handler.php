<?php
include '../../config/db.php';

/*$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'] ?? '';
$newPassword = $data['new_password'] ?? '';*/
$token = '213343';
$newPassword = '123456';

if (empty($token) || empty($newPassword)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing token or password.']);
    exit;
}

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE verification_token = ?");
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
$update = $mysqli->prepare("UPDATE users SET password = ?, verification_token = 0, login_attempts = 0 WHERE user_id = ?");
$update->bind_param("si", $hashedPassword, $userId);

if ($update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Password reset successful.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to reset password.']);
}
$update->close();
$mysqli->close();
?>