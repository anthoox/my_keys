<?php
require_once __DIR__ . '/../entities/credential.php';
class CredentialsModel
{
  private $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  public function createCredential(Credential $credential): bool
  {
    try {
      $sql = "INSERT INTO credentials (service_id, username, password_encrypted)
              VALUES (:service_id, :username, :password_encrypted)";
      $stmt = $this->db->prepare($sql);

      $stmt->bindValue(':service_id', $credential->getServiceId());
      $stmt->bindValue(':username', $credential->getUsername());
      $stmt->bindValue(':password_encrypted', $credential->getPasswordEncrypted());

      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error al crear credencial: " . $e->getMessage());
      return false;
    }
  }
}