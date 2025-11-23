<?php

declare(strict_types=1);

require_once __DIR__ . '/../entities/Service.php';
require_once __DIR__ . '/../entities/Credential.php';
require_once __DIR__ . '/credentialsModel.php';
require_once __DIR__ . '/../../core/database/DataBase.php';

/**
 * Modelo para gestionar los servicios de los usuarios.
 * Incluye creación, actualización, eliminación y consulta de servicios,
 * así como manejo de sus credenciales asociadas.
 */
class ServicesModel
{
  private PDO $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  /**
   * Crea un nuevo servicio
   *
   * @param int $user_id
   * @param string $service_name
   * @param int|null $category_id
   * @param string|null $notes
   * @return int|false ID del servicio creado o false si falla
   */
  public function createService(int $user_id, string $service_name, ?int $category_id = null, ?string $notes = null): int|false
  {
    try {
      $sql = "INSERT INTO services (user_id, name, category_id, notes)
                    VALUES (:user_id, :name, :category_id, :notes)";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':user_id' => $user_id,
        ':name' => $service_name,
        ':category_id' => $category_id,
        ':notes' => $notes
      ]);
      return (int)$this->db->lastInsertId();
    } catch (PDOException $e) {
      error_log("Error al crear servicio: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Obtiene todos los servicios de un usuario
   *
   * @param int $user_id
   * @return Service[]
   */
  public function getServicesByUser(int $user_id): array
  {
    try {
      $stmt = $this->db->prepare("
                SELECT s.*, c.updated_at, c.password_encrypted, c.username
                FROM services s
                LEFT JOIN credentials c ON s.id = c.service_id
                WHERE s.user_id = :user_id
                ORDER BY s.created_at DESC
            ");
      $stmt->execute([':user_id' => $user_id]);

      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $services = [];
      foreach ($rows as $row) {
        $services[] = new Service(
          (int)$row['id'],
          (int)$row['user_id'],
          (string)($row['category_id'] ?? ''),
          (string)$row['name'],
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

  /**
   * Elimina un servicio y sus credenciales asociadas
   *
   * @param int $service_id
   * @return bool
   */
  public function delService(int $service_id): bool
  {
    try {
      $this->db->beginTransaction();

      // Eliminar credenciales asociadas
      $stmtCred = $this->db->prepare("DELETE FROM credentials WHERE service_id = :service_id");
      $stmtCred->execute([':service_id' => $service_id]);

      // Eliminar el servicio
      $stmtServ = $this->db->prepare("DELETE FROM services WHERE id = :id");
      $stmtServ->execute([':id' => $service_id]);

      $this->db->commit();
      return true;
    } catch (PDOException $e) {
      $this->db->rollBack();
      error_log("Error al eliminar servicio: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Edita un servicio y sus credenciales asociadas
   *
   * @param int $service_id
   * @param string $service_name
   * @param string $username
   * @param string|null $password
   * @return bool
   */
  public function editService(int $service_id, string $service_name, string $username, ?string $password = null): bool
  {
    try {
      $this->db->beginTransaction();

      // Actualizar nombre del servicio
      $stmtService = $this->db->prepare("UPDATE services SET name = :name WHERE id = :id");
      $stmtService->execute([':name' => $service_name, ':id' => $service_id]);

      // Actualizar o insertar credencial
      $this->updateCredential($service_id, $username, $password);

      $this->db->commit();
      return true;
    } catch (PDOException $e) {
      $this->db->rollBack();
      error_log("Error al editar servicio: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Comprueba si un servicio pertenece a un usuario
   *
   * @param int $service_id
   * @param int $user_id
   * @return bool
   */
  public function belongsToUser(int $service_id, int $user_id): bool
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM services WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $service_id, ':user_id' => $user_id]);
    return $stmt->fetchColumn() > 0;
  }

  /**
   * Obtiene un servicio por su ID
   *
   * @param int $id
   * @return Service|null
   */
  public function findById(int $id): ?Service
  {
    $stmt = $this->db->prepare("SELECT * FROM services WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    return new Service(
      (int)$row['id'],
      (int)$row['user_id'],
      (string)($row['category_id'] ?? ''),
      (string)$row['name'],
      $row['notes'] ?? null,
      $row['created_at'] ?? null,
      $row['updated_at'] ?? null
    );
  }

  /**
   * Método privado para actualizar o insertar credenciales
   *
   * @param int $service_id
   * @param string $username
   * @param string|null $password
   */
  private function updateCredential(int $service_id, string $username, ?string $password = null): void
  {
    $now = date('Y-m-d H:i:s');
    $password_encrypted = null;

    if (!empty($password)) {
      $credential = new Credential($service_id, $username);
      $credential->setPassword($password);
      $password_encrypted = $credential->getPasswordEncrypted();
    }

    // Intentar actualizar primero. Uso de COALESCE para no sobrescribir contraseña si es null.
    $stmt = $this->db->prepare("
            UPDATE credentials
            SET username = :username,
                password_encrypted = COALESCE(:password_encrypted, password_encrypted),
                updated_at = :updated_at
            WHERE service_id = :service_id
        ");
    $stmt->execute([
      ':username' => $username,
      ':password_encrypted' => $password_encrypted,
      ':updated_at' => $now,
      ':service_id' => $service_id
    ]);

    // Insertar si no existía
    if ($stmt->rowCount() === 0) {
      $stmtIns = $this->db->prepare("
                INSERT INTO credentials (service_id, username, password_encrypted, updated_at)
                VALUES (:service_id, :username, :password_encrypted, :updated_at)
            ");
      $stmtIns->execute([
        ':service_id' => $service_id,
        ':username' => $username,
        ':password_encrypted' => $password_encrypted,
        ':updated_at' => $now
      ]);
    }
  }
}
