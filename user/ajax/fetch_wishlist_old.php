<?php
include_once '../../config/db.php';
header("Content-Type: text/html; charset=utf-8");

$q = $mysqli->query("SELECT wishlist_id FROM wishlists WHERE usercode= '$usercode'");
$w = $q->fetch_assoc();

if (!$w) {
    echo '
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-heart" style="font-size: 3rem; color: #94a3b8;"></i>
        </div>
        <h5 class="empty-state-title">No Wishlist Found</h5>
        <p class="empty-state-text">You haven’t saved any products yet. Add items to your wishlist to view them later.</p>
        <a href="../" class="btn btn-primary mt-3">
            <i class="bi bi-bag"></i> Browse Products
        </a>
    </div>';
    exit;
}

$wishlist_id = $w['wishlist_id'];

$sql = "SELECT wi.wishlist_item_id, p.product_id, p.title, p.price, pi.image_url
        FROM wishlist_items wi
        JOIN products p ON wi.product_id = p.product_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_main=1
        WHERE wi.wishlist_id = $wishlist_id";
$res = $mysqli->query($sql);
?>

<h2 style="text-align: center; font-weight: 700; margin: 2rem 0;">Your Wishlist</h2>

<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['wishlist_item_id'] ?></td>
                    <td class="d-flex align-items-center gap-2" style="justify-content: start;">
                        <?php if ($row['image_url']): ?>
                            <img src="../<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['title']) ?>"
                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        <?php endif; ?>
                        <strong><?= htmlspecialchars($row['title']) ?></strong>
                    </td>
                    <td>₹<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <button class="btn btn-outline-danger delete-btn" data-id="<?= $row['wishlist_item_id'] ?>">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Styles -->
<style>
    .table td,
    .table th {
        vertical-align: middle !important;
    }
</style>

<!-- Optional: Delete with Confirmation -->
<script>
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            if (!confirm("Are you sure you want to delete this item?")) return;

            const id = btn.dataset.id;
            fetch("ajax/delete_wishlist_item.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ wishlist_item_id: id })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Failed to delete item.");
                    }
                });
        });
    });
</script>