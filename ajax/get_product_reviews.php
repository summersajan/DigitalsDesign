<?php
require_once '../config/db.php';

header('Content-Type: application/json');
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$res = $mysqli->prepare("
  SELECT r.*, u.name
  FROM reviews r
  LEFT JOIN users u ON r.usercode = u.usercode
  WHERE r.product_id = ?
  ORDER BY r.created_at DESC
");
$res->bind_param('i', $product_id);
$res->execute();
$result = $res->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
  $reviews[] = [
    'user' => $row['name'] ?: 'User',
    'date' => date('F j, Y', strtotime($row['created_at'])),
    'rating' => (int) $row['rating'],
    'content' => $row['comment']
  ];
}

echo json_encode($reviews);
?>