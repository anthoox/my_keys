<?php

class AuthModel
{
  private $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  public function emailExists(string $email): bool
  {
    $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['email' => $email]);
    return (bool)$stmt->fetchColumn();
  }

  public function createUser(string $username, string $email, string $password): bool
  {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      'username' => $username,
      'email' => $email,
      'password' => $hash
    ]);
  }

  public function getUserByEmail(string $email): ?array
  {
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
  }
}
