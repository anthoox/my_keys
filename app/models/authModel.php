<?php
require_once __DIR__ . '/../../core/database/DataBase.php';
require_once __DIR__ . '/../entities/user.php';
/**
 * Modelo responsable de la autenticación y registro de usuarios.
 * Maneja validación de email, creación de usuarios y login.
 */
class AuthModel
{
  /** @var PDO Conexión a la base de datos */
  private PDO $db;

  /**
   * Inicializa la conexión usando el patrón Singleton.
   */
  public function __construct()
  {
    $this->db = DataBase::getInstance()->getConnection();
  }

  /**
   * Verifica si un email ya existe en la base de datos.
   *
   * @param string $email Email a comprobar.
   * @return bool True si existe, False si no.
   */
  public function emailExists(string $email): bool
  {
    $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['email' => $email]);

    // fetchColumn devuelve "0" o "1", lo convertimos a booleano
    return (bool)$stmt->fetchColumn();
  }

  /**
   * Crea un nuevo usuario en la base de datos.
   *
   * @param string $username Nombre de usuario.
   * @param string $email Correo electrónico del usuario.
   * @param string $password Contraseña en texto plano.
   *
   * @return bool Retorna true si el usuario fue creado correctamente, false en caso contrario.
   *
   * NOTA:
   * - La contraseña se cifra usando PASSWORD_BCRYPT antes de guardarla.
   * - Se usa transacción para garantizar que la operación sea atómica.
   * - Los errores se registran en el log de PHP sin mostrarlos al usuario.
   */
  public function createUser(string $username, string $email, string $password): bool
  {
    // Hashear la contraseña
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    try {
      // Iniciar transacción
      $this->db->beginTransaction();

      // Preparar la consulta para insertar el usuario
      $sql = "INSERT INTO users (username, email, password_hash) 
                VALUES (:username, :email, :password_hash)";
      $stmt = $this->db->prepare($sql);

      // Ejecutar la consulta con los parámetros
      $success = $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password_hash' => $password_hashed
      ]);

      // Confirmar la transacción
      $this->db->commit();

      return $success;
    } catch (\PDOException $e) {
      // En caso de error, deshacer la transacción y registrar el error
      $this->db->rollback();
      error_log("Error al crear usuario: " . $e->getMessage());

      return false;
    }
  }


  /**
   * Valida el login de un usuario comparando email y contraseña.
   *
   * Este método busca un usuario por su email y, si existe,
   * verifica que la contraseña proporcionada coincida con el hash almacenado.
   *
   * @param string $email Email del usuario introducido en el formulario.
   * @param string $password Contraseña SIN hashear introducida por el usuario.
   * @return User|null Devuelve un objeto User si el login es correcto, o null si falla.
   */
  public function loginUser(string $email, string $password): array
  {
    $data = $this->findUserByEmail($email);

    if (!$data) {
      return [
        'success' => false,
        'error'   => 'USER_NOT_FOUND'
      ];
    }

    if (!password_verify($password, $data['password_hash'])) {
      return [
        'success' => false,
        'error'   => 'INVALID_PASSWORD'
      ];
    }

    return [
      'success' => true,
      'user' => new User(
        $data['id'],
        $data['username'],
        $data['email'],
        $data['created_at']
      )
    ];
  }


  /**
   * Busca un usuario en la base de datos por su email.
   *
   * @param string $email Email del usuario a buscar.
   * @return array|null Array asociativo con los datos del usuario o null si no existe.
   */
  private function findUserByEmail(string $email): ?array
  {
    // Consulta SQL que selecciona un único usuario por su email.
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

    // Preparamos la consulta para evitar inyecciones SQL.
    $stmt = $this->db->prepare($sql);

    // Ejecutamos la consulta pasando el parámetro email.
    $stmt->execute(['email' => $email]);

    // fetch() devuelve false si no encuentra nada → convertimos en null con el operador ?:.
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
