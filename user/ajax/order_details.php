<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line

$usercode = $_SESSION['user_digital_product'] ?? null;

$order_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

if (!$usercode) {
    echo '<div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-person-x" style="font-size:3rem;color:#94a3b8;"></i></div>
            <h5 class="empty-state-title">Unauthorized</h5>
            <p class="empty-state-text">Please log in to view your order.</p>
          </div>';
    exit;
}

if (!$order_id) {
    echo '<div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-receipt" style="font-size:3rem;color:#94a3b8;"></i></div>
            <h5 class="empty-state-title">No Order Selected</h5>
            <p class="empty-state-text">Please select a valid order to view details.</p>
          </div>';
    exit;
}

// Fetch the order, ensure it's the user's
$stmt = $mysqli->prepare("SELECT * FROM orders WHERE order_id=? AND usercode=?");
$stmt->bind_param("ii", $order_id, $usercode);
$stmt->execute();
$res = $stmt->get_result();
$order = $res->fetch_assoc();
$stmt->close();

if (!$order) {
    echo '<div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-journal-x" style="font-size:3rem;color:#94a3b8;"></i></div>
            <h5 class="empty-state-title">Order Not Found</h5>
            <p class="empty-state-text">This order does not exist or you don\'t have permission to view it.</p>
          </div>';
    exit;
}

// Fetch order items
$items_sql = "SELECT oi.*, p.title AS product_title 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.product_id 
    WHERE oi.order_id = ?";
$stmt = $mysqli->prepare($items_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_res = $stmt->get_result();
$order_items = [];
while ($row = $items_res->fetch_assoc())
    $order_items[] = $row;
$stmt->close();

// Fetch downloadable files for this order, if any
$files_sql = "SELECT ofiles.order_file_id, f.file_id, f.file_url, f.file_type, p.title AS product_title
FROM order_files ofiles
JOIN digital_files f ON ofiles.file_id = f.file_id
JOIN products p ON ofiles.product_id = p.product_id
WHERE ofiles.order_id = ?";
$stmt = $mysqli->prepare($files_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$files_res = $stmt->get_result();
$order_files = [];
while ($f = $files_res->fetch_assoc())
    $order_files[] = $f;
$stmt->close();

$statuses = [
    "completed" => "status-completed",
    "processing" => "status-processing",
    "shipped" => "status-processing",
    "cancelled" => "status-cancelled",
    "refunded" => "status-cancelled",
    "default" => "status-default"
];
$statusClass = $statuses[strtolower($order['order_status'])] ?? $statuses["default"];
$orderDate = date('M j, Y', strtotime($order['created_at']));
?>
<button class="view-order" id="order-detail-back"
    style="background: none; border: none; cursor: pointer; color: var(--primary); margin-bottom:12px;">
    <i class="bi bi-arrow-left"></i> Back to Orders
</button>
<div class="order-list">
    <div class="order-card">
        <div class="order-header">
            <div>
                <span class="order-id">Order #<?= $order['order_id'] ?></span>
                <div class="order-date">Placed on <?= $orderDate ?></div>
            </div>
            <span class="order-status <?= $statusClass ?>">
                <?= ucfirst($order['order_status']) ?>
            </span>
        </div>

        <div class="order-items">
            <?php
            $total = 0;
            foreach ($order_items as $row):
                $lineTotal = $row['price'] * $row['quantity'];
                $total += $lineTotal;
                ?>
                <div class="d-flex justify-content-between mb-1">
                    <span><?= htmlspecialchars($row['product_title']) ?> × <?= $row['quantity'] ?></span>
                    <span>$<?= number_format($lineTotal, 2) ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-footer">
            <div class="order-total">Total: $<?= number_format($order['total_amount'], 2) ?></div>

        </div>

        <?php if (count($order_files)): ?>
            <div class="order-items" style="margin-top:2em;">
                <h6>Downloads</h6>
                <?php foreach ($order_files as $f): ?>
                    <div class="d-flex justify-content-between mb-1">
                        <span>
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <?= htmlspecialchars($f['product_title']) ?> (<?= htmlspecialchars($f['file_type']) ?>)
                        </span>
                        <a href="ajax/download_files.php?order_file_id=<?= htmlspecialchars($f['order_file_id']) ?>"
                            class="view-order">
                            Download
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    $('#order-detail-back').click(function (e) {
        e.preventDefault();
        $('#orders-content').html(`
            <div class="text-center py-5">
                <div class="loading-spinner"></div>
                <p class="mt-3 text-muted">Loading your orders...</p>
            </div>
        `);
        $.get('ajax/fetch_orders.php', function (data) {
            $('#orders-content').html(data);
        });
    });
</script>