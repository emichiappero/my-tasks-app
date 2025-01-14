<?php

namespace App\Models;

use PDO;

class TaskModel extends BaseModel
{
  public function createTask(string $title, string $description, string $dueDate, string $status, int $userId): bool
  {
    $sql = "INSERT INTO tasks (title, description, due_date, status, user_id)
                VALUES (:title, :description, :due_date, :status, :user_id)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      ':title' => $title,
      ':description' => $description,
      ':due_date' => $dueDate,
      ':status' => $status,
      ':user_id' => $userId
    ]);
  }

  public function getTasksByUser(int $userId): array
  {
    $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':user_id' => $userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getTaskById(int $id, int $userId): ?array
  {
    $sql = "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id,
      ':user_id' => $userId
    ]);

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    return $task ?: null;
  }

  public function updateTask(int $id, string $title, string $description, string $dueDate, string $status, int $userId): bool
  {
    $sql = "UPDATE tasks
                SET title = :title,
                    description = :description,
                    due_date = :due_date,
                    status = :status
                WHERE id = :id AND user_id = :user_id";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
      ':title' => $title,
      ':description' => $description,
      ':due_date' => $dueDate,
      ':status' => $status,
      ':id' => $id,
      ':user_id' => $userId
    ]);
  }

  public function deleteTask(int $id, int $userId): bool
  {
    $sql = "DELETE FROM tasks WHERE id = :id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
      ':id' => $id,
      ':user_id' => $userId
    ]);
  }
}
