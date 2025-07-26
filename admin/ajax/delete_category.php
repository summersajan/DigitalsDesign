<?php
require_once 'db.php';
header('Content-Type: application/json');
$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    // Optional: consider what to do with children/categories/products first!
    $mysqli->query("DELETE FROM categories WHERE category_id=$id");
    $mysqli->query("DELETE FROM product_categories WHERE category_id=$id");

    echo json_encode(['success' => true, 'message' => 'Category deleted']);
} else {

    echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
}
?>