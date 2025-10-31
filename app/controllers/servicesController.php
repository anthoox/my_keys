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
    $service_model = new ServicesModel();

    // Obtener servicios del usuario actual
    $user_id = $_SESSION['user']['user_id'];
    $services = $service_model->getServicesByUser($user_id);

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

    $service_model = new ServicesModel();
    $cred_model = new CredentialsModel();

    // Crear servicio
    $user_id = $_SESSION['user']['user_id'];
    $user_name = $data['user_name'];

    $service_id = $service_model->createService(
      $user_id,
      $data['service_name'],
      $data['category'],
      $data['notes']
    );

    if ($service_id) {
      // Crear credencial como objeto
      $credential = new Credential($service_id, $user_name);
      $credential->setPassword($data['password']);

      $cred_result = $cred_model->createCredential($credential);

      if ($cred_result) {
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

  public function delService(){

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: /keys/public/?c=auth&a=login");
      exit();
    }

    // Verificar que llegue el ID
    if (!isset($_POST['service_id']) || empty($_POST['service_id'])) {
      $_SESSION['errors'] = "ID de servicio no válido.";
      header("Location: /keys/public/?c=services&a=alls");
    }

    $service_id= intval($_POST['service_id']);

    // Cargar modelo
    require_once __DIR__ . '/../models/ServicesModel.php';
    $serviceModel = new ServicesModel();

    // Eliminar el servicio
    $deleted = $serviceModel->delService($service_id);

    if ($deleted) {
      $_SESSION['success'] = "Servicio eliminado correctamente.";
    } else {
      $_SESSION['errors'] = "No se pudo eliminar el servicio.";
    }

    header("Location: /keys/public/?c=services&a=alls");
    exit();
  }

  public function editService(){

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: /keys/public/?c=auth&a=login");
      exit();
    }

    // Verificar que llegue el ID
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['service_id'] ?? null;
      $name = $_POST['name'] ?? null;
      $user = $_POST['user'] ?? null;
      $password = $_POST['password'] ?? null;

      if ($id && $name && $user && $password) {
        $model = new ServicesModel();
        $updated = $model->editService($id, $name, $user, $password);

        if ($updated) {
          header("Location: /keys/public/?c=services&a=alls");
          exit;
        } else {
          header("Location: /keys/public/?c=services&a=alls");
          exit;
        }
      } else {
        header("Location: /keys/public/?c=services&a=alls");
        exit;
      }
    }
  }
}
