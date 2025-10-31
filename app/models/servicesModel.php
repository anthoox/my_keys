<?php
require_once __DIR__ . '/../entities/Service.php';
/**
 * TODO mostrar los errores en pantalla si es necesario
 */
class ServicesModel
{
  private $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }


  /**
   * Crea un nuevo servicio en la base de datos
   * 
   * @param int $user_id ID del usuario propietario
   * @param string $service_name Nombre del servicio
   * @param string|null $category Categoría (puede ser nula)
   * @param string|null $notes Notas adicionales (puede ser nula)
   * @return int|false Devuelve el ID del servicio creado o false si falla
   */
  public function createService($user_id, $service_name, $category = null, $notes = null)
  {

    try {
      $sql = "INSERT INTO services (user_id, name, category_id, notes) 
                VALUES (:user_id, :name, :category_id, :notes)";

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':name', $service_name, PDO::PARAM_STR);
      $stmt->bindParam(':category_id', $category, PDO::PARAM_INT);
      $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);

      if ($stmt->execute()) {
        return $this->db->lastInsertId();
      }
      return false;
    } catch (PDOException $e) {
      error_log("Error al crear servicio: " . $e->getMessage());
      return false;
    }
  }


  /**
   * Obtiene todos los servicios del usuario
   */
  public function getServicesByUser($user_id)
  {
    try {
      $stmt = $this->db->prepare("
            SELECT s.*,c.updated_at, c.password_encrypted, c.username
            FROM services s
            LEFT JOIN credentials c ON s.id = c.service_id
            WHERE s.user_id = :user_id
            ORDER BY s.created_at DESC
        ");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();

      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $services = [];
      foreach ($rows as $row) {
        // var_dump($row);
        $services[] = new Service(
          $row['id'],
          $row['user_id'],
          $row['category_id'] ?? '',
          $row['name'],
          $row['notes'] ?? null,
          $row['created_at'] ?? null,
          $row['updated_at'] ?? null,
          $row['username'] ?? null
        );
      }
      return $services;
    } catch (PDOException $e) {
      error_log("Error al obtener servicios: " . $e->getMessage());
      return [];
    }
  }

  public function delService(int $service_id): bool
  {
    try {
      // Primero eliminamos las credenciales asociadas
      $stmt_cred = $this->db->prepare("DELETE FROM credentials WHERE service_id = :service_id");
      $stmt_cred->bindParam(':service_id', $service_id, PDO::PARAM_INT);
      $stmt_cred->execute();
      var_dump($stmt_cred);

      // Luego eliminamos el servicio
      $stmtServ = $this->db->prepare("DELETE FROM services WHERE id = :id");
      $stmtServ->bindParam(':id', $service_id, PDO::PARAM_INT);
      return $stmtServ->execute();
    } catch (PDOException $e) {
      error_log("Error al eliminar servicio: " . $e->getMessage());
      return false;
    }
  }

  public function editService(int $service_id, string $service_name, string $username, ?string $password = null): bool
  {
    try {
      // Iniciamos la transacción
      $this->db->beginTransaction();

      // 1) Actualizar el nombre del servicio en la tabla services
      $sql_service = "UPDATE services SET name = :name WHERE id = :id";
      $stmt_service = $this->db->prepare($sql_service);
      $stmt_service->execute([
        'name' => $service_name,
        'id'   => $service_id
      ]);

      // 2) Actualizar credenciales asociadas (username, password_encrypted, updated_at)
      $now = date('Y-m-d H:i:s');

      if (!empty($password)) {
        // Si se envía nueva contraseña, hashearla
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sqlCred = "UPDATE credentials
                        SET username = :username,
                            password_encrypted = :password_encrypted,
                            updated_at = :updated_at
                        WHERE service_id = :service_id";
        $stmtCred = $this->db->prepare($sqlCred);
        $stmtCred->execute([
          'username'           => $username,
          'password_encrypted' => $password_hash,
          'updated_at'         => $now,
          'service_id'         => $service_id
        ]);
      } else {
        // Solo actualizar username y fecha si no hay nueva password
        $sqlCred = "UPDATE credentials
                        SET username = :username,
                            updated_at = :updated_at
                        WHERE service_id = :service_id";
        $stmtCred = $this->db->prepare($sqlCred);
        $stmtCred->execute([
          'username'   => $username,
          'updated_at' => $now,
          'service_id' => $service_id
        ]);
      }

      // 3) Si no existía fila de credentials (affectedRows == 0), insertar una nueva fila
      //    Esto cubre el caso en que antes no había credenciales asociadas.
      if ($stmtCred->rowCount() === 0) {
        // Insertar nueva credencial (si no existe)
        $insertSql = "INSERT INTO credentials (service_id, username, password_encrypted, updated_at)
                          VALUES (:service_id, :username, :password_encrypted, :updated_at)";
        $stmtIns = $this->db->prepare($insertSql);
        $stmtIns->execute([
          'service_id'         => $service_id,
          'username'           => $username,
          'password_encrypted' => !empty($password) ? $password_hash : null,
          'updated_at'         => $now
        ]);
      }

      $this->db->commit();
      return true;
    } catch (PDOException $e) {
      $this->db->rollBack();
      error_log("Error en editService: " . $e->getMessage());
      return false;
    }
  }
}