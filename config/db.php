<?php
$isLocalhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

if ($isLocalhost) {
    header('Content-Type: application/json');
    ini_set('display_errors', 1); // Change to 0 in production
    error_reporting(E_ALL);
} else {
    header('Content-Type: application/json');
    ini_set('display_errors', 1); // Change to 0 in production
    error_reporting(E_ALL);
}


// Manually load environment variables (optional fallback)
function loadEnv($path)
{
    if (!file_exists($path))
        return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '='))
            continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}


require_once __DIR__ . '/../vendor/autoload.php';
loadEnv(__DIR__ . '/../.env');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Connect to DB securely
$mysqli = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME')
);

if ($mysqli->connect_errno) {
    http_response_code(500);
    exit(json_encode(['error' => 'DB connection failed']));
}

$mysqli->set_charset("utf8mb4");

// Set headers & errors (for development only)



// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usercode = isset($_SESSION['user_digital_product']) ? $_SESSION['user_digital_product'] : null;

$google_client_id = getenv('GOOGLE_CLIENT_ID');
$google_auth_api_key = getenv('GOOGLE_AUTH_API_KEY');

$mail_url = getenv(name: 'MAIL_URL');



?>