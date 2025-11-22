<?php
require_once __DIR__ . '/../../core/config/config.php';
require_once __DIR__ . '/../../core/helpers/startSesion.php';

/**
 * Controlador encargado de gestionar:
 * - Mostrar servicios
 * - Crear servicios y credenciales asociadas
 * - Editar servicios
 * - Eliminar servicios
 * - Obtener contraseña (AJAX)
 */
class ServicesController
{

  /**
   * Muestra todos los servicios del usuario logueado.
   *
   * Flujo:
   * 1. Iniciar sesión si no está activa.
   * 2. Verificar si el usuario está autenticado.
   * 3. Cargar modelo de servicios.
   * 4. Obtener los servicios del usuario.
   * 5. Renderizar los servicios usando helper.
   * 6. Cargar vista principal.
   */
  public function alls()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Cargar modelo de servicios
    require_once __DIR__ . '/../models/ServicesModel.php';
    $service_model = new ServicesModel();

    // Obtener servicios del usuario
    $user_id = $_SESSION['user']['user_id'];
    $services = $service_model->getServicesByUser($user_id);

    if (!empty($services)) {

      // Renderizar tarjetas de servicios
      require_once __DIR__ . '/../../core/helpers/renderServices.php';
      renderServices($services);
    } else {

      // Error genérico si no se encuentran servicios
      $_SESSION['errors'] = "Error al cargar los servicios.";
    }

    require_once __DIR__ . '/../views/services/services.php';
    die();
  }

  /**
   * Guarda un nuevo servicio y sus credenciales asociadas.
   *
   * Flujo:
   * 1. Verificar sesión activa.
   * 2. Validar datos enviados desde el formulario.
   * 3. Crear el servicio en la BD.
   * 4. Crear la credencial como objeto Credential.
   * 5. Guardar credenciales.
   * 6. Guardar mensaje de éxito/error.
   * 7. Redirigir.
   */
  public function store()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Validación del formulario
    require_once __DIR__ . '/../../core/helpers/validatorForms.php';
    $data = validateServiceForm();

    if (!$data) {
      header("Location: " . BASE_URL . "/?c=services&a=alls");
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

      // Crear entidad Credential
      $credential = new Credential($service_id, $user_name);
      $credential->setPassword($data['password']);

      // Guardar credenciales
      $cred_result = $cred_model->createCredential($credential);

      if ($cred_result) {
        $_SESSION['success'] = "Servicio añadido correctamente.";
      } else {
        $_SESSION['errors'] = "No se pudieron guardar las credenciales.";
      }
    } else {
      $_SESSION['errors'] = "Error al crear el servicio.";
    }

    header("Location: " . BASE_URL . "/?c=services&a=alls");
    exit();
  }

  /**
   * Elimina un servicio y sus credenciales.
   *
   * Flujo:
   * 1. Verifica sesión activa.
   * 2. Verifica si llega un ID mediante POST.
   * 3. Carga el modelo.
   * 4. Intenta eliminar el servicio.
   * 5. Guarda mensaje de éxito/error en sesión.
   * 6. Redirige.
   */
  public function delService()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Verificar ID
    if (!isset($_POST['service_id']) || empty($_POST['service_id'])) {
      $_SESSION['errors'] = "ID de servicio no válido.";
      header("Location: " . BASE_URL . "/?c=services&a=alls");
    }

    $service_id = intval($_POST['service_id']);

    // Cargar modelo
    require_once __DIR__ . '/../models/ServicesModel.php';
    $serviceModel = new ServicesModel();

    // Eliminar servicio
    $deleted = $serviceModel->delService($service_id);

    // Mensajes
    if ($deleted) {
      $_SESSION['success'] = "Servicio eliminado correctamente.";
    } else {
      $_SESSION['errors'] = "No se pudo eliminar el servicio.";
    }

    header("Location: " . BASE_URL . "/?c=services&a=alls");
    exit();
  }

  /**
   * Edita un servicio existente.
   *
   * Flujo:
   * 1. Verifica sesión activa.
   * 2. Comprueba método POST.
   * 3. Recoge datos del formulario.
   * 4. Llama al modelo para actualizar.
   * 5. Redirige sin mostrar mensajes (podrías agregarlos).
   */
  public function editService()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $id = $_POST['service_id'] ?? null;
      $name = $_POST['name'] ?? null;
      $user = $_POST['user'] ?? null;
      $password = $_POST['password'] ?? null;

      if ($id && $name && $user) {

        $model = new ServicesModel();
        $updated = $model->editService($id, $name, $user, $password);

        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit;
      } else {

        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit();
      }
    }
  }

  /**
   * Devuelve la contraseña desencriptada vía AJAX (JSON).
   *
   * Flujo:
   * 1. Verifica sesión.
   * 2. Limpia buffers para evitar errores JSON.
   * 3. Verifica ID.
   * 4. Llama al modelo de credenciales.
   * 5. Devuelve JSON limpio con la contraseña desencriptada.
   */
  public function getPassword()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Evitar output que rompa JSON
    ob_clean();

    header("Content-Type: application/json");

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      echo json_encode([
        "success" => false,
        "message" => "No autorizado"
      ]);
      exit;
    }

    $service_id = $_GET['id'] ?? null;

    if (!$service_id) {
      echo json_encode([
        "success" => false,
        "message" => "ID no válido"
      ]);
      exit;
    }

    require_once __DIR__ . '/../models/credentialsModel.php';

    $model = new CredentialsModel();
    $password = $model->getDecryptedPassword(service_id: $service_id);

    if (!$password) {
      echo json_encode([
        "success" => false,
        "message" => "No se encontró la contraseña"
      ]);
      exit;
    }

    // Respuesta JSON
    echo json_encode([
      "success" => true,
      "password" => $password
    ]);
    exit();
  }
}
