<?php
require_once __DIR__ . '/../entities/credential.php';
require_once __DIR__ . '/../../core/database/DataBase.php';
require_once __DIR__ . '/../../core/helpers/crypto.php';

/**
 * Modelo para manejar las credenciales de los servicios.
 * Permite crear credenciales y obtener contraseñas desencriptadas.
 */
class CredentialsModel
{
  private PDO $db;

  /**
   * Constructor: obtiene la conexión a la base de datos.
   */
  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  /**
   * Crea una nueva credencial en la base de datos.
   *
   * @param Credential $credential Objeto Credential con los datos a guardar.
   * @return bool Devuelve true si la inserción fue exitosa, false si hubo error.
   */
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
      // Registrar errores en log del servidor, no mostrar al usuario
      error_log("Error al crear credencial: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Obtiene la contraseña desencriptada de una credencial por su ID de servicio.
   *
   * @param int $service_id ID del servicio al que pertenece la credencial.
   * @return string|null Devuelve la contraseña desencriptada o null si no existe.
   */
  public function getDecryptedPassword(int $service_id): ?string
  {
    // Validar que sea un ID válido
    if ($service_id <= 0) {
      return null;
    }
    
    $sql = "SELECT password_encrypted FROM credentials WHERE service_id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      // No existe la credencial para ese servicio
      return null;
    }

    // Desencriptar la contraseña usando la función helper
    $decrypted = decryptPassword($row['password_encrypted']);

    return $decrypted;
  }
}
