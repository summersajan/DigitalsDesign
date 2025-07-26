<?php
require_once 'db.php';
$id = intval($_GET['id'] ?? 0);
$res = $mysqli->query("SELECT user_id, name, email, is_admin FROM users WHERE user_id=$id");
echo json_encode($res->fetch_assoc());
?>