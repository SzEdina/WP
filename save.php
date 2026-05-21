<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "chat_app";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"];
$message = $data["message"];

$sql = "INSERT INTO messages (username, message) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $message);

$stmt->execute();

echo json_encode([
    "success" => true
]);

$conn->close();

?>