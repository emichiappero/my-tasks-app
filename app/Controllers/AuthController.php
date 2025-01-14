<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\UserModel;
use App\Helpers\JwtHelper;

class AuthController extends BaseController
{
  public function register(Request $request): void
  {
    $body = $request->getJsonBody();
    $name = $this->sanitizeString($body['name'] ?? '');
    $email = filter_var($this->sanitizeString($body['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = $this->sanitizeString($body['password'] ?? '');

    if (!$name || !$email || !$password) {
      http_response_code(400);
      echo json_encode(["error" => "Datos incompletos o inválidos"]);
      return;
    }

    // Hashear la contraseña 
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $userModel = new UserModel();
    $existingUser = $userModel->getUserByEmail($email);

    if ($existingUser) {
      http_response_code(409);
      echo json_encode(["error" => "El correo ya está registrado"]);
      return;
    }

    $userCreated = $userModel->createUser($name, $email, $hashedPassword);

    if ($userCreated) {
      http_response_code(201);
      echo json_encode(["message" => "Usuario registrado correctamente"]);
    } else {
      http_response_code(500);
      echo json_encode(["error" => "No se pudo crear el usuario"]);
    }
  }

  public function login(Request $request): void
  {
    $body = $request->getJsonBody();
    $email = filter_var($body['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $body['password'] ?? '';

    if (!$email || !$password) {
      http_response_code(400);
      echo json_encode(["error" => "Datos incompletos"]);
      return;
    }

    try {
      $userModel = new UserModel();
      $user = $userModel->getUserByEmail($email);

      if ($user && password_verify($password, $user['password'])) {
        $token = JwtHelper::generateToken($user['id']);
        echo json_encode([
          "message" => "Inicio de sesión exitoso",
          "token" => $token
        ]);
      } else {
        http_response_code(401);
        echo json_encode(["error" => "Credenciales inválidas"]);
      }
    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => "Error interno del servidor"]);
    }
  }


  public function refresh(Request $request): void
  {
    $headers = getallheaders();
    $tokenHeader = $headers['Authorization'] ?? '';
    $token = str_replace('Bearer ', '', $tokenHeader);

    if (!$token) {
      http_response_code(401);
      echo json_encode(["error" => "Token no proporcionado"]);
      return;
    }

    $newToken = JwtHelper::refreshToken($token);
    if ($newToken) {
      echo json_encode([
        "message" => "Token renovado exitosamente",
        "token" => $newToken
      ]);
    } else {
      http_response_code(401);
      echo json_encode(["error" => "Token inválido o expirado"]);
    }
  }
}
