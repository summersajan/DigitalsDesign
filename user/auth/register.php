<?php
include '../../config/db.php';
header('Content-Type: application/json; charset=utf-8');
$response = ['status' => 0, 'message' => 'Invalid request.'];

function generate_uuid_v4()
{
    // RFC 4122-compliant v4
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff), // 32 bits
        mt_rand(0, 0xffff), // 16 bits
        mt_rand(0, 0x0fff) | 0x4000, // version 4 (16 bits)
        mt_rand(0, 0x3fff) | 0x8000, // variant 10xx (16 bits)
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff) // 48 bits
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');
    $name = trim($_POST['name'] ?? '');

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response['message'] = "Email is already registered.";
        } else {
            $stmt->close();

            $token = bin2hex(random_bytes(32));
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $status = 0;
            $usercode = generate_uuid_v4();

            // Insert user with usercode and verification token
            $stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash, verification_token, is_verified, usercode) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssis", $name, $email, $hashed_password, $token, $status, $usercode);

            if ($stmt->execute()) {
                require_once 'Mailer.php'; // Adjust the path as necessary

                $baseUrl = $mail_url . 'user/auth/verify_token.php';
                $verifyLink = $baseUrl . '?token=' . urlencode($token);

                $mailer = new Mailer();
                $mailResult = $mailer->sendLinkEmail($email, 'verification', $verifyLink);
                $response['status'] = 1;
                if ($mailResult === 1) {
                    $response['status'] = 1;
                    $response['message'] = "Registration successful. Verification email sent.";
                } else {
                    $response['message'] = "Registration successful, but failed to send verification email.";
                }
            } else {
                $response['message'] = "Registration failed. Please try again.";
            }
            $stmt->close();
        }
    } else {
        $response['message'] = "Invalid input data.";
    }
}

$mysqli->close();
echo json_encode($response);
?>