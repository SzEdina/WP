<?php
header('Content-Type: application/json');
require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_encode(['success' => false,'message' => 'Method not allowed']);
    exit;
}
$data=json_decode(file_get_contents("php://input"),true);
if($data == null){
    http_response_code(400);
    echo json_encode(['success' => false,'message' => 'Invalid JSON']);
    exit;
}
$username = trim($data['username'] ?? '');
$message=trim($data['message']??'');
if($username===''||$message===''){
    http_response_code(400);
    echo json_encode(['success' => false,'message' => 'Invalid username or message']);
    exit;
}
try{
    $pdo=getConnection();
    $stmt = $pdo->prepare('INSERT INTO messages (username, message) VALUES (:username, :message)');
$stmt->execute([':username'=>$username,':message'=>$message]);
echo json_encode(['success' => true,'message'=>'Message saved']);
}catch(PDOException $e){
    error_log('DB error in save.php:'.$e->getMessage());
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Coult not save message']);
}

