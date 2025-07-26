<?php
require_once 'db.php';
$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $mysqli->query("DELETE FROM users WHERE user_id=$id");
    echo "User deleted!";
} else
    echo "Invalid user ID!";
?>