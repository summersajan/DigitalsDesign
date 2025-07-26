<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['login' => true]);
    exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$product_id = (int) ($_POST['product_id'] ?? 0);

if (!$product_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid product']);
    exit;
}

// Get price for this product
$stmt = $mysqli->prepare("SELECT price FROM products WHERE product_id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($price);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Product not found']);
    $stmt->close();
    exit;
}
$stmt->close();

$mysqli->begin_transaction();

try {
    // Insert into orders
    $ord = $mysqli->prepare("INSERT INTO orders (user_id, order_status, total_amount, created_at, updated_at)
                             VALUES (?, 'completed', ?, NOW(), NOW())");
    $ord->bind_param("id", $user_id, $price);
    $ord->execute();
    $order_id = $ord->insert_id;
    $ord->close();

    // Insert into order_items
    $oitem = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price, quantity)
                               VALUES (?, ?, ?, 1)");
    $oitem->bind_param("iid", $order_id, $product_id, $price);
    $oitem->execute();
    $oitem->close();

    // --- INSERT order_files ENTRIES (fixed) ---
    $fileq = $mysqli->prepare("SELECT file_id FROM digital_files WHERE product_id=?");
    $fileq->bind_param("i", $product_id);
    $fileq->execute();
    $fileq->bind_result($file_id);
    $file_ids = [];
    while ($fileq->fetch()) {
        $file_ids[] = $file_id;
    }
    $fileq->close();

    if ($file_ids) {
        $orderfiles = $mysqli->prepare("INSERT INTO order_files (order_id, product_id, file_id, downloaded, download_count, last_downloaded)
                                             VALUES (?, ?, ?, 0, 0, NULL)");
        foreach ($file_ids as $fid) {
            $orderfiles->bind_param("iii", $order_id, $product_id, $fid);
            $orderfiles->execute();
        }
        $orderfiles->close();
    }

    // Remove from cart if present
    $cartq = $mysqli->prepare("SELECT cart_id FROM carts WHERE user_id=?");
    $cartq->bind_param("i", $user_id);
    $cartq->execute();
    $cartq->store_result();
    $cartq->bind_result($cart_id);
    if ($cartq->fetch()) {
        $del_cart = $mysqli->prepare("DELETE FROM cart_items WHERE cart_id=? AND product_id=?");
        $del_cart->bind_param("ii", $cart_id, $product_id);
        $del_cart->execute();
        $del_cart->close();
    }
    $cartq->close();

    // Remove from wishlist if present
    $wishq = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE user_id=?");
    $wishq->bind_param("i", $user_id);
    $wishq->execute();
    $wishq->store_result();
    $wishq->bind_result($wishlist_id);
    if ($wishq->fetch()) {
        $del_wish = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_id=? AND product_id=?");
        $del_wish->bind_param("ii", $wishlist_id, $product_id);
        $del_wish->execute();
        $del_wish->close();
    }
    $wishq->close();

    $mysqli->commit();

    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $mysqli->rollback();
    error_log('Buy Now Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}