<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line


$sql = "SELECT * FROM orders WHERE usercode=? ORDER BY created_at DESC";
$q = $mysqli->prepare($sql);
$q->bind_param("s", $usercode);
$q->execute();
$res = $q->get_result();
?>



<?php if ($res->num_rows === 0): ?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-cart-x" style="font-size: 3rem; color: #94a3b8;"></i>
        </div>
        <h5 class="empty-state-title">No Orders Yet</h5>
        <p class="empty-state-text">You haven't placed any orders yet. When you do, they'll appear here.</p>
        <a href="../" class="btn btn-danger mt-3">
            <i class="bi bi-bag"></i> Browse Products
        </a>
    </div>
<?php else: ?>
    <div class="order-list">
        <?php while ($row = $res->fetch_assoc()):
            // Determine status class
            $statusClass = '';
            switch (strtolower($row['order_status'])) {
                case 'completed':
                    $statusClass = 'status-completed';
                    break;
                case 'processing':
                case 'shipped':
                    $statusClass = 'status-processing';
                    break;
                case 'cancelled':
                case 'refunded':
                    $statusClass = 'status-cancelled';
                    break;
                default:
                    $statusClass = 'status-default';
            }

            // Format date
            $orderDate = date('M j, Y', strtotime($row['created_at']));
            ?>
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Order #<?= $row['order_id'] ?></span>
                        <div class="order-date">Placed on <?= $orderDate ?></div>
                    </div>
                    <span class="order-circle <?= $statusClass ?>">
                        <span><?= ucfirst($row['order_status']) ?></span>
                    </span>

                </div>

                <div class="order-items">
                    <?php
                    // Fetch order items
                    $itemsSql = "SELECT oi.*, p.title AS product_title 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.product_id 
                    WHERE oi.order_id = ?";
                    $itemsQ = $mysqli->prepare($itemsSql);
                    $itemsQ->bind_param("i", $row['order_id']);
                    $itemsQ->execute();
                    $itemsRes = $itemsQ->get_result();

                    while ($item = $itemsRes->fetch_assoc()): ?>
                        <div class="d-flex justify-content-between mb-1">
                            <span><?= htmlspecialchars($item['product_title']) ?> × <?= $item['quantity'] ?></span>
                            <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="order-footer">
                    <div class="order-total">Total: $<?= number_format($row['total_amount'], 2) ?></div>

                    <button class="order-detail-button" data-order-id="<?= $row['order_id'] ?>">
                        <i class="bi bi-receipt"></i> View Details
                    </button>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php ob_end_flush();
endif; ?>

<style>
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .empty-state-text {
        color: var(--gray);
        margin-bottom: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .order-list {
        display: grid;
        gap: 1rem;
    }

    .order-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.25rem;
        transition: all 0.2s;
        background: white;
    }

    .order-card:hover {
        border-color: var(--primary-light);
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.08);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .order-id {
        font-weight: 600;
        color: var(--primary);
    }

    .order-date {
        color: var(--gray);
        font-size: 0.875rem;
    }

    .order-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-completed {
        background: #ecfdf5;
        color: #059669;
    }

    .status-processing {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-cancelled {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .order-items {
        margin-bottom: 0.5rem;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .order-total {
        font-weight: 600;
    }

    .view-order {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s;
    }

    .view-order:hover {
        color: #4338ca;
    }
</style>
<script>
    $(document).on('click', '.order-detail-button', function () {
        var orderId = $(this).data('order-id');
        if (!orderId) {
            alert('Order ID is missing!');
            return;
        }
        $('#orders-content').html(`
        <div class="text-center py-5">
            <div class="loading-spinner"></div>
            <p class="mt-3 text-muted">Loading order details...</p>
        </div>
    `);

        $.get('ajax/order_details.php', { id: orderId }, function (data) {
            $('#orders-content').html(data);
        }).fail(function () {
            $('#orders-content').html(`
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                Failed to load order details.
            </div>
        `);
        });
    });
</script>