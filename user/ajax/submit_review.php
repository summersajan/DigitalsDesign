<?php
include_once '../../config/db.php';
header("Content-Type: text/plain; charset=utf-8");

$product_id = (int) ($_POST['product_id'] ?? 0);
$rating = max(1, min(5, (int) $_POST['rating']));
$comment = trim($_POST['comment']);

if ($product_id && $comment) {
    $stmt = $mysqli->prepare("INSERT INTO reviews (product_id, usercode, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $product_id, $usercode, $rating, $comment);
    $stmt->execute();
    $stmt->close();
    echo "success";
} else {
    echo "error";
}
