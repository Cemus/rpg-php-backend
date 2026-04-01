<?php

$allowedOrigin = 'http://localhost:4200';
header("Access-Control-Allow-Origin: $allowedOrigin");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');

header('Access-Control-Max-Age: 86400');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}