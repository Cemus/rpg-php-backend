<?php
namespace Controllers;

use Repositories\UserRepository;
use Helpers\JWTHelper;
use Services\UserService;

class UserController
{
    private $userRepository;
    private $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
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
            $userId = $this->userRepository->create($username, $password);

            $jwt = JWTHelper::generateJWT($userId);

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

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        try {
            $userId = $this->userRepository->verify($username, $password);

            $jwt = JWTHelper::generateJWT($userId);

            setcookie("token", $jwt, [
                "httponly" => true,
                "secure" => false, // E N  D E V
                "path" => "/",
                "samesite" => "Lax",
                "expires" => time() + 3600
            ]);

            echo json_encode(['status' => 'ok', 'message' => "$username authenticated"]);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getProfile($request)
    {
        header('Content-Type: application/json');

        try {

            $userInfos = $this->userService->getUserInfos($request->user->sub);
            error_log((string) json_encode($userInfos));
            echo json_encode([
                'status' => 'ok',
                'message' => 'Authenticated',
                'data' => $userInfos
            ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}