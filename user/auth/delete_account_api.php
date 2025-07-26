<?php

include '../config/db_defaults.php';



// Get and sanitize input data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Don't sanitize passwords

// Validate inputs
if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email Required']);
    exit;
}
if (empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email Required']);
    exit;
}

// Check if user exists and password is correct
$stmt = $conn->prepare("SELECT user_id, password FROM tblusers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

$user = $result->fetch_assoc();

// Verify password (assuming passwords are hashed in the database)
if (!password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Delete user account
$deleteStmt = $conn->prepare("DELETE FROM tblusers WHERE user_id = ?");
$deleteStmt->bind_param("i", $user['user_id']);

if ($deleteStmt->execute()) {
    // You might want to delete related data in other tables here
    echo json_encode(['success' => true, 'message' => 'Account deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete account']);
}

$deleteStmt->close();
$stmt->close();
$conn->close();
?>