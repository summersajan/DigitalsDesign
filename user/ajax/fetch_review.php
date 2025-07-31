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
$q->bind_param("is", $usercode, $usercode);
$q->execute();
$res = $q->get_result();
?>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<?php if ($res->num_rows === 0): ?>
    <div class="empty-state text-center">
        <div class="mb-3">
            <i class="fas fa-comment-dots text-muted" style="font-size: 3rem;"></i>
        </div>
        <h5 class="fw-semibold">All Reviewed!</h5>
        <p class="text-secondary">No pending reviews at the moment.</p>
        <a href="../" class="btn btn-danger mt-3">
            <i class="fas fa-store me-1"></i> Shop Now
        </a>
    </div>
<?php else: ?>
    <div class="container mt-4">
        <?php while ($row = $res->fetch_assoc()): ?>
            <div class="review-row card mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-2 mb-md-0 fw-bold text-truncate" style="max-width: 70%;">
                        <i class="fas fa-box-open me-2 text-primary"></i>
                        <?= htmlspecialchars($row['title']) ?>
                    </h6>
                    <a href="ajax/review_product.php?product_id=<?= $row['product_id'] ?>"
                        class="btn btn-outline-success btn-sm">
                        <i class="fas fa-pen me-1"></i> Write Review
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<style>
    .empty-state {
        padding: 3rem 1rem;
    }

    .review-row {
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .review-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 576px) {
        .review-row .card-body {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-row .btn {
            margin-top: 0.5rem;
        }
    }
</style>