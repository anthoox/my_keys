<?php 

class servicesController{
  private $db;

  public function __construct()
  {
    // Obtenemos la conexión PDO desde la clase DataBase
    $this->db = DataBase::getInstance()->getConnection();
  }
  public function alls()
  {
    // Lógica para mostrar el formulario de creación de usuario
    require_once __DIR__ . '/../views/services/services.php';
  }
}