<?php
include_once '../../config/db.php';
header("Content-Type: text/html; charset=utf-8");

$product_id = (int) ($_GET['product_id'] ?? 0);

// Validate purchase and pending review
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
$check->bind_param("iis", $usercode, $product_id, $usercode);
$check->execute();
$check->bind_result($product_title);
if (!$check->fetch()) {
    echo "
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />
    <div class='text-center mt-5'>
        <div class='alert alert-danger d-inline-block'>
            <i class='fas fa-exclamation-triangle me-2'></i>
            Invalid review access.
        </div>
        <div class='mt-3'>
            <a href='../' class='btn btn-secondary'>
                <i class='fas fa-arrow-left me-1'></i> Back to Shop
            </a>
        </div>
    </div>";
    exit;
}
$check->close();

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = max(1, min(5, (int) $_POST['rating']));
    $comment = trim($_POST['comment']);

    $ins = $mysqli->prepare("INSERT INTO reviews (product_id, usercode, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $ins->bind_param("isis", $product_id, $usercode, $rating, $comment);
    $ins->execute();
    $ins->close();

    echo "
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />

<div class='text-center mt-5'>
    <div class='alert alert-success d-inline-block'>
        <i class='fas fa-check-circle fa-2x me-2'></i>
        Thank you for your review!
    </div>
</div>

<script>
    setTimeout(function() {
        window.location='../';
    }, 1200);
</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Write a Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .star-rating i {
            font-size: 2rem;
            color: #f6b800;
            cursor: pointer;
            transition: color 0.15s;
        }

        .star-rating i:hover {
            color: #ffaa2b;
        }

        .back-btn {
            position: absolute;
            top: 1rem;
            left: 1rem;
        }

        @media (max-width: 576px) {
            .back-btn {
                position: relative;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5 position-relative">
        <a href="../" class="btn btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>

        <div class="mx-auto shadow p-4 bg-white rounded" style="max-width: 480px;">
            <h3 class="mb-4">Review for <span class="text-primary"><?= htmlspecialchars($product_title) ?></span></h3>

            <form method="post" id="review-form" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fs-6">Your Rating</label>
                    <div class="star-rating mb-2">
                        <?php for ($i = 1; $i <= 5; ++$i): ?>
                            <i class="fa-regular fa-star" data-value="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="5" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Your Review</label>
                    <textarea name="comment" class="form-control" rows="4" required minlength="2" maxlength="1000"
                        placeholder="Write something about the product..."></textarea>
                </div>

                <button class="btn btn-danger w-100">
                    <i class="fas fa-paper-plane me-1"></i> Submit Review
                </button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.star-rating i').forEach(function (star) {
            star.addEventListener('mouseover', function () {
                highlightStars(parseInt(this.dataset.value));
            });
            star.addEventListener('click', function () {
                const value = parseInt(this.dataset.value);
                document.getElementById('rating-input').value = value;
                highlightStars(value);
            });
        });

        function highlightStars(val) {
            document.querySelectorAll('.star-rating i').forEach(function (star) {
                const value = parseInt(star.dataset.value);
                star.classList.remove('fa-solid', 'fa-regular');
                if (value <= val) {
                    star.classList.add('fa-solid');
                } else {
                    star.classList.add('fa-regular');
                }
                star.classList.add('fa-star');
            });
        }

        // Default highlight
        highlightStars(5);
    </script>

</body>

</html>