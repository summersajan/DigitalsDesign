<?php
require_once 'db.php';
$res = $mysqli->query("SELECT user_id, name, email, is_admin, created_at FROM users ORDER BY user_id DESC");
$users = [];
while ($u = $res->fetch_assoc())
    $users[] = $u;
header("Content-Type: application/json");
echo json_encode($users);
?>