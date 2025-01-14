<?php

namespace App\Models;

use PDO;

class UserModel extends BaseModel
{
  
  public function createUser(string $name, string $email, string $hashedPassword): bool
  {
    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':password' => $hashedPassword
    ]);
  }

  public function getUserByEmail(string $email): ?array
  {
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
  }

  public function getUserById(int $id): ?array
  {
    $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
  }
}
