<?php

declare(strict_types=1);

require_once __DIR__ . '/../entities/User.php';
require_once __DIR__ . '/../../core/database/DataBase.php';

/**
 * Modelo para manejar operaciones relacionadas con los usuarios
 * 
 * Mejora respecto a la versión anterior:
 * - Tipado estricto
 * - Uso consistente de prepared statements
 * - Transacciones solo cuando es necesario
 * - Manejo de errores mediante logs
 * - Cumplimiento de PSR-12 (nombres y estilo)
 */
class UsersModel
{
  private PDO $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  /**
   * Obtener los datos de un usuario por su ID
   * 
   * @param int $user_id ID del usuario
   * @return User|null Devuelve un objeto User si se encuentra, null si no
   */
  public function getUserData(int $user_id): ?User
  {
    try {
      $stmt = $this->db->prepare(
        "SELECT * FROM users WHERE id = :user_id LIMIT 1"
      );
      $stmt->execute(['user_id' => $user_id]);

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row) {
        return new User(
          (int)$row['id'],
          $row['username'],
          $row['email'],
          $row['created_at']
        );
      }

      return null;
    } catch (PDOException $e) {
      error_log("Error al obtener datos de usuario: " . $e->getMessage());
      return null;
    }
  }

  /**
   * Actualiza los datos del usuario de forma dinámica
   *
   * @param int $user_id ID del usuario
   * @param string|null $user_name Nuevo nombre de usuario (opcional)
   * @param string|null $email Nuevo correo electrónico (opcional)
   * @return bool Devuelve true si se actualizaron los datos, false en caso contrario
   */
  public function editUserData(int $user_id, ?string $user_name = null, ?string $email = null): bool
  {
    try {
      // Validación básica
      if ($user_name !== null && strlen($user_name) > 50) {
        throw new InvalidArgumentException("El nombre de usuario es demasiado largo");
      }
      if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Email no válido");
      }

      // Construir dinámicamente los campos a actualizar
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

      if (empty($fields)) {
        return false; // No hay campos para actualizar
      }

      $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
      $stmt = $this->db->prepare($sql);

      return $stmt->execute($params);
    } catch (PDOException $e) {
      error_log("Error en editUserData (DB): " . $e->getMessage());
      return false;
    } catch (InvalidArgumentException $e) {
      error_log("Error en editUserData (Validación): " . $e->getMessage());
      return false;
    }
  }


  /**
   * Cambiar la contraseña de un usuario
   * 
   * @param int $user_id ID del usuario
   * @param string $old_password Contraseña actual
   * @param string $new_password Nueva contraseña
   * @return bool True si se actualizó correctamente, false si falla
   */
  public function changeUserPassword(int $user_id, string $old_password, string $new_password): bool
  {
    try {
      // Obtener hash actual de la contraseña
      $stmt = $this->db->prepare("SELECT password_hash FROM users WHERE id = :id LIMIT 1");
      $stmt->execute(['id' => $user_id]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) return false;

      // Verificar contraseña actual
      if (!password_verify($old_password, $user['password_hash'])) return false;

      // Generar nuevo hash
      $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

      // Actualizar contraseña
      $update_stmt = $this->db->prepare(
        "UPDATE users SET password_hash = :new_hash WHERE id = :id"
      );
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

  /**
   * Elimina (da de baja) a un usuario de la base de datos
   *
   * @param int $user_id
   * @return bool True si se eliminó correctamente, false si falló
   */
  public function deleteUser(int $user_id): bool
  {
    try {
      $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
      $stmt->execute(['id' => $user_id]);

      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      error_log("Error al eliminar usuario: " . $e->getMessage());
      return false;
    }
  }
}
