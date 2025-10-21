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

    $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      'username' => $username,
      'email' => $email,
      'password_hash' => $password
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

  public function loginUser(string $email, string $password): ?array
  {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
      // Contraseña correcta
      return $user;
    }

    // Usuario no encontrado o contraseña incorrecta
    return null;
  }
}
