<?php
namespace Middlewares;

use Config\Request;
use Helpers\JWTHelper;

class AuthMiddleware
{
    public static function handle(Request $request): bool
    {
        $token = $_COOKIE['token'] ?? null;
        error_log("Token reçu : " . ($token ?? 'null'));

        if (!$token) {
            http_response_code(401);
            return false;
        }

        try {
            $payload = JWTHelper::validateJWT($token);

            $request->user = $payload;
            error_log('' . json_encode($payload));
            error_log(print_r($request->user, true));

            return true;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
            return false;
        }
    }
}
