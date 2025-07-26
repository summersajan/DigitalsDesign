<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8"); // Add this line



$q = $mysqli->prepare("SELECT name, email, created_at FROM users WHERE usercode=?");
$q->bind_param("i", $usercode);
$q->execute();
$row = $q->get_result()->fetch_assoc();
?>
<div class="card" data-username="<?= htmlspecialchars($row['name']) ?>"
    data-useremail="<?= htmlspecialchars($row['email']) ?>">
    <!-- ...rest of the profile ... -->
    <div class="card-body">
        <h4 class="mb-3">Profile</h4>
        <div><b>Name:</b> <?= htmlspecialchars($row['name']) ?></div>
        <div><b>Email:</b> <?= htmlspecialchars($row['email']) ?></div>
        <div><b>Joined:</b> <?= $row['created_at'] ?></div>
    </div>
</div>