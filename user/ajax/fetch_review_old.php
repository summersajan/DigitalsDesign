<?php
include_once '../../config/db.php';
header("Content-Type: text/html; charset=utf-8");

$sql = "SELECT DISTINCT p.product_id, p.title
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.order_id
        JOIN products p ON oi.product_id = p.product_id
        WHERE o.usercode = ?
        AND NOT EXISTS (
            SELECT 1 FROM reviews r WHERE r.product_id = p.product_id AND r.usercode = ?
        )";
$q = $mysqli->prepare($sql);
$q->bind_param("ii", $usercode, $usercode);
$q->execute();
$res = $q->get_result();
?>



<?php if ($res->num_rows === 0): ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-chat-dots fs-1 text-muted mb-3"></i>
        <h5>All Reviewed!</h5>
        <p class="text-secondary">No Review Pending</p>
        <a href="../" class="btn btn-primary mt-3">
            <i class="bi bi-bag"></i> Shop
        </a>
    </div>
<?php else: ?>
    <div class="review-grid container mt-4">
        <div class="row g-3">
            <?php while ($row = $res->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="review-card border p-3 rounded d-flex justify-content-between align-items-center bg-white">
                        <div class="review-title fw-semibold"><?= htmlspecialchars($row['title']) ?></div>
                        <button class="btn btn-outline-primary btn-sm write-review-btn"
                            data-product-id="<?= $row['product_id'] ?>">
                            Write Review
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Modal for Review Form -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="reviewModalContent">
            <!-- Content will be loaded here via AJAX -->
        </div>
    </div>
</div>



<script>
    document.querySelectorAll('.write-review-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.productId;
            fetch('ajax/review_product.php?product_id=' + productId)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('reviewModalContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('reviewModal')).show();
                });
        });
    });
</script>