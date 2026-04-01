<?php
namespace Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    public static function generateJWT(int $userId, string $username): string
    {
        $payload = [
            'sub' => $userId,
            'username' => $username,
            'iat' => time(),
            'exp' => time() + 3600
        ];

        $secret = $_ENV['JWT_SECRET'] ?? 'change_me';

        return JWT::encode($payload, $secret, 'HS256');
    }

    public static function validateJWT(string $token)
    {
        $secret = $_ENV['JWT_SECRET'] ?? 'change_me';
        return JWT::decode($token, new Key($secret, 'HS256'));
    }
}