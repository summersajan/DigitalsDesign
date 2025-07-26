<?php
require_once 'db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type:text/html; charset=utf-8');

$res = $mysqli->query("SELECT * FROM categories ORDER BY name");

if (!$res) {
    die('Query Error: ' . $mysqli->error);
}

while ($row = $res->fetch_assoc()) {
    echo '<option value="' . htmlspecialchars($row['category_id']) . '">' . htmlspecialchars($row['name']) . '</option>';
}
?>