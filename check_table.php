<?php
$conn = new mysqli('localhost', 'root', '', 'chat_app');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query("DESCRIBE messages");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}
echo json_encode($columns);
$conn->close();
?>
