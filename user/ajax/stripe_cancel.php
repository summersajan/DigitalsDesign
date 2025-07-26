<?php
// Start output buffering to ensure headers work properly
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="refresh" content="2;url=../../index.php">
    <title>Payment Cancelled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding-top: 100px;
        }

        .message {
            font-size: 20px;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="message">
        Payment was cancelled. Redirecting to homepage...
    </div>
</body>

</html>
<?php
ob_end_flush();
?>