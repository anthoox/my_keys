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

  public function loginUser(string $email, string $password): ?object
  {
    require_once __DIR__ . '/usersModel.php';
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data && password_verify($password, $data['password_hash'])) {
      $user = new User(
        $data['id'],
        $data['username'],
        $data['email'],
        $data['password_hash'],
        $data['created_at']
      );
      return $user;
    }

    // Usuario no encontrado o contraseña incorrecta
    return null;
  }
}
