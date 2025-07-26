<?php
// login.php
session_start();
include 'db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $mysqli->prepare("SELECT user_id, password_hash, is_verified, login_attempts, usercode, name FROM users WHERE email = ? and is_admin = 1");
        if (!$stmt) {
            echo json_encode(["status" => 0, "message" => "Database error."]);
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password, $is_verified, $login_attempts, $usercode, $name);
            $stmt->fetch();

            if ($login_attempts >= 5) {
                echo json_encode(["status" => -3, "message" => "Your account is blocked due to too many failed login attempts."]);
            } elseif (!password_verify($password, $hashed_password)) {
                $login_attempts++;
                $mysqli->query("UPDATE users SET login_attempts = $login_attempts WHERE user_id = $id");
                if ($login_attempts >= 5) {
                    echo json_encode(["status" => -3, "message" => "Your account is blocked due to too many failed login attempts."]);
                } else {
                    echo json_encode(["status" => -2, "message" => "Invalid email or password."]);
                }
            } elseif ($is_verified != 1) {
                echo json_encode(["status" => -1, "message" => "Your account has not been verified."]);
            } else {
                $mysqli->query("UPDATE users SET login_attempts = 0 WHERE user_id = $id");
                $_SESSION['admin_digital_product'] = $usercode;
                echo json_encode([
                    "status" => 1,
                    "message" => "Login successful.",
                    "usercode" => $usercode
                ]);
            }
        } else {
            echo json_encode(["status" => -4, "message" => "Admin user not found."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => 0, "message" => "Invalid input."]);
    }

    $mysqli->close();
    exit;
} else {
    echo json_encode(["status" => 0, "message" => "Invalid request method."]);
}
