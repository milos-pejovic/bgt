<?php

require_once 'DatabaseConnection.php';

$stmt = $pdo->prepare("SELECT * FROM `users`;");
$stmt->execute();
$response['data'] = $stmt->fetchAll();
$response['code'] = 200;

echo json_encode($response);
die();
