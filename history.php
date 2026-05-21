<?php
header ('Content-Type:application/json');
require_once 'config.php';
try{
    $pdo=getConnection();
    $stmt=$pdo->query('SELECT username, message, sent_at FROM messages ORDER BY id DESC LIMIT 50');
    $rows=$stmt->fetchAll();
    $rows=array_reverse($rows);
}
catch(PDOException $e){
    error_log('DB error in history.php:'.$e->getMessage());
    http_response_code(500);
    echo json_encode([]);
}