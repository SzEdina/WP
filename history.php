<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "chat_app";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, message, sent_at 
        FROM messages 
        ORDER BY id DESC 
        LIMIT 50";

$result = $conn->query($sql);

$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(array_reverse($messages));

$conn->close();

?>