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
