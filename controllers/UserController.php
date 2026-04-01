<?php
namespace Controllers;

use Models\User;
use Helpers\JWTHelper;

class UserController
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Username and password required']);
            return;
        }

        try {
            $userId = $this->userModel->create($username, $password);

            $jwt = JWTHelper::generateJWT($userId, $username);

            setcookie("token", $jwt, [
                "httponly" => true,
                "secure" => false, // E N  D E V
                "path" => "/",
                "samesite" => "Lax",
                "expires" => time() + 3600
            ]);

            echo json_encode(['status' => 'ok', 'message' => 'User created']);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function login()
    {
        header('Content-Type: application/json');

        $token = $_COOKIE['token'] ?? null;
        if (!$token) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
            return;
        }

        try {
            $payload = JWTHelper::validateJWT($token);
            echo json_encode([
                'status' => 'ok',
                'message' => 'Authenticated',
                'user' => [
                    'id' => $payload->sub,
                    'username' => $payload->username
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }

    public function profile()
    {
        header('Content-Type: application/json');

        $token = $_COOKIE['token'] ?? null;
        if (!$token) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
            return;
        }

        try {
            $payload = JWTHelper::validateJWT($token);
            echo json_encode([
                'status' => 'ok',
                'message' => 'Authenticated',
                'user' => [
                    'id' => $payload->sub,
                    'username' => $payload->username
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
}