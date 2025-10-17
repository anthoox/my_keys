<?php

class UsersController {

  public function create() {
    // Lógica para mostrar el formulario de creación de usuario
    require_once __DIR__ . '/../views/auth/register.php';
  }

  public function showAll(){
    
    require_once __DIR__ . '/../models/users.php';
    $userModel = new User();
    $users = $userModel->getAllUsers();
    require_once __DIR__ . '/../views/layout.php';
    return $users;
    
  }
}