<?php
include_once '../../config/db.php';
header("Content-Type: text/plain; charset=utf-8");

$product_id = (int) ($_POST['product_id'] ?? 0);
$rating = max(1, min(5, (int) $_POST['rating']));
$comment = trim($_POST['comment']);

if ($product_id && $comment && $usercode) {
    // 1. Insert review
    $stmt = $mysqli->prepare("INSERT INTO reviews (product_id, usercode, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isis", $product_id, $usercode, $rating, $comment);
    if (!$stmt->execute()) {
        echo "error inserting review";
        exit;
    }
    $stmt->close();

    // 2. Get average rating from reviews
    $stmt_avg = $mysqli->prepare("SELECT ROUND(AVG(rating), 1) AS avg_rating FROM reviews WHERE product_id = ?");
    $stmt_avg->bind_param("i", $product_id);
    $stmt_avg->execute();
    $stmt_avg->bind_result($avg_rating);
    $stmt_avg->fetch();
    $stmt_avg->close();

    // 3. If average rating exists, update product
    if (!is_null($avg_rating)) {
        $stmt_update = $mysqli->prepare("UPDATE products SET rating = ? WHERE product_id = ?");
        $stmt_update->bind_param("di", $avg_rating, $product_id);
        if (!$stmt_update->execute()) {
            echo "error updating rating";
            exit;
        }
        $stmt_update->close();
    }

    echo "success";
} else {
    echo "error: missing input";
}
?>