<?php
class AuthController
{


  public function login()
  {
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Si el usuario ya tiene sesión iniciada, redirigir a servicios
    if (isset($_SESSION['user'])) {
      header("Location: /keys/public/?c=services&a=alls");
      exit();
    }

    // Si la petición es POST, procesar el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $email = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');

      // Validar campos
      if (empty($email) || empty($password)) {
        $error = "Completa todos los campos.";
        require_once __DIR__ . '/../views/auth/login.php';
        return;
      }

      // Cargar modelo
      require_once __DIR__ . '/../models/AuthModel.php';
      $authModel = new AuthModel();
      $user = $authModel->loginUser($email, $password);

      // Si las credenciales son correctas
      if ($user) {
        $_SESSION['user'] = [
          'user_id' => $user['id'],
          'username' => $user['username']
        ];

        header("Location: /keys/public/?c=services&a=alls");
        exit();
      } else {
        // Credenciales incorrectas
        $error = 'Usuario o contraseña incorrecta.';
        require_once __DIR__ . '/../views/auth/login.php';
        exit();
      }
    } else {
      // Si no se envió por POST, mostrar el formulario
      require_once __DIR__ . '/../views/auth/login.php';
      exit();
    }
  }

  public function register()
  {
    // Iniciar sesión si no está activa
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Si el usuario ya tiene sesión activa, lo redirigimos a sus servicios
    if (isset($_SESSION['user'])) {
      header("Location: /keys/public/?c=services&a=alls");
      exit();
    }

    require_once __DIR__ . '/../models/authModel.php';
    require_once __DIR__ . '/../../core/helpers/validatorForm.php';
    require_once __DIR__ . '/../views/auth/register.php';
    // Validar y procesar el formulario de registro
    $data = validateRegistrationForm();
    if (isset($data) && !empty($data)) {
      $authModel = new AuthModel();
      // Verificar si el correo ya está registrado
      if(isset($data['email']) && $data['email'] != '') {
        $result = $authModel->emailExists($data['email']);
        if ($result) {
          echo "<div class='d-flex justify-content-center align-items-center  w-100'>
        <div class='alert alert-danger col-6'>El correo ya está registrado.</div>";
        } else {
          // Registrar al usuario
          $registerResult = $authModel->createUser($data['username'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT));
          // Mostrar mensaje de éxito o error
          if ($registerResult) {
            echo "<div class='d-flex justify-content-center align-items-center  w-100'>
          <div class='alert alert-success col-6'>Registro exitoso. Ahora puedes <a href='http://localhost/keys/public/?c=auth&a=showLog'>iniciar sesión</a>.</div>";
          } else {
            echo "<div class='d-flex justify-content-center align-items-center  w-100'>
          <div class='alert alert-success col-6'>Error al registrar el usuario. Inténtalo de nuevo<a href='http://localhost/keys/public/?c=auth&a=showLog'>iniciar sesión</a>.</div>";
          }
        }
      }

    }
  }


  public function logout()
  {
    // Asegurarnos de que la sesión esté iniciada
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Limpiar todas las variables de sesión
    $_SESSION = [];

    // Si se usa cookie de sesión, invalidarla
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

    // Destruir la sesión del lado del servidor
    session_destroy();

    // Redirigir al login (mejor que incluir la vista directamente)
    header("Location: /keys/public/?c=auth&a=login"); // ajusta la ruta a tu proyecto
    exit();
  }
}
