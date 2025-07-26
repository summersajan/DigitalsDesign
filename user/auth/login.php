<?php


session_start();
include '../../config/db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');


    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $mysqli->prepare("SELECT user_id, password_hash, is_verified, login_attempts, usercode, name FROM users WHERE email = ?");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $mysqli->error]);
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password, $is_verified, $login_attempts, $usercode, $name);
            $stmt->fetch();

            if ($login_attempts >= 5) {
                echo json_encode(["status" => -1, "message" => "Your account is temporarily blocked after 5 failed login attempts."]);
            } elseif (password_verify($password, $hashed_password)) {
                if ($is_verified != 1) {
                    echo json_encode(["status" => -2, "message" => "Please verify your email before logging in."]);
                } else {
                    $mysqli->query("UPDATE users SET login_attempts = 0 WHERE user_id = $id");
                    $_SESSION['user_digital_product'] = $usercode;
                    $_SESSION['user_email'] = $email;
                    $redirectUrl = $_SESSION['return_url'] ?? 'index.php';
                    unset($_SESSION['return_url']); // clear after use
                    echo json_encode([
                        "status" => 1,
                        "message" => "Login successful.",
                        "usercode" => $usercode,
                        'redirect' => $redirectUrl
                    ]);
                }
            } else {
                $login_attempts++;
                $mysqli->query("UPDATE users SET login_attempts = $login_attempts WHERE user_id = $id");

                if ($login_attempts >= 5) {
                    echo json_encode(["status" => -3, "message" => "Account blocked after 5 failed login attempts."]);
                } else {
                    echo json_encode(["status" => -4, "message" => "Invalid credentials. Attempt $login_attempts of 5."]);
                }
            }
        } else {
            echo json_encode(["status" => -5, "message" => "User not found."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => -6, "message" => "Invalid input."]);
    }

    $mysqli->close();
    exit;
} else {
    echo json_encode(["status" => -7, "message" => "Invalid request method"]);
}
?>