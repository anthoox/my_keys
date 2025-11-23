<?php
require_once __DIR__ . '/../../core/config/config.php';
require_once __DIR__ . '/../../core/helpers/startSesion.php';
require_once __DIR__ . '/../../core/helpers/validatorForms.php';
require_once __DIR__ . '/../models/authModel.php';

/**
 * Controlador encargado de gestionar la autenticación:
 * - Inicio de sesión
 * - Registro de usuario
 * - Cierre de sesión
 *
 * Se apoya en AuthModel para interactuar con la base de datos.
 */
class AuthController
{

  /**
   * Muestra el formulario de login y procesa el intento de inicio de sesión.
   *
   * Flujo:
   * 1. Inicia sesión si no está iniciada.
   * 2. Si el usuario ya tiene sesión activa → redirige a servicios.
   * 3. Valida los datos enviados desde el formulario.
   * 4. Si email/contraseña están vacíos → muestra error.
   * 5. Llama al modelo para verificar las credenciales.
   * 6. Si son válidas → crea la sesión y redirige.
   * 7. Si no → muestra mensaje de error.
   */
  public function login()
  {
    // Iniciar sesión si no está iniciada
    startSession();

    // Si ya está autenticado, evitar que vuelva al login
    if (isset($_SESSION['user'])) {
      header("Location: " . BASE_URL . "/?c=services&a=alls");
      exit();
    }

    // Validar datos recibidos del formulario (sanitización + seguridad)
    $data = validateAuthForm();

    // Si se enviaron datos (POST)
    if (isset($data) && !empty($data)) {

      // Validación básica de campos
      if (empty($data['email']) || empty($data['password'])) {
        $_SESSION['errors'] = "Completa todos los campos.";
        require_once __DIR__ . '/../views/auth/login.php';
        return;
      }

      // Cargar modelo de autenticación
      $authModel = new AuthModel();

      // Intentar autenticar al usuario
      $login = $authModel->loginUser($data['email'], $data['password']);

      // Verificamos éxito y extraemos el objeto User
      if ($login['success']) {
        $user = $login['user']; // aquí $user es un objeto User

        // Guardar datos esenciales del usuario en la sesión
        $_SESSION['user'] = [
          'user_id' => $user->getId(),
          'username' => $user->getUsername(),
          'email' => $user->getEmail(),
        ];

        // Redirigir al panel de servicios
        header("Location: " . BASE_URL . "/?c=services&a=alls");
        exit();
      } else {
        // Credenciales incorrectas
        $_SESSION['errors'] = "Usuario o contraseña incorrectos.";
        require_once __DIR__ . '/../views/auth/login.php';
        exit();
      }
    }

    // Si no hubo envío POST, solo mostramos el formulario
    require_once __DIR__ . '/../views/auth/login.php';
  }

  /**
   * Muestra el formulario de registro y procesa el alta de usuario.
   *
   * Flujo:
   * 1. Inicia sesión si no está activa.
   * 2. Si ya está autenticado → redirige.
   * 3. Carga validador y modelo.
   * 4. Valida los datos enviados por POST.
   * 5. Comprueba si el email ya existe.
   * 6. Si no existe → crea el usuario.
   * 7. Muestra mensaje de éxito o error.
   */
  public function register()
  {
    // Asegurar sesión activa
    startSession();


    // Si ya está autenticado, no permitir acceso al registro
    if (isset($_SESSION['user'])) {
      header("Location: " . BASE_URL . "/?c=services&a=alls");
      exit();
    }


    // Validar y sanitizar datos del formulario
    $data = validateAuthForm();

    $register_result = false;

    if (isset($data) && !empty($data)) {
      $authModel = new AuthModel();

      // Verificar si se envió un email
      if (isset($data['email']) && $data['email'] !== '') {

        // Comprobar si el correo ya existe en la base de datos
        $result = $authModel->emailExists($data['email']);

        if ($result) {

          // Guardar error en sesión
          $_SESSION['errors'] = "El correo ya está registrado.";
        } else {

          // Crear usuario (password hasheado)
          $register_result = $authModel->createUser(
            $data['username'],
            $data['email'],
            $data['password']
          );
        }
      }
    }

    // Mostrar vista de registro
    require_once __DIR__ . '/../views/auth/register.php';

    // Mostrar mensaje de éxito si el registro fue correcto
    if ($register_result) {
      echo "
        <div class='p-2'>
          <div class='d-flex justify-content-center align-items-center w-100 mt-3'>
            <div class='alert alert-success col-6'>
              Usuario registrado, ya puedes 
              <a href='" . FULL_BASE_URL . "/?c=auth&a=login'>iniciar sesión.</a>
            </div>
          </div>
        </div>";
    }
  }


  /**
   * Cierra la sesión del usuario de forma segura.
   *
   * Flujo:
   * 1. Inicia sesión si no lo está.
   * 2. Limpia variables de sesión.
   * 3. Invalida cookie de sesión.
   * 4. Destruye la sesión.
   * 5. Redirige al login.
   */
  public function logout()
  {
    // Asegurar sesión activa
    startSession();


    // Vaciar variables de sesión
    $_SESSION = [];

    // Invalidar cookie de sesión si existe
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    // Destruir la sesión en servidor
    session_destroy();

    // Redirigir al formulario de login
    header("Location: " . BASE_URL . "/?c=auth&a=login");
    exit();
  }
}
