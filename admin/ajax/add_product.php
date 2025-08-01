<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

function json_error($msg)
{
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

function json_success($msg, $data = [])
{
    echo json_encode(array_merge(['success' => true, 'message' => $msg], $data));
    exit;
}

function ensure_dir($dir)
{
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0777, true)) {
            json_error("Failed to create folder: $dir");
        }
    }
}

// Validate inputs
$title = trim($_POST['title'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$desc = trim($_POST['description'] ?? '');
$additional_info = trim($_POST['additional_info'] ?? 'NA');
$category_ids = $_POST['category_ids'] ?? [];
$featured = isset($_POST['featured']) ? 1 : 0; // New

if ($title === '' || strlen($title) > 190)
    json_error('Invalid product title.');
if ($price <= 0)
    json_error('Price must be greater than 0.');
if (!is_array($category_ids) || !count($category_ids))
    json_error('At least one category required.');
if (strlen(strip_tags($desc)) === 0)
    json_error('Description required.');


// Directory paths
$img_base_dir = __DIR__ . '/../../uploads/';
$file_base_dir = __DIR__ . '/../../digitals/';
$img_base_url = '../../uploads/';
$file_base_url = '../../digitals/';


// Ensure folders exist
ensure_dir($img_base_dir);
ensure_dir($file_base_dir);

// Allowed file settings (adjust as needed)
$imgAllowedExt = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
$imgMaxFiles = 6;
$imgMaxSize = 5 * 1024 * 1024;

$fileAllowedExt = ['jpg', 'jpeg', 'png', 'svg', 'ai', 'psd', 'eps', 'webp', 'zip'];
$fileMaxFiles = 6;
$fileMaxSize = 15 * 1024 * 1024;

// Get uploaded files
$product_images = $_FILES['product_image'] ?? null;
$digital_files = $_FILES['digital_file'] ?? null;

$has_images = ($product_images && !empty($product_images['name'][0]));
$has_files = ($digital_files && !empty($digital_files['name'][0]));

// Require at least one file for product creation
if (!$has_images && !$has_files) {
    json_error("Please upload at least one image or one digital file.");
}



// Insert product into database (add featured here)
$stmt = $mysqli->prepare("INSERT INTO products (title, description, additional_info, price, featured) VALUES (?, ?, ?, ?, ?)");
if (!$stmt)
    json_error("Product insert prepare failed: " . $mysqli->error);
if (!$stmt->bind_param("sssdi", $title, $desc, $additional_info, $price, $featured))
    json_error("Product insert bind failed: " . $stmt->error);
if (!$stmt->execute())
    json_error("Error creating product: " . $stmt->error);

$product_id = $mysqli->insert_id;

// Insert product categories
foreach ($category_ids as $catid) {
    $stmt2 = $mysqli->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
    if (!$stmt2)
        continue;
    $stmt2->bind_param("ii", $product_id, $catid);
    $stmt2->execute();
}

// Upload product images
if ($has_images) {
    $n = count($product_images['name']);
    for ($i = 0; $i < $n; $i++) {
        $name = $product_images['name'][$i];
        $tmp = $product_images['tmp_name'][$i];
        $size = $product_images['size'][$i] ?? 0;
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, $imgAllowedExt))
            json_error("Image file extension not allowed: $name");
        if ($size > $imgMaxSize)
            json_error("Image file too large: $name");
        if (!is_uploaded_file($tmp))
            json_error("Invalid uploaded image file: $name");

        $uniqueName = 'img_' . uniqid() . '.' . $ext;
        $fullPath = $img_base_dir . $uniqueName;
        $url = $img_base_url . $uniqueName;

        $img_path = 'uploads/' . $uniqueName;

        if (!move_uploaded_file($tmp, $fullPath))
            json_error("Failed to move uploaded image: $name");

        $is_main = ($i == 0 ? 1 : 0);
        $stmt = $mysqli->prepare("INSERT INTO product_images (product_id, image_url, is_main) VALUES (?, ?, ?)");
        if (!$stmt)
            json_error("Image insert prepare failed: " . $mysqli->error);
        if (!$stmt->bind_param("isi", $product_id, $img_path, $is_main))
            json_error("Image insert bind failed: " . $stmt->error);
        if (!$stmt->execute())
            json_error("Failed to insert image: $name. Error: " . $stmt->error);
    }
}

// Upload digital files
if ($has_files) {
    $n = count($digital_files['name']);
    for ($i = 0; $i < $n; $i++) {
        $name = $digital_files['name'][$i];
        $tmp = $digital_files['tmp_name'][$i];
        $size = $digital_files['size'][$i] ?? 0;
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, $fileAllowedExt))
            json_error("Digital file extension not allowed: $name");
        if ($size > $fileMaxSize)
            json_error("Digital file too large: $name");
        if (!is_uploaded_file($tmp))
            json_error("Invalid uploaded digital file: $name");

        $uniqueName = 'digital_' . uniqid() . '.' . $ext;
        $fullPath = $file_base_dir . $uniqueName;
        $url = $file_base_url . $uniqueName;

        $digi_path = 'digitals/' . $uniqueName;

        if (!move_uploaded_file($tmp, $fullPath))
            json_error("Failed to move uploaded digital file: $name");

        $stmt = $mysqli->prepare("INSERT INTO digital_files (product_id, file_url, file_type) VALUES (?, ?, ?)");
        if (!$stmt)
            json_error("Digital insert prepare failed: " . $mysqli->error);
        if (!$stmt->bind_param("iss", $product_id, $digi_path, $ext))
            json_error("Digital insert bind failed: " . $stmt->error);
        if (!$stmt->execute())
            json_error("Failed to insert digital file: $name. Error: " . $stmt->error);
    }
}

json_success("Product uploaded successfully!", ['product_id' => $product_id]);