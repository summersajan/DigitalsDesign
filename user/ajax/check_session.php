<?php

require '../../config/db.php';

$response = ['status' => 'unauthorized Access'];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_digital_product'])) {
    $pdfUserCode = $_SESSION['user_digital_product'];
    $stmt = $mysqli->prepare("SELECT usercode FROM users WHERE usercode = ?");
    if ($stmt) {
        $stmt->bind_param("s", $pdfUserCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['status'] = 'authorized';
        } else {
            session_destroy();
        }
    }
}

echo json_encode($response);
exit;
