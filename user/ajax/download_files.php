<?php
include_once '../../config/db.php';

header("Content-Type: text/html; charset=utf-8");


$order_file_id = intval($_GET['order_file_id'] ?? 0);


if (!$order_file_id || !$usercode) {
    http_response_code(400);
    exit('Invalid file request or not logged in');
}

// 1. Check user owns this file (by orders.usercode and payment status)
$sql = "
SELECT of.*, f.file_url, f.file_type
FROM order_files of
INNER JOIN orders o ON of.order_id = o.order_id
INNER JOIN digital_files f ON of.file_id = f.file_id
WHERE of.order_file_id = ? AND o.usercode = ? AND o.order_status IN ('paid','completed')
LIMIT 1
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('is', $order_file_id, $usercode);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();
$stmt->close();

if (!$file) {
    http_response_code(404);
    exit('File not found or not authorized');
}

// 2. Optional: Validate allowed download count
$max_downloads = 5;
if ($file['download_count'] >= $max_downloads) {
    http_response_code(403);
    exit('Download limit exceeded.');
}

$file_url = $file['file_url'];
$local_path = '../../' . $file_url;

if (!file_exists($local_path)) {
    http_response_code(404);
    exit('File missing: ' . $local_path);
}

// 3. Increment download counter & update timestamp
$update_stmt = $mysqli->prepare("UPDATE order_files SET downloaded = 1, download_count = download_count + 1, last_downloaded = NOW() WHERE order_file_id = ?");
$update_stmt->bind_param('i', $order_file_id);
$update_stmt->execute();
$update_stmt->close();

// 4. Serve the file securely
$filetype = $file['file_type'];
$filename = basename($file_url);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream'); // or use $filetype if specific
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($local_path));
readfile($local_path);
exit;
?>