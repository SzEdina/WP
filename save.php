<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'chat_app';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Set charset
$conn->set_charset('utf8mb4');

// Get POST data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($username)) {
    http_response_code(400);
    echo json_encode(['error' => 'Username is required']);
    exit();
}

if (empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit();
}git 

// Limit lengths
$username = substr($username, 0, 100);
$message = substr($message, 0, 1000);

// Prepare and execute statement to insert message
$stmt = $conn->prepare('INSERT INTO messages (username, messages, sent_at) VALUES (?, ?, NOW())');

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => $conn->error]);
    exit();
}

$stmt->bind_param('ss', $username, $message);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Message saved successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
