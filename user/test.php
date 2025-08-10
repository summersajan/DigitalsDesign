<?php
include_once '../config/db.php';

$email = $_SESSION['user_email'];

echo 'Email : ' . $email;

echo 'user_id : ' . $_SESSION['user_digital_product'] ?? 'null';


$code = $_SESSION['user_digital_product'] ?? 'null';




$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE usercode=?");

$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
echo json_encode(['name' => $name, 'email' => $email]);
?>