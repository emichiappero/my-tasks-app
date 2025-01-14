<?php

use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Core\Application;

$app = new Application();

// Rutas públicas
$app->router->post(path: '/register', callback: [AuthController::class, 'register']);
$app->router->post(path: '/login', callback: [AuthController::class, 'login']);
$app->router->get(path: '/refresh', callback: [AuthController::class, 'refresh']);

// Rutas protegidas (CRUD)
$app->router->get(path: '/tasks', callback: [TaskController::class, 'getAll']);
$app->router->post(path: '/tasks', callback: [TaskController::class, 'create']);
$app->router->put(path: '/tasks', callback: [TaskController::class, 'update']);
$app->router->delete(path: '/tasks', callback: [TaskController::class, 'delete']);

// Ejecutar la aplicación
$app->run();
