<?php

class ServicesController
{

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

    /**
     * TODO getServicesByUser DEBE DEVOLVER UN OBJETO!!! - RETOCAR
     */
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

    // Validación
    if (!$data) {
      header("Location: /keys/public/?c=services&a=alls");
      exit();
    }

    // Cargar modelos y entidades
    require_once __DIR__ . '/../models/servicesModel.php';
    require_once __DIR__ . '/../models/credentialsModel.php';
    require_once __DIR__ . '/../entities/Credential.php';

    $serviceModel = new ServicesModel();
    $credModel = new CredentialsModel();

    // Crear servicio
    $userId = $_SESSION['user']['user_id'];
    $userName = $data['user_name'];

    $serviceId = $serviceModel->createService(
      $userId,
      $data['service_name'],
      $data['category'],
      $data['notes']
    );

    if ($serviceId) {
      // Crear credencial como objeto
      $credential = new Credential($serviceId, $userName);
      $credential->setPassword($data['password']);

      $credResult = $credModel->createCredential($credential);

      if ($credResult) {
        $_SESSION['success'] = "Servicio añadido correctamente.";
      } else {
        $_SESSION['errors'] = "No se pudieron guardar las credenciales.";
      }
    } else {
      $_SESSION['errors'] = "Error al crear el servicio.";
    }

    // Redirigir
    header("Location: /keys/public/?c=services&a=alls");
    exit();
  }
}
