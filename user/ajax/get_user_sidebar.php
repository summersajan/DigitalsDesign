<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line

$usercode = $_SESSION['user_digital_product'] ?? null;
$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE usercode=?");
$stmt->bind_param("i", $usercode);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
echo json_encode(['name' => $name, 'email' => $email]);