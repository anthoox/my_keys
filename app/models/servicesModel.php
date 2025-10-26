<?php 
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
   * @param int $userId ID del usuario propietario
   * @param string $serviceName Nombre del servicio
   * @param string|null $category Categoría (puede ser nula)
   * @param string|null $notes Notas adicionales (puede ser nula)
   * @return int|false Devuelve el ID del servicio creado o false si falla
   */
  public function createService($userId, $serviceName, $category = null, $notes = null)
  {

    try {
      $sql = "INSERT INTO services (user_id, name, category_id, notes) 
                VALUES (:user_id, :name, :category_id, :notes)";

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->bindParam(':name', $serviceName, PDO::PARAM_STR);
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
  public function getAllByUser($userId)
  {
    try {
      $query = "SELECT * FROM services WHERE user_id = :user_id ORDER BY id DESC";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error al obtener servicios: " . $e->getMessage());
      return [];
    }
  }
}