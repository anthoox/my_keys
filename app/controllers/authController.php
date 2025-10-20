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
    // Registrar usuario nuevo
  }

  public function logout()
  {
    session_destroy();
    header("Location: /");
    exit;
  }
}
