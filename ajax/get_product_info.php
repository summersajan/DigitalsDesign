<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Product main info
$stmt = $mysqli->prepare(
    "SELECT * FROM products WHERE product_id = ?"
);

$stmt->bind_param('i', $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

// Images
$res = $mysqli->prepare("SELECT image_url FROM product_images WHERE product_id = ? ORDER BY is_main DESC, image_id");
$res->bind_param('i', $product_id);
$res->execute();
$images = [];
$imgres = $res->get_result();
while ($row = $imgres->fetch_assoc()) {
    $images[] = $row['image_url'];
}

// Categories
$res = $mysqli->prepare("SELECT c.name FROM categories c INNER JOIN product_categories pc ON c.category_id = pc.category_id WHERE pc.product_id = ?");
$res->bind_param('i', $product_id);
$res->execute();
$cats = [];
$catres = $res->get_result();
while ($row = $catres->fetch_assoc())
    $cats[] = $row['name'];

// Digital files / types / vector / dimensions
$res = $mysqli->prepare("SELECT file_type FROM digital_files WHERE product_id = ?");
$res->bind_param('i', $product_id);
$res->execute();
$types = [];
$fileres = $res->get_result();
while ($row = $fileres->fetch_assoc())
    $types[] = strtoupper($row['file_type']);
$types = array_unique($types);

$vector = (in_array('AI', $types) || in_array('SVG', $types) || in_array('EPS', $types)) ? 'Yes' : 'No';

// (You may want to store/retrieve dimensions. Here, fallback to a constant. Adapt as you wish!)
$dimensions = $product['dimensions'] ?? '5000 x 5000';

// Returns JSON
echo json_encode([
    'product_id' => $product['product_id'],
    'title' => $product['title'],
    'description' => $product['description'],
    'price' => $product['price'],
    'old_price' => $product['old_price'],
    'discount' => $product['discount'],
    'categories' => $cats,
    'images' => $images,
    'vector' => $vector,
    'dimensions' => $dimensions,
    'filetypes' => $types,
    'rating' => $product['rating'] ?? 5.0,
    'bookmarked' => 2,
    'addional_info' => $product['additional_info'] ?? 'NA',
]);
?>