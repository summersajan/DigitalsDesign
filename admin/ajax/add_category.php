<?php
require_once 'db.php';
header('Content-Type: application/json');
if (!isset($_POST['cat_name']) || !isset($_POST['parent_id'])) {

    echo json_encode(['success' => false, 'message' => 'Invalid request!']);
    exit;
}
$name = trim($_POST['cat_name']);
$parent = empty($_POST['parent_id']) ? null : intval($_POST['parent_id']);
if ($name != "") {
    $stmt = $mysqli->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $parent);
    if ($stmt->execute())
        echo json_encode(['success' => true, 'message' => 'Category added!']);
    else
        echo json_encode(['success' => false, 'message' => 'Error!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Category name required!']);
}