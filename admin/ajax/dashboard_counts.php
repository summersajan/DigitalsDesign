<?php
require_once 'db.php';
$out = [];
$out['users'] = $mysqli->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$out['products'] = $mysqli->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
$out['orders'] = $mysqli->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
header('Content-Type: application/json');
echo json_encode($out);
?>