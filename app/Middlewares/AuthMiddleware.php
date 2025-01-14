<?php

namespace App\Middlewares;

use App\Helpers\JwtHelper;

class AuthMiddleware
{
  public static function verifyToken(): int
  {
    $headers = getallheaders();
    $tokenHeader = $headers['Authorization'] ?? '';
    $token = str_replace('Bearer ', '', $tokenHeader);

    if (!$token) {
      http_response_code(401);
      echo json_encode(["error" => "Token no proporcionado"]);
      exit;
    }

    $userId = JwtHelper::validateToken($token);

    if (!$userId) {
      http_response_code(401);
      echo json_encode(["error" => "Token inválido o expirado"]);
      exit;
    }

    return $userId;
  }
}
