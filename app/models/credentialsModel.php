<?php
require_once __DIR__ . '/../entities/credential.php';
require_once __DIR__ . '/../../core/database/DataBase.php';
require_once __DIR__ . '/../../core/helpers/crypto.php';

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

  public function getDecryptedPassword($service_id)
  {

    $sql = "SELECT password_encrypted FROM credentials WHERE service_id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {

      return null; // no existe la credencial
    }

    // aquí desencriptamos la contraseña
    $decrypted = decryptPassword($row['password_encrypted']);

    return $decrypted;
  }
}