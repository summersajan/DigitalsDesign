<?php
require_once 'db.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT category_id, name, parent_id FROM categories WHERE category_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
header("Content-Type: application/json");
echo json_encode($row);
?>