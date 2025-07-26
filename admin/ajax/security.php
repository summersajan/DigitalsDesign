<?php

require '../../config/db.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_digital_product'])) {
    die(); // No output, just exit if session is not set
}

$pdfUserCode = $_SESSION['admin_digital_product'];
$stmt = $mysqli->prepare("SELECT usercode FROM users WHERE usercode = ?");
if (!$stmt) {
    die();
}

$stmt->bind_param("s", $pdfUserCode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    session_destroy();
    die(); // Silent die on invalid session
}


