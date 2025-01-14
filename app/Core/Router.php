<?php

namespace App\Core;

use App\Core\Request;

class Router
{
  private array $routes = [];

  public function get(string $path, callable|array $callback)
  {
    $this->routes['GET'][$path] = $callback;
  }

  public function post(string $path, callable|array $callback)
  {
    $this->routes['POST'][$path] = $callback;
  }

  public function put(string $path, callable|array $callback)
  {
    $this->routes['PUT'][$path] = $callback;
  }

  public function delete(string $path, callable|array $callback)
  {
    $this->routes['DELETE'][$path] = $callback;
  }

  public function dispatch()
  {
    $request = new Request();
    $method = $request->getMethod();
    $uri = $request->getPath();

    if (isset($this->routes[$method][$uri])) {
      $callback = $this->routes[$method][$uri];
      if (is_array($callback)) {
        $controller = new $callback[0]();
        $methodController = $callback[1];
        call_user_func([$controller, $methodController], $request);
      } else {
        call_user_func($callback, $request);
      }
    } else {
      // Manejo de rutas dinámicas o 404
      header("HTTP/1.0 404 Not Found");
      echo json_encode(["error" => "Ruta no encontrada"]);
      exit;
    }
  }
}
