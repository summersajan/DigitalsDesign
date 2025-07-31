<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8");


$q = $mysqli->query("SELECT c.cart_id FROM carts c WHERE c.usercode='$usercode'");
$cart = $q->fetch_assoc();

if (!$cart) {
    echo '
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-cart-x" style="font-size: 3rem; color: #94a3b8;"></i>
        </div>
        <h5 class="empty-state-title">Cart is Empty</h5>
        <p class="empty-state-text">Looks like you haven’t added anything to your cart yet.</p>
        <a href="../" class="btn btn-danger mt-3">
            <i class="bi bi-bag"></i> Browse Products
        </a>
    </div>';
    exit;
}

$cart_id = $cart['cart_id'];
$sql = "SELECT ci.cart_item_id, p.title, p.price, ci.quantity 
        FROM cart_items ci
        JOIN products p ON ci.product_id=p.product_id
        WHERE ci.cart_id=$cart_id";
$res = $mysqli->query($sql);
?>

<div class="order-list">
    <div class="order-card">
        <div class="order-header">
            <div>
                <span class="order-id">Your Cart</span>
                <div class="order-date"><?= date('M j, Y') ?></div>
            </div>
            <span class="order-status status-default">Pending</span>
        </div>

        <div class="order-items">
            <?php
            $total = 0;
            while ($row = $res->fetch_assoc()):
                $lineTotal = $row['price'] * $row['quantity'];
                $total += $lineTotal;
                ?>
                <div class="d-flex justify-content-between mb-1">
                    <span><?= htmlspecialchars($row['title']) ?> × <?= $row['quantity'] ?></span>
                    <span>$<?= number_format($lineTotal, 2) ?></span>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="order-footer">
            <div class="order-total">Total: $<?= number_format($total, 2) ?></div>
            <a href="../cart.php" class="view-order">
                Proceed to Checkout
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Reuse the same CSS -->
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