<?php 

class appsController{
  public function alls()
  {
    // Lógica para mostrar el formulario de creación de usuario
    echo 'Estamos en apps.php';

    require_once __DIR__ . '/../views/apps/apps.php';
  }
}