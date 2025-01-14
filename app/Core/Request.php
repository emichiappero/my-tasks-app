<?php

namespace App\Core;

class Request
{
  public function getMethod(): string
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getPath(): string
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $parsedUrl = parse_url($uri);
    return $parsedUrl['path'] ?? '/';
  }

  /**
   * Retorna los datos JSON del body si existen, o un array vacío.
   */
  public function getJsonBody(): array
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    return is_array($data) ? $data : [];
  }

  /**
   * Retorna parámetros GET sanitizados.
   */
  public function getQueryParams(): array
  {
    $params = [];
    foreach ($_GET as $key => $value) {
      // Sanitizar parámetros
      $params[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $params;
  }
}
