<?php
require_once __DIR__ . '/../entities/User.php';
require_once __DIR__ . '/../../core/database/DataBase.php';
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

  public function changeUserPassword(int $user_id, string $old_password, string $new_password): bool
  {
    try {
      // 1️⃣ Obtener la contraseña actual del usuario
      $sql = "SELECT password_hash FROM users WHERE id = :id LIMIT 1";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(['id' => $user_id]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        return false; // Usuario no encontrado
      }

      // 2️⃣ Verificar la contraseña actual
      if (!password_verify($old_password, $user['password_hash'])) {
        return false; // Contraseña incorrecta
      }

      // 3️⃣ Generar nuevo hash de la contraseña
      $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

      // 4️⃣ Actualizar la contraseña
      $update_sql = "UPDATE users SET password_hash = :new_hash WHERE id = :id";
      $update_stmt = $this->db->prepare($update_sql);
      $update_stmt->execute([
        'new_hash' => $new_hash,
        'id' => $user_id
      ]);

      return $update_stmt->rowCount() > 0;
    } catch (PDOException $e) {
      error_log("Error al cambiar contraseña: " . $e->getMessage());
      return false;
    }
  }
}