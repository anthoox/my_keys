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
    startSession();

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
    exit();
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
    startSession();

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
   * Elimina un servicio existente de un usuario.
   *
   * Flujo:
   * 1. Verifica sesión activa.
   * 2. Comprueba que el método sea POST.
   * 3. Valida que el ID del servicio llegue correctamente.
   * 4. Verifica que el servicio pertenezca al usuario logueado.
   * 5. Llama al modelo para eliminar el servicio.
   * 6. Redirige a la vista de servicios con mensajes de éxito o error.
   */
  public function delService()
  {
    startSession();

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Validar que llega el ID por POST
    if (
      $_SERVER['REQUEST_METHOD'] !== 'POST' ||
      !isset($_POST['service_id']) ||
      empty($_POST['service_id'])
    ) {

      $_SESSION['errors'] = "Solicitud no válida.";
      header("Location: " . BASE_URL . "/?c=services&a=alls");
      exit();
    }

    $service_id = intval($_POST['service_id']);
    $user_id = $_SESSION['user']['user_id'];

    // Cargar modelo
    require_once __DIR__ . '/../models/ServicesModel.php';
    $serviceModel = new ServicesModel();

    // -------------------------------
    // 🔐 Verificar que el servicio es del usuario logueado
    // -------------------------------
    if (!$serviceModel->belongsToUser($service_id, $user_id)) {
      $_SESSION['errors'] = "No tienes permisos para eliminar este servicio.";
      header("Location: " . BASE_URL . "/?c=services&a=alls");
      exit();
    }

    // -------------------------------
    // 🚮 Eliminar servicio
    // -------------------------------
    $deleted = $serviceModel->delService($service_id);

    if ($deleted) {
      $_SESSION['success'] = "Servicio eliminado correctamente.";
    } else {
      $_SESSION['errors'] = "No se pudo eliminar el servicio.";
    }

    header("Location: " . BASE_URL . "/?c=services&a=alls");
    exit();
  }

  /**
   * Edita un servicio existente de un usuario.
   *
   * Flujo:
   * 1. Verifica sesión activa y autenticación.
   * 2. Si la petición es GET:
   *    - Obtiene el ID del servicio.
   *    - Verifica que el servicio pertenezca al usuario.
   *    - Carga la vista de edición con los datos del servicio.
   * 3. Si la petición es POST:
   *    - Recoge datos del formulario.
   *    - Verifica que los campos obligatorios estén presentes.
   *    - Verifica propiedad del servicio.
   *    - Llama al modelo para actualizar el servicio y la credencial.
   *    - Redirige a la vista de servicios con mensajes de éxito o error.
   */
  public function editService()
  {
    startSession();

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    require_once __DIR__ . '/../models/ServicesModel.php';
    $serviceModel = new ServicesModel();
    $user_id = $_SESSION['user']['user_id'];

    // PETICIÓN GET -> mostrar formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $service_id = $_GET['id'] ?? null;
      if (!$service_id || !$serviceModel->belongsToUser($service_id, $user_id)) {
        $_SESSION['errors'] = "No tienes permisos para editar este servicio.";
        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit();
      }

      // Obtener servicio
      $service = $serviceModel->findById($service_id);
      require '../app/views/services/edit.php';
      exit();
    }

    // PETICIÓN POST -> procesar edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $service_id = $_POST['service_id'] ?? null;
      $name       = $_POST['name'] ?? null;
      $user       = $_POST['user'] ?? null;
      $password   = $_POST['password'] ?? null;

      // Validar campos obligatorios
      if (!$service_id || !$name || !$user) {
        $_SESSION['errors'] = "Datos incompletos para editar el servicio.";
        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit();
      }

      // Verificar propiedad del servicio
      if (!$serviceModel->belongsToUser($service_id, $user_id)) {
        $_SESSION['errors'] = "No tienes permisos para editar este servicio.";
        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit();
      }

      // Actualizar servicio
      $updated = $serviceModel->editService($service_id, $name, $user, $password);

      if ($updated) {
        $_SESSION['success_message'] = "Modificación realizada.";
      } else {
        $_SESSION['error_message'] = "No se pudo realizar la modificación.";
      }

      header("Location: " . BASE_URL . "/?c=services&a=alls");
      exit();
    }
  }

  /**
   * Devuelve la contraseña desencriptada de un servicio específico en formato JSON.
   * 
   * Seguridad:
   * - Solo el usuario propietario del servicio puede obtener la contraseña.
   * - Evita cualquier output previo que rompa el JSON.
   * 
   * Método: GET
   * Parámetros esperados: ?id=ID_DEL_SERVICIO
   * Respuesta JSON:
   * {
   *   "success": true/false,
   *   "password": "contraseña" | null,
   *   "message": "mensaje de error" | null
   * }
   */
  public function getPassword()
  {
    // Iniciar sesión si no está iniciada
    startSession();

    // Limpiar buffer de salida previo para asegurar JSON válido
    if (ob_get_length()) {
      ob_clean();
    }

    // Cabecera para indicar que la respuesta es JSON
    header("Content-Type: application/json");

    // Recuperar ID del servicio desde GET
    $service_id = $_GET['id'] ?? null;

    // Verificar que se haya proporcionado un ID válido
    if (!$service_id) {
      echo json_encode([
        "success" => false,
        "message" => "ID no válido"
      ]);
      exit();
    }

    // ID del usuario logueado
    $user_id = $_SESSION['user']['user_id'] ?? null;

    // Validación de sesión
    if (!$user_id) {
      echo json_encode([
        "success" => false,
        "message" => "No autorizado"
      ]);
      exit();
    }

    // Verificar que el servicio pertenece al usuario
    $serviceModel = new ServicesModel();
    if (!$serviceModel->belongsToUser($service_id, $user_id)) {
      echo json_encode([
        "success" => false,
        "message" => "No autorizado"
      ]);
      exit();
    }

    // Cargar modelo de credenciales
    require_once __DIR__ . '/../models/credentialsModel.php';
    $credModel = new CredentialsModel();

    // Obtener contraseña desencriptada
    $password = $credModel->getDecryptedPassword(service_id: $service_id);

    // Validar que se obtuvo la contraseña
    if (!$password) {
      echo json_encode([
        "success" => false,
        "message" => "No se encontró la contraseña"
      ]);
      exit();
    }

    // Respuesta exitosa
    echo json_encode([
      "success" => true,
      "password" => $password
    ]);
    exit();
  }
}