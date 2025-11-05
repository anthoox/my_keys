<?php
require_once __DIR__ . '/../entities/User.php';
/**
 * TODO mostrar los errores en pantalla si es necesario
 */

class usersModel{

  private $db;

  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  public function getUserData($user_id){

    try {
      $stmt = $this->db->prepare(
        "
      SELECT * from users WHERE id = :user_id LIMIT 1"
      );
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $user_data = [];
      $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
      
      return $user_data;
    } catch (PDOException $e) {
      error_log("Error al obtener servicios: " . $e->getMessage());

      return [];
    }
  }

  public function editUserData(int $user_id, ?string $user_name = null, ?string $email = null){
    try {
      // Iniciamos la transacción
      $this->db->beginTransaction();

      if(empty($email)){
        // Cambio de nombre
        $sql_service = "UPDATE users SET username = :username WHERE id = :id";
        $stmt_service = $this->db->prepare($sql_service);
        $stmt_service->execute([
          'username' => $user_name,
          'id'   => $user_id
        ]);
      }

      if (empty($user_name)) {
        // Cambio de nombre
        $sql_service = "UPDATE users SET email = :email WHERE id = :id";
        $stmt_service = $this->db->prepare($sql_service);
        $stmt_service->execute([
          'email' => $email
        ]);
      }

     } catch (PDOException $e) {
      $this->db->rollBack();
      error_log("Error en editService: " . $e->getMessage());
      return false;
    }
  }
}