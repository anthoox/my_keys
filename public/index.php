<!-- public/index.php -->
<!-- Aqui se inicia la aplicacion y redirigue al login -->


<h1>Index</h1>
<?php

require_once __DIR__ . '/autoload.php';
// Código para manejar controladores y acciones. Página de manejo centralizada.
if (empty($_GET)) {
  require_once '../app/views/layout.php';

  exit();
}

require_once '../app/views/layout.php';

if (isset($_GET)) {
  // Si existe el controlador en la URL, lo asigna a una variable
  if (isset($_GET['c'])) {
    $controller_name = $_GET['c'] . 'Controller';
    // var_dump($_GET);
    // die();
  } else {
    echo 'La página que buscas no existe';
    exit();
  }

  // Si existe la clase del controlador, crea una instancia
  if (class_exists($controller_name)) {

    $controller = new $controller_name();
    if (isset($_GET['a']) && method_exists($controller, $_GET['a'])) {
      $action = $_GET['a'];

      $controller->$action();
    } else {
      echo "La acción/método no existe.";
    }
  } else {
    echo "La Clase no existe.";
  }
}


// prueba de conexion a la base de datos
// require_once __DIR__ . '/../core/DataBase.php';

// $db = DataBase::getInstance()->getConnection();

// echo "✅ Conexión establecida correctamente<br>";