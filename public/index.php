<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/./cors.php';


use Config\Database;
use Config\Router;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$db = new Database();
try {
    $pdo = Database::connect();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "down",
        "message" => $e->getMessage()
    ]);
    exit;
}

foreach (glob(__DIR__ . '/../routes/*.php') as $filePath) {
    require_once $filePath;
}


$connectionStatus = [
    "status" => "ok",
    "message" => "Database connected"
];


Router::getInstance()->dispatch();

?>