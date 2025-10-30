<?php
require_once __DIR__ . '/../entities/Service.php';
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

  public function delService(int $serviceId): bool
  {
    try {
      // Primero eliminamos las credenciales asociadas
      $stmtCred = $this->db->prepare("DELETE FROM credentials WHERE service_id = :service_id");
      $stmtCred->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
      $stmtCred->execute();
      var_dump($stmtCred);

      // Luego eliminamos el servicio
      $stmtServ = $this->db->prepare("DELETE FROM services WHERE id = :id");
      $stmtServ->bindParam(':id', $serviceId, PDO::PARAM_INT);
      return $stmtServ->execute();
    } catch (PDOException $e) {
      error_log("Error al eliminar servicio: " . $e->getMessage());
      return false;
    }
  }
}