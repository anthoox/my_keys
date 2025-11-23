<?php

/**
 * Clase DataBase
 * 
 * Esta clase se encarga de manejar la conexión a la base de datos usando PDO.
 * Implementa el patrón Singleton para garantizar que siempre se use una única
 * conexión durante la ejecución del script.
 * 
 * Credenciales:
 * - Se leen desde un archivo .env ubicado en la raíz del proyecto.
 * - Variables esperadas: DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET
 */
class DataBase
{
  /**
   * Instancia única de la clase (Singleton)
   * @var DataBase|null
   */
  private static ?DataBase $instance = null;

  /**
   * Objeto PDO que mantiene la conexión
   * @var PDO
   */
  private PDO $pdo;

  /**
   * Constructor privado para evitar instanciación externa
   */
  private function __construct()
  {
    // Cargar variables de entorno desde .env
    $env = parse_ini_file(__DIR__ . '/../../.env');

    $host = $env['DB_HOST'];
    $dbname = $env['DB_NAME'];
    $user = $env['DB_USER'];
    $pass = $env['DB_PASS'];
    $charset = $env['DB_CHARSET'] ?? 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    try {
      $this->pdo = new PDO($dsn, $user, $pass);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      // Si la conexión falla, terminamos el script mostrando el error
      die("Error de conexión a la base de datos: " . $e->getMessage());
    }
  }

  /**
   * Obtiene la instancia única de la clase DataBase
   * 
   * @return DataBase
   */
  public static function getInstance(): DataBase
  {
    if (self::$instance === null) {
      self::$instance = new DataBase();
    }
    return self::$instance;
  }

  /**
   * Devuelve la conexión PDO
   * 
   * @return PDO
   */
  public function getConnection(): PDO
  {
    return $this->pdo;
  }
}
