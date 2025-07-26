<?php
require_once 'db.php';

header('Content-Type: text/plain'); // Helps with debugging

$name = trim($_POST['name'] ?? "");
$email = trim($_POST['email'] ?? "");
$password = trim($_POST['password'] ?? "");
$is_admin = intval($_POST['is_admin'] ?? 0);

if ($name && $email && $password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $usercode = generate_uuid_v4();
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash, is_admin,is_verified,usercode) VALUES (?, ?, ?, ?,'1',?)");
    if (!$stmt) {
        echo "Prepare failed: " . $mysqli->error;
        exit;
    }
    $stmt->bind_param("sssis", $name, $email, $hash, $is_admin, $usercode);
    if ($stmt->execute()) {
        echo "User added!";
    } else {
        echo "Execute failed: " . $stmt->error;
    }
} else {
    echo "All fields required!";
}
function generate_uuid_v4()
{
    // RFC 4122-compliant v4
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff), // 32 bits
        mt_rand(0, 0xffff), // 16 bits
        mt_rand(0, 0x0fff) | 0x4000, // version 4 (16 bits)
        mt_rand(0, 0x3fff) | 0x8000, // variant 10xx (16 bits)
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff) // 48 bits
    );
}
?>