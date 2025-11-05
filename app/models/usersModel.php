<?php
require_once __DIR__ . '/../entities/User.php';
/**
 * TODO mostrar los errores en pantalla si es necesario
 */

class usersModel{

  private $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  public function getUserData($user_id): mixed{

    try {
      $stmt = $this->db->prepare(
        "
      SELECT * from users WHERE id = :user_id LIMIT 1"
      );
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row) {
        $user_data = new User(
          $row['id'],
          $row['username'],
          $row['email'],
          $row['password_hash'],
          $row['created_at']
        );
      } else {
        $user_data = null; // No se encontró usuario
      }

      // var_dump($user_data); // Para debug
      // die();

      return $user_data;
    } catch (PDOException $e) {
      error_log("Error al obtener servicios: " . $e->getMessage());

      return [];
    }
  }

  public function editUserData(int $user_id, ?string $user_name = null, ?string $email = null): bool
  {
    try {
      $this->db->beginTransaction();

      // Armamos dinámicamente la consulta dependiendo de qué valores vengan
      $fields = [];
      $params = ['id' => $user_id];

      if (!empty($user_name)) {
        $fields[] = "username = :username";
        $params['username'] = $user_name;
      }

      if (!empty($email)) {
        $fields[] = "email = :email";
        $params['email'] = $email;
      }

      // Si no hay campos para actualizar, salimos
      if (empty($fields)) {
        $this->db->rollBack();
        return false;
      }

      $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
      $stmt = $this->db->prepare($sql);
      $result = $stmt->execute($params);

      $this->db->commit();

      return $result;
    } catch (PDOException $e) {
      $this->db->rollBack();
      error_log("Error en editUserData: " . $e->getMessage());
      return false;
    }
  }
}