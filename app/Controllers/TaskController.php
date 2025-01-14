<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\TaskModel;
use App\Middlewares\AuthMiddleware;

class TaskController extends BaseController
{
  public function getAll(Request $request): void
  {
    $userId = AuthMiddleware::verifyToken();
    $model = new TaskModel();
    $tasks = $model->getTasksByUser($userId);

    echo json_encode($tasks);
  }

  public function create(Request $request): void
  {
    $userId = AuthMiddleware::verifyToken();
    $data = $request->getJsonBody();

    $title = $this->sanitizeString($data['title'] ?? '');
    $description = $this->sanitizeString($data['description'] ?? '');
    $dueDate = $this->sanitizeString($data['due_date'] ?? '');
    $status = $this->sanitizeString($data['status'] ?? 'pendiente');

    if (!$title || !$dueDate) {
      http_response_code(400);
      echo json_encode(["error" => "Datos de tarea incompletos"]);
      return;
    }

    $model = new TaskModel();
    $success = $model->createTask($title, $description, $dueDate, $status, $userId);

    if ($success) {
      http_response_code(201);
      echo json_encode(["message" => "Tarea creada exitosamente"]);
    } else {
      http_response_code(500);
      echo json_encode(["error" => "No se pudo crear la tarea"]);
    }
  }

  public function update(Request $request): void
  {
    $userId = AuthMiddleware::verifyToken();
    $data = $request->getJsonBody();
    $taskId = (int) ($data['id'] ?? 0);

    $title = $this->sanitizeString($data['title'] ?? '');
    $description = $this->sanitizeString($data['description'] ?? '');
    $dueDate = $this->sanitizeString($data['due_date'] ?? '');
    $status = $this->sanitizeString($data['status'] ?? 'pendiente');

    if (!$taskId || !$title) {
      http_response_code(400);
      echo json_encode(["error" => "Datos de tarea incompletos"]);
      return;
    }

    $model = new TaskModel();
    $updated = $model->updateTask($taskId, $title, $description, $dueDate, $status, $userId);

    if ($updated) {
      http_response_code(200);
      echo json_encode(["message" => "Tarea actualizada correctamente"]);
    } else {
      http_response_code(400);
      echo json_encode(["error" => "No se pudo actualizar la tarea"]);
    }
  }

  public function delete(Request $request): void
  {
    $userId = AuthMiddleware::verifyToken();
    $data = $request->getJsonBody();
    $taskId = (int) ($data['id'] ?? 0);

    if (!$taskId) {
      http_response_code(400);
      echo json_encode(["error" => "ID de tarea inválido"]);
      return;
    }

    $model = new TaskModel();
    $deleted = $model->deleteTask($taskId, $userId);

    if ($deleted) {
      http_response_code(200);
      echo json_encode(["message" => "Tarea eliminada correctamente"]);
    } else {
      http_response_code(400);
      echo json_encode(["error" => "No se pudo eliminar la tarea"]);
    }
  }
}
