<?php
// ajax/get_product.php
require_once 'db.php';
$id = intval($_GET['id']);
$q = $mysqli->query("SELECT * FROM products WHERE product_id=$id");
$product = $q->fetch_assoc();

$product['category_ids'] = [];
$res = $mysqli->query("SELECT category_id FROM product_categories WHERE product_id=$id");
while ($r = $res->fetch_assoc())
    $product['category_ids'][] = $r['category_id'];

// Get images
$product['product_images'] = [];
$res = $mysqli->query("SELECT image_id, image_url FROM product_images WHERE product_id=$id");
while ($r = $res->fetch_assoc())
    $product['product_images'][] = $r;

// Get digital files
$product['digital_files'] = [];
$res = $mysqli->query("SELECT file_id, file_url, file_type FROM digital_files WHERE product_id=$id");
while ($r = $res->fetch_assoc())
    $product['digital_files'][] = $r;

echo json_encode($product);
;
?>