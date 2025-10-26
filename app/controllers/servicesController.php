<?php

class ServicesController
{
  private $db;

  public function __construct()
  {
    // Obtenemos la conexión PDO desde la clase DataBase
    $this->db = DataBase::getInstance()->getConnection();
  }

  public function alls()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar que el usuario esté logueado
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: /keys/public/?c=auth&a=login");
      exit();
    }

    // Cargar el modelo
    require_once __DIR__ . '/../models/ServicesModel.php';
    $serviceModel = new ServicesModel();

    // Obtener servicios del usuario actual
    $userId = $_SESSION['user']['user_id'];
    $services = $serviceModel->getServicesByUser($userId);

    if (!empty($services)) {
      // mostrar servicios
      require_once __DIR__ . '/../../core/helpers/renderServices.php';
      renderServices($services);

    } else {
      $_SESSION['errors'] = "Error al cargar los servicios.";
    }


    require_once __DIR__ . '/../views/services/services.php';
    die();
  }

  /** 
   * *  futura funcion alls para mostrar todos los servicios
   * */
  public function store()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: /keys/public/?c=auth&a=login");
      exit();
    }

    require_once __DIR__ . '/../../core/helpers/validatorForm.php';
    $data = validateServiceForm();


    // Si hay errores de validación
    if (!$data) {
      header("Location: /keys/public/?c=services&a=alls");
      exit();
    }


    // Cargar modelos
    require_once __DIR__ . '/../models/servicesModel.php';
    require_once __DIR__ . '/../models/credentialsModel.php';

    $serviceModel = new ServicesModel();
    $credModel = new CredentialsModel();

    // Crear servicio
    $userId = $_SESSION['user']['user_id'];
    $userName = $data['user_name'] ;


    $serviceId = $serviceModel->createService($userId, $data['service_name'], $data['category'], $data['notes']);

    if ($serviceId) {

      // Crear credenciales
      $credResult = $credModel->createCredencial($serviceId, $userName, $data['password']);

      if ($credResult) {
        /** 
         *  TODO añadir metodo showError para mostrar errores o exito
         * */
        $_SESSION['success'] = "Servicio añadido correctamente.";
      } else {
        $_SESSION['errors'] = "No se pudieron guardar las credenciales.";
      }
    } else {
      $_SESSION['errors'] = "Error al crear el servicio.";
    }

    // Redirigir de vuelta
    header("Location: /keys/public/?c=services&a=alls");
    exit();
  }
}
