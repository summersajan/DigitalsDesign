<?php
include_once '../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

$sql = "SELECT of.order_file_id, p.title, df.file_url, df.file_type, o.order_status, o.order_id
        FROM orders o
        JOIN order_files of ON of.order_id = o.order_id
        JOIN digital_files df ON of.file_id = df.file_id
        JOIN products p ON of.product_id = p.product_id
        WHERE o.usercode = ? AND o.order_status IN ('completed','paid')";

if ($product_id) {
    $sql .= " AND of.product_id = ?";
}

$sql .= " ORDER BY o.created_at DESC";

$q = $mysqli->prepare($sql);
if ($product_id) {
    $q->bind_param("ii", $usercode, $product_id);
} else {
    $q->bind_param("i", $usercode);
}

$q->execute();
$res = $q->get_result();
?>


<?php if ($res->num_rows === 0): ?>
    <div class="digital-empty-state">
        <div class="digital-empty-icon">
            <i class="bi bi-cloud-arrow-down" style="font-size: 3rem; color: #94a3b8;"></i>
        </div>
        <h5 class="digital-empty-title">No Files Available</h5>
        <p class="digital-empty-text">You haven't purchased or completed any orders yet.</p>
        <a href="../" class="btn btn-primary mt-3">
            <i class="bi bi-bag"></i> Browse Products
        </a>
    </div>
<?php else: ?>
    <div class="digital-list">
        <?php while ($row = $res->fetch_assoc()): ?>
            <div class="digital-card position-relative">
                <div class="digital-card-title mb-1"><?= htmlspecialchars($row['title']) ?></div>
                <div class="digital-card-type text-muted mb-1">Type: <?= htmlspecialchars($row['file_type']) ?></div>
                <div class="small text-secondary mb-2">
                    Order ID: <?= (int) $row['order_id'] ?> &mdash;
                    Status: <span class="badge <?= $row['order_status'] == 'completed' ? 'bg-success' : 'bg-info' ?>">
                        <?= ucfirst($row['order_status']) ?>
                    </span>
                </div>
                <a href="ajax/download_files.php?order_file_id=<?php echo $row['order_file_id'] ?>"
                    class="btn btn-success btn-sm" download title="Download <?= htmlspecialchars($row['title']) ?>">
                    <i class="bi bi-download"></i> Download
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<!-- Isolated styling for digital files -->
<style>
    .digital-empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .digital-empty-icon {
        margin-bottom: 1.5rem;
    }

    .digital-empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .digital-empty-text {
        color: var(--gray);
        margin-bottom: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .digital-list {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    }

    .digital-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        background: white;
        transition: all 0.2s;
    }

    .digital-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.08);
    }

    .digital-card-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.1rem;
    }

    .digital-card-type {
        font-size: 0.92rem;
    }
</style>