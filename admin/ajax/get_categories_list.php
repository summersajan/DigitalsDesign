<?php
require_once 'db.php';

$result = $mysqli->query("SELECT c.category_id, c.name, c.parent_id, p.name AS parent_name
    FROM categories c
    LEFT JOIN categories p ON c.parent_id = p.category_id
    ORDER BY c.category_id DESC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
header("Content-Type: application/json");
echo json_encode($data);
?>