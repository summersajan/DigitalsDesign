<?php
require_once '../config/db.php';

$action = $_POST['action'] ?? '';

if (empty($usercode)) {
    $currentUrl = $_POST['url'] ?? $_SERVER['HTTP_REFERER'] ?? 'cart.php';

    echo json_encode([
        'success' => 'login_required',
        'message' => 'Please log in first',
        'return_url' => $currentUrl
    ]);
    exit;
}






if ($action === 'add_to_cart') {
    $product_id = intval($_POST['product_id']);
    $quantity = 1;

    // Check or create cart
    $stmt = $mysqli->prepare("SELECT cart_id FROM carts WHERE usercode = ?");
    $stmt->bind_param("s", $usercode);
    $stmt->execute();
    $res = $stmt->get_result();

    $cart_id = $res->fetch_assoc()['cart_id'] ?? null;

    if (!$cart_id) {
        $stmt = $mysqli->prepare("INSERT INTO carts (usercode, created_at, updated_at) VALUES (?, NOW(), NOW())");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $cart_id = $mysqli->insert_id;
    }

    // Check if product already in cart
    $stmt = $mysqli->prepare("SELECT 1 FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->fetch_assoc()) {
        echo json_encode(['success' => '1', 'message' => 'Product is already in cart']);
    } else {
        // Insert into cart
        $stmt = $mysqli->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
        $stmt->execute();

        // Remove from wishlist
        $stmt = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE usercode = ?");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($wishlist = $res->fetch_assoc()) {
            $wishlist_id = $wishlist['wishlist_id'];
            $stmt = $mysqli->prepare("DELETE FROM wishlist_items WHERE wishlist_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $wishlist_id, $product_id);
            $stmt->execute();
        }

        echo json_encode(['success' => '1', 'message' => 'Added to cart']);
    }
    exit;
}



if ($action === 'add_to_wishlist') {
    $product_id = intval($_POST['product_id']);

    // Check or create wishlist
    $stmt = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE usercode = ?");
    $stmt->bind_param("s", $usercode);
    $stmt->execute();
    $res = $stmt->get_result();

    $wishlist_id = $res->fetch_assoc()['wishlist_id'] ?? null;

    if (!$wishlist_id) {
        $stmt = $mysqli->prepare("INSERT INTO wishlists (usercode, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $usercode);
        $stmt->execute();
        $wishlist_id = $mysqli->insert_id;
    }

    // Check if product already in wishlist
    $stmt = $mysqli->prepare("SELECT 1 FROM wishlist_items WHERE wishlist_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $wishlist_id, $product_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->fetch_assoc()) {
        echo json_encode(['success' => '2', 'message' => 'Product is already in wishlist']);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO wishlist_items (wishlist_id, product_id, added_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $wishlist_id, $product_id);
        $stmt->execute();
        echo json_encode(['success' => '2', 'message' => 'Added to wishlist']);
    }
    exit;
}


echo json_encode(['error' => 'Invalid request']);
