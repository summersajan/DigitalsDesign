<?php
require_once 'db.php';
$id = intval($_POST['user_id'] ?? 0);
$name = trim($_POST['name'] ?? "");
$email = trim($_POST['email'] ?? "");
$password = trim($_POST['password'] ?? "");
$is_admin = intval($_POST['is_admin'] ?? 0);

if ($id > 0 && $name && $email) {
    if ($password != "") {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare("UPDATE users SET name=?, email=?, password_hash=?, is_admin=? WHERE user_id=?");
        $stmt->bind_param("sssii", $name, $email, $hash, $is_admin, $id);
    } else {
        $stmt = $mysqli->prepare("UPDATE users SET name=?, email=?, is_admin=? WHERE user_id=?");
        $stmt->bind_param("ssii", $name, $email, $is_admin, $id);
    }
    if ($stmt->execute()) {
        echo "User updated!";
    } else {
        echo "Error: Email might already exist!";
    }
} else {
    echo "All fields required!";
}
?>