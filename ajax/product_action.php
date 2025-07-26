<?php
require_once '../config/db.php';

$action = $_POST['action'] ?? '';

if (!$usercode) {
    $currentUrl = $_POST['url'] ?? $_SERVER['HTTP_REFERER'] ?? 'cart.php';

    echo json_encode([
        'success' => false,
        'message' => 'logged in first',
        'return_url' => $currentUrl
    ]);
    exit;
}
/*
if ($action === 'add_to_cart') {
    $product_id = intval($_POST['product_id']);
    $quantity = 1;

    // Find or create cart
    $stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ?");
    $stmt->bind_param("s", $usercode);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $cart_id = $row['cart_id'];
    } else {
        $stmt = $mysqli->prepare("INSERT INTO carts (usercode, created_at, updated_at) VALUES (?, NOW(), NOW())");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $cart_id = $mysqli->insert_id;
    }

    // Check if product already in cart
    $stmt = $mysqli->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->fetch_assoc()) {
        echo json_encode(['success' => true, 'message' => 'Product is already in cart']);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Added to cart']);
    }
    exit;
}*/
if ($action === 'add_to_cart') {
    $product_id = intval($_POST['product_id']);
    $quantity = 1;

    // Find or create cart
    $stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ?");
    $stmt->bind_param("s", $usercode);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $cart_id = $row['cart_id'];
    } else {
        $stmt = $mysqli->prepare("INSERT INTO carts (usercode, created_at, updated_at) VALUES (?, NOW(), NOW())");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $cart_id = $mysqli->insert_id;
    }

    // Check if product already in cart
    $stmt = $mysqli->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->fetch_assoc()) {
        echo json_encode(['success' => true, 'message' => 'Product is already in cart']);
    } else {
        // Add product to cart
        $stmt = $mysqli->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
        $stmt->execute();

        // Remove product from wishlist (if exists)
        $stmt = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE usercode = ?");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $wishlist_id = $row['wishlist_id'];

            $stmt = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $wishlist_id, $product_id);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Added to cart']);
    }
    exit;
}


if ($action === 'add_to_wishlist') {
    $product_id = intval($_POST['product_id']);

    // Find or create wishlist
    $stmt = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE usercode = ?");
    $stmt->bind_param("s", $usercode);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $wishlist_id = $row['wishlist_id'];
    } else {
        $stmt = $mysqli->prepare("INSERT INTO wishlists (usercode, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $wishlist_id = $mysqli->insert_id;
    }

    // Check if product already in wishlist
    $stmt = $mysqli->prepare("SELECT * FROM wishlist_items WHERE wishlist_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $wishlist_id, $product_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->fetch_assoc()) {
        echo json_encode(['success' => false, 'message' => 'Product is already in wishlist']);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO wishlist_items (wishlist_id, product_id, added_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $wishlist_id, $product_id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
    }
    exit;
}

echo json_encode(['error' => 'Invalid request']);
