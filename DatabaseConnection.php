<?php

require_once 'config.php';

$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    $response['errors'] = ['Server error. Please try again later.'];
    $response['code'] = 500;
    echo json_encode($response);
    die();
}
