<?php
class AuthController
{
  public function showLog()
  {
    require_once __DIR__ . '/../views/auth/login.php';
  }

  public function showReg()
  {
    require_once __DIR__ . '/../views/auth/register.php';
  }

  public function login()
  {
    // Validar credenciales con el modelo User
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $email = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');

      if (empty($email) || empty($password)) {
        echo "Completa todos los campos";
        return;
      }

      require_once __DIR__ . '/../models/AuthModel.php';
      $authModel = new AuthModel();
      $user = $authModel->loginUser($email, $password);

      if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: /keys/public/?c=services&a=alls");
        exit();
      } else {
        echo "Usuario o contraseña incorrecta";
      }
    } else {
      echo "Método no permitido";
    }
  
  }

  public function register()
  {

    require_once __DIR__ . '/../models/authModel.php';
    require_once __DIR__ . '/../../core/helpers/validatorForm.php';
    require_once __DIR__ . '/../views/auth/register.php';
    // Validar y procesar el formulario de registro
    $data = validateRegistrationForm();
    if (isset($data) && !empty($data)) {
      $authModel = new AuthModel();
      // Verificar si el correo ya está registrado
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
          echo "<div class='alert alert-danger'>Error al registrar el usuario. Inténtalo de nuevo.</div></div>";
        }
      }
    }
  }


  public function logout()
  {
    session_destroy();
    header("Location: /");
    exit;
  }
}
