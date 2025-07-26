<?php
include '../../config/db.php';
header("Content-Type: text/html; charset=utf-8");

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Invalid or missing token.");
}

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE verification_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Invalid or expired reset link.");
}

$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .reset-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
        }

        .card {
            padding: 30px;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .btn-block {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="card">
            <h4 class="text-center mb-4">Reset Your Password</h4>
            <form id="resetForm">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm" name="confirm" required>
                </div>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                <div id="message" class="mt-3"></div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("resetForm").addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('update_password.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    const msg = document.getElementById("message");
                    msg.className = data.status === 'success' ? 'alert alert-success' : 'alert alert-danger';
                    msg.innerHTML = data.message;

                    if (data.status === 'success') {
                        setTimeout(() => {
                            window.location.href = '../../login.php';
                        }, 2000);
                    }
                }).catch(err => {
                    document.getElementById("message").innerHTML = 'Unexpected error occurred.';
                });
        });
    </script>
</body>

</html>