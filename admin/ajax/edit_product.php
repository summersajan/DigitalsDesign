<?php
require_once 'db.php';

$product_id = intval($_POST['product_id']);
$title = trim($_POST['title'] ?? "");
$desc = trim($_POST['description'] ?? "");
$price = floatval($_POST['price'] ?? 0);
$category_ids = $_POST['category_ids'] ?? [];

if ($product_id > 0 && $title && $price > 0 && count($category_ids) > 0) {
    // Update product main table (without old_price/discount)
    $stmt = $mysqli->prepare("UPDATE products SET title=?, description=?, price=? WHERE product_id=?");
    $stmt->bind_param("ssdi", $title, $desc, $price, $product_id);
    if ($stmt->execute()) {

        // Update product_categories: delete all, then add new
        $mysqli->query("DELETE FROM product_categories WHERE product_id=$product_id");
        foreach ($category_ids as $catid) {
            $mysqli->query("INSERT INTO product_categories (product_id, category_id) VALUES ($product_id, " . intval($catid) . ")");
        }

        // --- ADD NEWLY UPLOADED IMAGES ---
        if (!empty($_FILES['product_image']['name'][0])) {
            foreach ($_FILES['product_image']['tmp_name'] as $i => $tmpName) {
                if (!is_uploaded_file($tmpName) || empty($_FILES['product_image']['name'][$i]))
                    continue;
                $ext = strtolower(pathinfo($_FILES['product_image']['name'][$i], PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
                if (!in_array($ext, $allowed_ext))
                    continue;
                $uniqueName = 'uploads/' . uniqid('img_', true) . '.' . $ext;
                if (move_uploaded_file($tmpName, $uniqueName)) {
                    // You could set is_main by UI, here we keep all as "not main"
                    $mysqli->query("INSERT INTO product_images (product_id, image_url, is_main) VALUES ($product_id, '" . $mysqli->real_escape_string($uniqueName) . "', 0)");
                }
            }
        }

        // --- ADD NEWLY UPLOADED DIGITAL FILES ---
        if (!empty($_FILES['digital_file']['name'][0])) {
            foreach ($_FILES['digital_file']['tmp_name'] as $i => $tmpName) {
                if (!is_uploaded_file($tmpName) || empty($_FILES['digital_file']['name'][$i]))
                    continue;
                $ext = strtolower(pathinfo($_FILES['digital_file']['name'][$i], PATHINFO_EXTENSION));
                $allowed_ext = ['zip', 'jpg', 'jpeg', 'png', 'svg', 'ai', 'psd', 'eps', 'webp'];
                if (!in_array($ext, $allowed_ext))
                    continue;
                $uniqueName = 'uploads/digital_' . uniqid('', true) . '.' . $ext;
                if (move_uploaded_file($tmpName, $uniqueName)) {
                    $mysqli->query(
                        "INSERT INTO digital_files (product_id, file_url, file_type) VALUES ($product_id, '" .
                        $mysqli->real_escape_string($uniqueName) . "', '$ext')"
                    );
                }
            }
        }

        // To implement full "remove image/file" for editing:
        // - Add "delete" buttons and endpoint for each file/image and handle on demand.

        echo "Product updated!";
    } else {
        echo "Error updating product.";
    }
} else {
    echo "Fill all required fields.";
}
?>