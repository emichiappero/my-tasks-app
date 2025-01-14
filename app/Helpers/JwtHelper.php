<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
  public static function generateToken(int $userId): string
  {
    $secret = $_ENV['JWT_SECRET'] ?? 'secret-key';
    $expire = (int) ($_ENV['JWT_EXPIRE'] ?? 3600);

    $payload = [
      'iss' => 'http://localhost',
      'aud' => 'http://localhost',
      'iat' => time(),
      'exp' => time() + $expire,
      'data' => [
        'userId' => $userId
      ]
    ];

    return JWT::encode($payload, $secret, 'HS256');
  }

  public static function validateToken(string $token): ?int
  {
    try {
      $secret = $_ENV['JWT_SECRET'] ?? 'secret-key';
      $decoded = JWT::decode($token, new Key($secret, 'HS256'));
      return $decoded->data->userId ?? null;
    } catch (\Exception $e) {
      return null;
    }
  }

  public static function refreshToken(string $oldToken): ?string
  {
    try {
      $secret = $_ENV['JWT_SECRET'] ?? 'secret-key';
      $refreshExpire = (int) ($_ENV['JWT_REFRESH_EXPIRE'] ?? 7200);

      $decoded = JWT::decode($oldToken, new Key($secret, 'HS256'));
      $decoded->iat = time();
      $decoded->exp = time() + $refreshExpire;

      return JWT::encode($decoded, $secret, 'HS256');
    } catch (\Exception $e) {
      return null;
    }
  }
}
