<?php

require_once '../config/db.php';
header('Content-Type: application/json'); // Important for correct response



$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Prepared statement to avoid SQL injection
$stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM wishlist_items WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode(['count' => (int) $data['count']]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed']);
}

$stmt->close();
?>