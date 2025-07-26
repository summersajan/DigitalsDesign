<?php
require_once 'db.php';

$q = "SELECT p.product_id, p.title, p.price, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as categories 
    FROM products p
    LEFT JOIN product_categories pc ON p.product_id = pc.product_id
    LEFT JOIN categories c ON pc.category_id = c.category_id
    GROUP BY p.product_id
    ORDER BY p.product_id DESC";
$result = $mysqli->query($q);
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['created_at'] = date('Y-m-d', strtotime($row['created_at']));
    $data[] = $row;
}
header("Content-Type: application/json");
echo json_encode($data);
?>