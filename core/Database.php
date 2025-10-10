<?php

/**
 * Clase Database
 * Encargada de establecer y mantener la conexión a la base de datos mediante PDO.
 * Lee las credenciales desde el archivo .env.
 */

class Database
{
  private static $instance = null;
  private $pdo;

  private function __construct()
  {
    // Cargar variables desde .env
    $env = parse_ini_file(__DIR__ . '/../../.env');

    $host = $env['DB_HOST'];
    $dbname = $env['DB_NAME'];
    $user = $env['DB_USER'];
    $pass = $env['DB_PASS'];
    $charset = $env['DB_CHARSET'];

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    try {
      $this->pdo = new PDO($dsn, $user, $pass);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Error de conexión a la base de datos: " . $e->getMessage());
    }
  }

  // Patrón Singleton — siempre devuelve la misma instancia de conexión
  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->pdo;
  }
}

// INICIAR LA SESIÓN
session_start();