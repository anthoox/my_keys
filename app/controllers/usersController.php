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
  public function prueba()
  {

    require_once __DIR__ . '/../models/usersModel.php';
    $prueba_datos = new User();
    $prueba_datos->getDb();
   echo 'Estamos en prueba.php';
  }

}