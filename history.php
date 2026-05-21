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

// Set response header
header('Content-Type: application/json');

// Fetch last 50 messages ordered by id
$query = '
    SELECT id, username, messages, sent_at 
    FROM messages 
    ORDER BY id DESC 
    LIMIT 50
';

$result = $conn->query($query);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => (int)$row['id'],
        'username' => $row['username'],
        'message' => $row['messages'],
        'sent_at' => $row['sent_at']
    ];
}

// Reverse to get chronological order (oldest first)
$messages = array_reverse($messages);

echo json_encode($messages);

$conn->close();
?>
