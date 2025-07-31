<?php
require_once '../config/db.php';

if (!$usercode) {
    echo "
    <div class='text-center my-5'>
        <i class='bi bi-heart-slash fs-1 text-danger'></i>
        <h4 class='mt-3'>Please login to view your wishlist.</h4>
    </div>";
    exit;
}

$stmt = $mysqli->prepare("SELECT wishlist_id FROM wishlists WHERE usercode = ?");
$stmt->bind_param("s", $usercode);
$stmt->execute();
$res = $stmt->get_result();
$wishlist = $res->fetch_assoc();

if (!$wishlist) {
    echo "
    <div class='text-center my-5'>
        <i class='bi bi-heart-slash fs-1 text-muted'></i>
        <h4 class='mt-3'>Your Wishlist is empty.</h4>
        <a href='index.php' class='btn btn-primary mt-3'>Browse Products</a>
    </div>";
    exit;
}

$wishlist_id = $wishlist['wishlist_id'];

$query = "
    SELECT wi.wishlist_item_id, p.product_id, p.title, p.price, p.old_price, p.discount, pi.image_url
    FROM wishlist_items wi
    JOIN products p ON p.product_id = wi.product_id
    LEFT JOIN product_images pi ON pi.product_id = p.product_id AND pi.is_main = 1
    WHERE wi.wishlist_id = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $wishlist_id);
$stmt->execute();
$items = $stmt->get_result();

if ($items->num_rows === 0) {
    echo "
    <div class='text-center my-5'>
        <i class='bi bi-heart-slash fs-1 text-muted'></i>
        <h4 class='mt-3'>Your Wishlist is empty.</h4>
        <a href='index.php' class='btn btn-primary mt-3'>Browse Products</a>
    </div>";
    exit;
}
?>

<div class="table-responsive mt-4">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Price</th>
                <th style="width: 280px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $items->fetch_assoc()): ?>
                <tr data-id="<?= $row['wishlist_item_id'] ?>">
                    <td><?= $row['wishlist_item_id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>"
                                alt="<?= htmlspecialchars($row['title']) ?>" width="60" class="me-3 rounded">
                            <div>
                                <strong><?= htmlspecialchars($row['title']) ?></strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        ₹<?= $row['price'] ?>
                        <?php if ($row['old_price']): ?>
                            <br><small><del class="text-muted">₹<?= $row['old_price'] ?></del></small>
                        <?php endif; ?>
                        <?php if ($row['discount']): ?>
                            <br><span class="badge bg-success"><?= $row['discount'] ?>% OFF</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-danger btn-sm delete-btn"
                                data-id="<?= $row['wishlist_item_id'] ?>">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                            <button class="btn btn-primary btn-sm move-btn" data-id="<?= $row['wishlist_item_id'] ?>"
                                data-product="<?= $row['product_id'] ?>">
                                <i class="bi bi-cart-plus"></i> Move to Cart
                            </button>
                        </div>
                    </td>


                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>