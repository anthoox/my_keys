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
    require_once __DIR__ . '/../../core/helpers/validatorForm.php';

    $data = validateRegistrationForm();
    // var_dump($data);
    // die();
    if (isset($data) && !empty($data)) {
      $authModel = new AuthModel();
      // Validar campos
      if (empty($data['email']) || empty($data['password'])) {
        $_SESSION['errors'] = "Completa todos los campos.";
        require_once __DIR__ . '/../views/auth/login.php';
        return;
      }

      // Cargar modelo
      require_once __DIR__ . '/../models/AuthModel.php';
      $authModel = new AuthModel();
      $user = $authModel->loginUser($data['email'], $data['password']);

      // Si las credenciales son correctas
      if ($user) {
        $_SESSION['user'] = [
          'user_id' => $user->getId(),
          'username' => $user->getUsername(),
          'email' => $user->getEmail(),
          'password' => $user->getPasswordHash()
        ];

        header("Location: /keys/public/?c=services&a=alls");
        exit();
      } else {
        // Credenciales incorrectas
        $_SESSION['errors'] = "Usuario o contraseña incorrectos.";
        require_once __DIR__ . '/../views/auth/login.php';
        exit();
      }
    }
    require_once __DIR__ . '/../views/auth/login.php';
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

    // Validar y procesar el formulario de registro
    $data = validateRegistrationForm();

    $registerResult = false;
    if (isset($data) && !empty($data)) {
      $authModel = new AuthModel();

      // Verificar si el correo ya está registrado
      if (isset($data['email']) && $data['email'] !== '') {
        /**
         * TODOS Mostrar errores si el email ya existe
         */
        $result = $authModel->emailExists($data['email']);

        if ($result) {
          // Guardar el error en variable
          $_SESSION['errors'] = "El correo ya está registrado.";
        } else {
          // Registrar al usuario
          $registerResult = $authModel->createUser(
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT)
          );
        }
      }
    }
    require_once __DIR__ . '/../views/auth/register.php';
    if ($registerResult) {
      /** 
       *  TODO añadir metodo showError para mostrar errores o exito
       * */ 
      echo " <div class='p-2'><div class='d-flex justify-content-center align-items-center  w-100 mt-3'>
    <div class='alert alert-success col-6'>Usuario registrado, ya puedes <a href='http://localhost/keys/public/?c=auth&a=login'>iniciar sesión.</a></div></div></div>";
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
