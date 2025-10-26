<?php
class CredentialsModel
{
  private $db;

  public function __construct()
  {
    // Obtenemos la conexión PDO desde la clase DataBase
    $this->db = DataBase::getInstance()->getConnection();
  }
  /**
   * Crea un nuevo servicio en la base de datos
   * 
   * @param int $serviceId ID del servicio
   * @param string $userName Nombre de usuario
   * @param string $password Contraseña
   * 
   */

  public function createCredencial($serviceId, $userName, $password)
  {
    try {

      $sql = "INSERT INTO credentials (service_id, username, password_encrypted) 
            VALUES (:service_id, :username, :password_encrypted)";
// var_dump($sql);
// var_dump($password);
// die();
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':service_id', $serviceId);
      $stmt->bindParam(':username', $userName);
      $stmt->bindParam(':password_encrypted', $password);
      if ($stmt->execute()) {
        return true;
      }
      return false;
    } catch (PDOException $e) {
      error_log("Error al crear credencial: " . $e->getMessage());
      return false;
    }
  }
}
