<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'chat_app';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        $data = $_POST;
    }

    if (!empty($data['username']) && !empty($data['message'])) {

        $user = htmlspecialchars(strip_tags($data['username']));
        $msg = htmlspecialchars(strip_tags($data['message']));

        $stmt = $pdo->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");

        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':message', $msg);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'poruka je sacuvana']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'greska pri cuvanju poruke']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'korisnicko ime i poruka su obavezni']);
    }

} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'greska sa bazom: ' . $e->getMessage()]);
}
?>