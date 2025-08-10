<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | DigtialsProduct </title>
    <link rel="icon" type="image/png" href="images/logo.png" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #ff5757;
            --secondary-color: #fff5f5;
            --accent-color: #1e293b;
            --text-color: #5a5c69;
            --light-color: #ffffff;
            --error-color: #e74a3b;
            --success-color: #1cc88a;
            --border-color: #e0e7ff;
            --shadow-color: rgba(255, 87, 87, 0.15);
        }



        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--secondary-color);
        }

        .auth-container {
            background-color: var(--light-color);
            border-radius: 16px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: row;
            padding: 0;
        }

        .auth-image {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            color: white;
            flex: 1.3;
            min-width: 320px;
        }

        .auth-image img {
            max-width: 100%;
            height: auto;
        }

        .auth-image .text-center {
            width: 100%;
        }

        .auth-form {
            padding: 3rem 2.5rem;
            flex: 1.7;
            min-width: 350px;
        }

        .form-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-color);
        }

        .password-container {
            position: relative;
        }

        .alert {
            border-radius: 0.35rem;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider-text {
            padding: 0 1rem;
            color: var(--text-color);
            font-size: 0.875rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        @media (max-width: 1200px) {
            .auth-container {
                max-width: 98vw;
            }
        }

        @media (max-width: 991.98px) {
            .auth-image {
                display: none !important;
            }

            .auth-form {
                padding: 2.5rem 1rem;
            }

            .auth-container {
                flex-direction: column;
                min-height: unset;
            }
        }

        @media (max-width: 450px) {
            .auth-form {
                padding: 1.25rem .5rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container row gx-0">
            <!-- Left Side - Image / Illustration (optional) -->
            <div class="col-md-6 d-none d-md-flex auth-image" style="flex:1.1;">
                <div class="text-center w-100">
                    <h2 class="mt-3">Admin Login</h2>
                    <p>Please login to access your admin panel</p>
                </div>
            </div>
            <!-- Right Side - Login Form -->
            <div class="col-md-6 auth-form">
                <div id="login-form">
                    <h2 class="form-title">Sign In</h2>
                    <div id="login-alert" class="alert d-none"></div>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="login-email" name="email" required>
                        </div>
                        <div class="mb-3 password-container">
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="login-password" name="password" required>
                            <i class="fas fa-eye password-toggle" style="margin-top: 5%;" id="toggleLoginPassword"></i>
                        </div>
                        <div class="mb-3">
                            <div class="text-center mt-3">
                                <a href="#forgot-password" class="text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#forgotPasswordModal">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3" id="login-btn">
                            <span id="login-btn-text">Sign In</span>
                            <span id="login-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for forgot password -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="forgot-alert" class="alert d-none"></div>
                        <form id="forgotPasswordForm">
                            <div class="mb-3">
                                <label for="forgot-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="forgot-email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="forgot-btn">
                                <span id="forgot-btn-text">Send Reset Link</span>
                                <span id="forgot-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Toggle password visibility
            $('#toggleLoginPassword').click(function () {
                const passwordField = $('#login-password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // Login AJAX
            $('#loginForm').submit(function (e) {
                e.preventDefault();
                const email = $('#login-email').val().trim();
                const password = $('#login-password').val().trim();
                if (!email || !password) {
                    showAlert('login-alert', 'Please fill in all fields', 'danger');
                    return;
                }
                $('#login-btn-text').text('Signing In...');
                $('#login-spinner').removeClass('d-none');
                $('#login-btn').prop('disabled', true);
                $.ajax({
                    url: 'auth/login.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { email, password },
                    success: function (response) {
                        let message = response.message || 'Login failed. Please try again.';
                        if (response.status === 1) {
                            showAlert('login-alert', message, 'success');
                            setTimeout(() => { window.location.href = 'index.php'; }, 700);
                        } else if (response.status === -1) {
                            showAlert('login-alert', 'Your account has not been verified.', 'danger');
                        } else if (response.status === -2) {
                            showAlert('login-alert', 'Invalid email or password.', 'danger');
                        } else if (response.status === -3) {
                            showAlert('login-alert', 'Your account is blocked due to too many failed login attempts.', 'danger');
                        } else if (response.status === -4) {
                            showAlert('login-alert', 'Admin user not found.', 'danger');
                        } else {
                            showAlert('login-alert', message, 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        showAlert('login-alert', 'A system error occurred. Please try again later.', 'danger');
                    },
                    complete: function () {
                        $('#login-btn-text').text('Sign In');
                        $('#login-spinner').addClass('d-none');
                        $('#login-btn').prop('disabled', false);
                    }
                });
            });

            // Show alert helper
            function showAlert(containerId, message, type) {
                const alert = $('#' + containerId).removeClass('d-none alert-success alert-danger alert-warning')
                    .addClass('alert-' + type).text(message);
                setTimeout(() => { alert.addClass('d-none'); }, 5000);
            }
        </script>
    </div>
</body>

</html>