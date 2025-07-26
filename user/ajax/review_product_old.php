<?php
include_once '../../config/db.php';
header("Content-Type: text/html; charset=utf-8");

$product_id = (int) ($_GET['product_id'] ?? 0);

$check = $mysqli->prepare("
    SELECT p.title FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.usercode = ? AND p.product_id = ? 
    AND NOT EXISTS (
        SELECT 1 FROM reviews r WHERE r.product_id = p.product_id AND r.usercode = ?
    )
    LIMIT 1
");
$check->bind_param("iii", $usercode, $product_id, $usercode);
$check->execute();
$check->bind_result($product_title);
if (!$check->fetch()) {
    echo "<div class='p-4'>Invalid review access.</div>";
    exit;
}
$check->close();
?>

<div class="modal-header">
    <h5 class="modal-title">Review for <?= htmlspecialchars($product_title) ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form method="post" id="review-form" autocomplete="off">
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
        <div class="mb-3">
            <label class="form-label">Your Rating</label>
            <div class="star-rating mb-2">
                <?php for ($i = 1; $i <= 5; ++$i): ?>
                    <i class="bi bi-star" data-value="<?= $i ?>"></i>
                <?php endfor; ?>
            </div>
            <input type="hidden" name="rating" id="rating-input" value="5">
        </div>
        <div class="mb-3">
            <label class="form-label">Your Review</label>
            <textarea name="comment" class="form-control" rows="3" required minlength="2" maxlength="1000"></textarea>
        </div>
        <div class="alert alert-success d-none" id="review-success">Thank you for your review!</div>
        <button class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<script>
    const ratingInput = document.getElementById('rating-input');
    document.querySelectorAll('.star-rating .bi').forEach(star => {
        star.addEventListener('mouseover', () => highlightStars(star.dataset.value));
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            highlightStars(star.dataset.value);
        });
    });

    function highlightStars(value) {
        document.querySelectorAll('.star-rating .bi').forEach(star => {
            star.classList.toggle('bi-star-fill', star.dataset.value <= value);
            star.classList.toggle('bi-star', star.dataset.value > value);
        });
    }
    highlightStars(5);


</script>


<script>
    document.getElementById('review-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch('ajax/submit_review.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(response => {
                if (response.trim() === "success") {
                    document.getElementById('review-success').classList.remove('d-none');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    alert("Failed to submit review.");
                }
            });
    });
</script>