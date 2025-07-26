<?php
require_once 'db.php';
$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $mysqli->query("DELETE FROM product_categories WHERE product_id=$id");
    $mysqli->query("DELETE FROM product_images WHERE product_id=$id");
    $mysqli->query("DELETE FROM digital_files WHERE product_id=$id");
    $mysqli->query("DELETE FROM products WHERE product_id=$id");
    echo "Product deleted!";
} else {
    echo "Invalid product ID!";
}
?>