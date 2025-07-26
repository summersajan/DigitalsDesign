<?php
require_once 'db.php';
header('Content-Type: application/json');

$id = intval($_POST['cat_id'] ?? 0);
$name = trim($_POST['cat_name'] ?? "");
$parent = ($_POST['parent_id'] === "" ? null : intval($_POST['parent_id']));

if ($id <= 0 || $name === "") {
    echo json_encode(['success' => false, 'message' => 'Invalid category ID or name.']);
    exit;
}

// Prevent self as parent
if ($parent === $id) {
    echo json_encode(['success' => false, 'message' => 'Category cannot be its own parent.']);
    exit;
}

// Check if the same name exists under the same parent (excluding current)
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM categories WHERE name = ? AND parent_id <=> ? AND category_id != ?");
$stmt->bind_param("sii", $name, $parent, $id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'Category name already exists under the selected parent.']);
    exit;
}

// Proceed with update
$stmt = $mysqli->prepare("UPDATE categories SET name = ?, parent_id = ? WHERE category_id = ?");
$stmt->bind_param("sii", $name, $parent, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update category.']);
}
?>