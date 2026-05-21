<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'chat_app';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT id, username, message, sent_at FROM messages ORDER BY id DESC LIMIT 50");
    $stmt->execute();

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $messages = array_reverse($messages);

    echo json_encode($messages);

} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Greska sa bazom: ' . $e->getMessage()]);
}
?>