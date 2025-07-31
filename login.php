<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DigtialsProduct </title>
    <link rel="icon" type="image/png" href="images/logo.png" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
    <a href="index.php" style="
    position: absolute;
    top: 20px;
    left: 20px;
    text-decoration: none;
    color: var(--primary-color);
    font-weight: bold;
    font-size: 16px;
">
        ← Back
    </a>
    <div class="auth-wrapper">


        <div class="auth-container row gx-0">
            <!-- Left Side - Image/Illustration -->
            <div class="col-md-6 d-none d-md-flex auth-image" style="flex:1.1;">
                <div class="text-center w-100">
                    <h2 class="mt-3">Welcome Back!</h2>
                    <p>Please login to access your account</p>
                </div>

            </div>
            <!-- Right Side - Forms -->
            <div class="col-md-6 auth-form">
                <!-- Login Form -->
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
                            <i class="fas fa-eye password-toggle" id="toggleLoginPassword"></i>
                        </div>
                        <div class="mb-3 form-check">
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

                    <div class="form-footer">
                        Don't have an account? <a href="#" id="show-register">Sign Up</a>
                    </div>
                </div>
                <!-- Registration Form (Hidden by default) -->
                <div id="register-form" style="display: none;">
                    <h2 class="form-title">Create Account</h2>
                    <div id="register-alert" class="alert d-none"></div>
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="register-email" name="email" required>
                        </div>
                        <div class="mb-3 password-container">
                            <label for="register-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="register-password" name="password" required>
                            <i class="fas fa-eye password-toggle" id="toggleRegisterPassword"></i>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms-agree">
                            <label class="form-check-label" for="terms-agree">I agree to the <a href="terms.php">Terms &
                                    Conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3" id="register-btn">
                            <span id="register-btn-text">Sign Up</span>
                            <span id="register-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>


                    </form>

                    <div class="form-footer">
                        Already have an account? <a href="#" id="show-login">Sign In</a>
                    </div>
                </div>
                <div id="google-form" style="display: none;">
                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>
                    <div class="social-login">

                        <div id="loginDiv">
                            <div id="g_id_onload" data-client_id="" data-callback="handleCredentialResponse"
                                data-auto_prompt="false">
                            </div>
                            <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                                data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resend Verification After Registration (Hidden by default) -->
                <div id="resend-verification-after-register" style="display: none;">
                    <h2 class="form-title">Verify Your Email</h2>
                    <p>A verification email has been sent to <span id="registered-email" class="fw-bold"></span>.
                    </p>
                    <div id="resend-alert" class="alert d-none"></div>
                    <form id="resendVerificationForm">
                        <input type="hidden" id="resend-email" name="email">
                        <button type="submit" class="btn btn-primary mb-3" id="resend-btn">
                            <span id="resend-btn-text">Resend Verification Email</span>
                            <span id="resend-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </form>
                    <div class="form-footer">
                        Already verified? <a href="#" id="show-login-after-resend">Sign In</a>
                    </div>
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
        <!-- Verification Modal (for users who didn't just register!) -->
        <div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Email Verification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="verification-alert" class="alert d-none"></div>
                        <form id="verificationForm">
                            <div class="mb-3">
                                <label for="verification-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="verification-email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="verification-btn">
                                <span id="verification-btn-text">Resend Verification</span>
                                <span id="verification-spinner" class="spinner-border spinner-border-sm d-none"
                                    role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Password Reset Modal -->
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Set New Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="reset-alert" class="alert d-none"></div>
                        <form id="resetPasswordForm">
                            <input type="hidden" id="reset-email" name="email">
                            <div class="mb-3 password-container">
                                <label for="reset-new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="reset-new-password" name="new_password"
                                    required>
                                <i class="fas fa-eye password-toggle" id="toggleResetPassword"></i>
                            </div>
                            <div class="mb-3 password-container">
                                <label for="reset-confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="reset-confirm-password" required>
                                <i class="fas fa-eye password-toggle" id="toggleResetConfirmPassword"></i>
                            </div>
                            <button type="submit" class="btn btn-primary" id="reset-btn">
                                <span id="reset-btn-text">Update Password</span>
                                <span id="reset-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#google-form').show();
            // Toggle between login and register forms
            $('#show-register').click(function (e) {
                e.preventDefault();
                $('#login-form').hide();
                $('#register-form').show();
                $('#google-form').show();
                $('#resend-verification-after-register').hide();
            });
            $('#show-login').click(function (e) {
                e.preventDefault();
                $('#register-form').hide();
                $('#google-form').show();
                $('#resend-verification-after-register').hide();
                $('#login-form').show();
            });
            $('#show-login-after-resend').click(function (e) {
                e.preventDefault();
                $('#resend-verification-after-register').hide();
                $('#register-form').hide();
                $('#login-form').show();
                $('#google-form').hide();
            });
            // Password toggle functionality
            $('#toggleLoginPassword').click(function () {
                const passwordField = $('#login-password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#toggleRegisterPassword').click(function () {
                const passwordField = $('#register-password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });


            // === Registration form submission logic ===
            let registeredEmail = "";
            $('#registerForm').submit(function (e) {
                e.preventDefault();

                const email = $('#register-email').val().trim();
                const password = $('#register-password').val().trim();
                const name = $('#name').val().trim();

                if (!email || !password || !name) {
                    showAlert('register-alert', 'Please fill in all fields', 'danger');
                    return;
                }
                if (!validateEmail(email)) {
                    showAlert('register-alert', 'Please enter a valid email address', 'danger');
                    return;
                }
                if (password.length < 6) {
                    showAlert('register-alert', 'Password must be at least 6 characters', 'danger');
                    return;
                }
                if (!$('#terms-agree').is(':checked')) {
                    showAlert('register-alert', 'You must agree to the terms and conditions', 'danger');
                    return;
                }

                // Show loading state
                $('#register-btn-text').text('Creating Account...');
                $('#register-spinner').removeClass('d-none');
                $('#register-btn').prop('disabled', true);





                // ✅ Send as raw JSON
                $.ajax({
                    url: 'user/auth/register.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        password: password,
                        name: name
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status === 1) {
                            registeredEmail = email;
                            $('#registered-email').text(registeredEmail);
                            $('#resend-email').val(registeredEmail);
                            $('#registerForm')[0].reset();
                            showAlert('register-alert', response.message, 'success');
                            setTimeout(() => {
                                $('#register-form').hide();
                                $('#login-form').hide();
                                $('#google-form').hide();
                                $('#resend-verification-after-register').show();
                            }, 500);
                        } else {
                            showAlert('register-alert', response.message || 'Registration failed. Please try again.', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText, "Status:", status, "Error:", error);
                        showAlert('register-alert', 'An error occurred: ', 'danger');
                    },

                    complete: function () {
                        $('#register-btn-text').text('Sign Up');
                        $('#register-spinner').addClass('d-none');
                        $('#register-btn').prop('disabled', false);
                    }
                });
            });

            // AJAX registration request


            // === Resend Verification After Registration (NO MODAL) ===
            $('#resendVerificationForm').submit(function (e) {
                e.preventDefault();
                const email = $('#resend-email').val();
                if (!validateEmail(email)) {
                    showAlert('resend-alert', 'Invalid email format', 'danger');
                    return;
                }
                $('#resend-btn-text').text('Resending...');
                $('#resend-spinner').removeClass('d-none');
                $('#resend-btn').prop('disabled', true);
                $.ajax({
                    url: 'user/auth/resend_email.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { email: email },
                    success: function (response) {
                        console.log(response);
                        if (response.status === 'success' || response.status === 1) {
                            showAlert('resend-alert', 'Verification email sent again!', 'success');
                        } else {
                            showAlert('resend-alert', response.message || 'Failed to resend verification email', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText, "Status:", status, "Error:", error);
                        showAlert('resend-alert', 'An error occurred. Please try again.', 'danger');
                    },

                    complete: function () {
                        $('#resend-btn-text').text('Resend Verification Email');
                        $('#resend-spinner').addClass('d-none');
                        $('#resend-btn').prop('disabled', false);
                    }
                });
            });

            // Login form and other JS...

            // Login form submission
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
                    url: 'user/auth/login.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status === 1) {
                            showAlert('login-alert', response.message, 'success');
                            setTimeout(() => {
                                window.location.href = response.redirect || 'user/';
                                //  window.location.href = 'user/';
                            }, 500);
                        } else {
                            if (response.status === 0 || response.status === -2 || response.status === '-2') {
                                showAlert('login-alert', 'Please verify your email before logging in.', 'warning');
                                $('#registered-email').text(email);
                                $('#resend-email').val(email);
                                $('#loginForm')[0].reset();
                                setTimeout(() => {
                                    $('#register-form').hide();
                                    $('#login-form').hide();
                                    $('#google-form').hide();
                                    $('#resend-verification-after-register').show();
                                }, 500);
                            } else {
                                showAlert('login-alert', response.message || 'Login failed.', 'danger');
                            }
                        }

                    },
                    error: function (xhr, status, error) {
                        let errorMessage = `
        <strong>Error:</strong> ${xhr.status} ${xhr.statusText}<br>
        <strong>Backend Response:</strong><br><pre>${xhr.responseText}</pre>
    `;

                        // Log full error details in console for developers
                        console.error("XHR Object:", xhr);
                        console.error("Status:", status);
                        console.error("Error:", error);

                        // Display in a custom alert area (ensure you have an element with id="resend-alert")
                        showAlert('resend-alert', errorMessage, 'danger');
                    }

                    ,
                    complete: function () {
                        $('#login-btn-text').text('Sign In');
                        $('#login-spinner').addClass('d-none');
                        $('#login-btn').prop('disabled', false);
                    }
                });
            });

            // Helper function to show alerts
            function showAlert(containerId, message, type) {
                const alert = $('#' + containerId);
                alert.removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-' + type);
                alert.text(message);
                setTimeout(() => {
                    alert.addClass('d-none');
                }, 5000);
            }
            // Email validation helper
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Modals and other reset/forgot logic (unchanged from your code)
            // Forgot Password Link Click
            $('a[href="#forgot-password"]').click(function (e) {
                e.preventDefault();
                $('#forgotPasswordModal').modal('show');
            });
            // Verification Modal Link Click
            $('a[href="#resend-verification"]').click(function (e) {
                e.preventDefault();
                $('#verificationModal').modal('show');
            });
            // Forgot Password Form Submission
            $('#forgotPasswordForm').submit(function (e) {
                e.preventDefault();
                const email = $('#forgot-email').val().trim();
                if (!validateEmail(email)) {
                    showAlert('forgot-alert', 'Please enter a valid email address', 'danger');
                    return;
                }
                $('#forgot-btn-text').text('Sending...');
                $('#forgot-spinner').removeClass('d-none');
                $('#forgot-btn').prop('disabled', true);

                $.ajax({
                    url: 'user/auth/reset_password.php',
                    type: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    data: JSON.stringify({ email: email }), // ✅ FIXED
                    success: function (response) {
                        console.log('my response', response);
                        if (response.status === 'success' || response.status === 1) {
                            showAlert('forgot-alert', 'Password reset link sent to your email', 'success');
                            $('#forgotPasswordForm')[0].reset();
                            setTimeout(() => { $('#forgotPasswordModal').modal('hide'); }, 2000);
                        } else {
                            showAlert('forgot-alert', response.message || 'Failed to send reset link', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText, "Status:", status, "Error:", error);
                        showAlert('forgot-alert', 'An error occurred. Please try again.', 'danger');
                    },
                    complete: function () {
                        $('#forgot-btn-text').text('Send Reset Link');
                        $('#forgot-spinner').addClass('d-none');
                        $('#forgot-btn').prop('disabled', false);
                    }
                });
            });

            // Resend Verification Modal Form Submission
            $('#verificationForm').submit(function (e) {
                e.preventDefault();
                const email = $('#verification-email').val().trim();
                if (!validateEmail(email)) {
                    showAlert('verification-alert', 'Please enter a valid email address', 'danger');
                    return;
                }
                $('#verification-btn-text').text('Sending...');
                $('#verification-spinner').removeClass('d-none');
                $('#verification-btn').prop('disabled', true);
                $.ajax({
                    url: 'user/auth/resend_email.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { email: email },
                    success: function (response) {
                        if (response.status === 'success' || response.status === 1) {
                            showAlert('verification-alert', 'Verification link sent to your email', 'success');
                            $('#verificationForm')[0].reset();
                            setTimeout(() => { $('#verificationModal').modal('hide'); }, 2000);
                        } else {
                            showAlert('verification-alert', response.message || 'Failed to send verification link', 'danger');
                        }
                    },
                    error: function () {
                        showAlert('verification-alert', 'An error occurred. Please try again.', 'danger');
                    },
                    complete: function () {
                        $('#verification-btn-text').text('Resend Verification');
                        $('#verification-spinner').addClass('d-none');
                        $('#verification-btn').prop('disabled', false);
                    }
                });
            });

            // Reset Password Form Submission (modal)
            $('#resetPasswordForm').submit(function (e) {
                e.preventDefault();
                const email = $('#reset-email').val();
                const newPassword = $('#reset-new-password').val();
                const confirmPassword = $('#reset-confirm-password').val();
                if (newPassword !== confirmPassword) {
                    showAlert('reset-alert', 'Passwords do not match', 'danger');
                    return;
                }
                if (newPassword.length < 6) {
                    showAlert('reset-alert', 'Password must be at least 6 characters', 'danger');
                    return;
                }
                $('#reset-btn-text').text('Updating...');
                $('#reset-spinner').removeClass('d-none');
                $('#reset-btn').prop('disabled', true);
                $.ajax({
                    url: 'user/auth/reset_password.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        new_password: newPassword
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            showAlert('reset-alert', 'Password updated successfully', 'success');
                            setTimeout(() => {
                                $('#resetPasswordModal').modal('hide');
                                $('#login-email').val(email);
                                $('#login-form').show();
                                $('#register-form').hide();
                            }, 1500);
                        } else {
                            showAlert('reset-alert', response.message || 'Failed to update password', 'danger');
                        }
                    },
                    error: function () {
                        showAlert('reset-alert', 'An error occurred. Please try again.', 'danger');
                    },
                    complete: function () {
                        $('#reset-btn-text').text('Update Password');
                        $('#reset-spinner').addClass('d-none');
                        $('#reset-btn').prop('disabled', false);
                    }
                });
            });

            // Password toggle for reset form
            $('#toggleResetPassword').click(function () {
                const passwordField = $('#reset-new-password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#toggleResetConfirmPassword').click(function () {
                const passwordField = $('#reset-confirm-password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>

    <script>
        // Fetch client ID dynamically
        $(document).ready(function () {
            $.getJSON('get_google_credentials.php', function (data) {
                if (data.client_id) {
                    $('#g_id_onload').attr('data-client_id', data.client_id);
                    google.accounts.id.initialize({
                        client_id: data.client_id,
                        callback: handleCredentialResponse
                    });
                    google.accounts.id.renderButton(
                        document.querySelector('.g_id_signin'),
                        { theme: "outline", size: "large" }  // Optional
                    );
                }
            });
        });

        function handleCredentialResponse(response) {
            $.ajax({
                url: 'google_login_handler.php',
                method: 'POST',
                data: {
                    credential: response.credential
                },
                success: function (res) {
                    try {
                        const result = typeof res === "string" ? JSON.parse(res) : res;

                        if (result.success) {
                            showAlert('login-alert', 'Login successful!', 'success');
                            setTimeout(() => {
                                window.location.href = result.redirect || 'user/';
                            }, 300);
                        } else {
                            console.error("Google login failed:", result.error || result);
                            showAlert('login-alert', result.error || 'Login failed!', 'danger');
                        }
                    } catch (e) {
                        console.error("Error parsing response:", e, res);
                        showAlert('login-alert', 'Unexpected server response.', 'danger');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    console.error("Response text:", xhr.responseText);
                    showAlert('login-alert', 'Network error. Please try again.', 'danger');
                }
            });
        }
        function showAlert(containerId, message, type) {
            const alert = $('#' + containerId);
            alert.removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-' + type);
            alert.text(message);
            setTimeout(() => {
                alert.addClass('d-none');
            }, 3000);
        }



    </script>
</body>

</html>