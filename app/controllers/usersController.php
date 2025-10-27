<?php

class UsersController {
  public $db;

  public function register() {
    // Lógica para mostrar el formulario de creación de usuario
    echo 'Estamos en register.php';

    require_once __DIR__ . '/../views/auth/register.php';

  }

  public function login()
  {
    // Lógica para mostrar el formulario de creación de usuario
    echo 'Estamos en login.php';

    require_once __DIR__ . '/../views/auth/login.php';
  }


  /**
   * Obtener todos los servicios asociados a un usuario
   */
  public function account()
  {

    require_once __DIR__ . '/../views/users/account.php';
  }

}