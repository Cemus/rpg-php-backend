<?php
namespace Routes;

use Config\Router;

$router = Router::getInstance();

$router->add('GET', '/profile', function () {

    $token = $_COOKIE['token'] ?? null;
    error_log("token : $token");

    header('Content-Type: application/json');

    if (!$token) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
        return;
    }

    try {
        $payload = \Helpers\JWTHelper::validateJWT($token);
        echo json_encode([
            'status' => 'ok',
            'user' => [
                'id' => $payload->sub,
                'username' => $payload->username
            ]
        ]);
    } catch (\Exception $e) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    }
}, []);