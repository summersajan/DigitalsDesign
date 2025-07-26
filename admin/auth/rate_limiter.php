<?php
function isRateLimited($conn, $ip_address, $maxAttempts = 5, $minutes = 10)
{
    $now = date('Y-m-d H:i:s');
    $time_limit = date('Y-m-d H:i:s', strtotime("-$minutes minutes"));

    // Log the attempt first
    $log_stmt = $conn->prepare("INSERT INTO registration_logs (ip_address, created_at) VALUES (?, ?)");
    $log_stmt->bind_param("ss", $ip_address, $now);
    $log_stmt->execute();
    $log_stmt->close();

    // Count recent attempts
    $count_stmt = $conn->prepare("SELECT COUNT(*) FROM registration_logs WHERE ip_address = ? AND created_at >= ?");
    $count_stmt->bind_param("ss", $ip_address, $time_limit);
    $count_stmt->execute();
    $count_stmt->bind_result($attempts);
    $count_stmt->fetch();
    $count_stmt->close();

    return $attempts > $maxAttempts;
}
?>