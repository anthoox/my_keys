<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestor de Claves</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gestor de Claves</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="http://localhost/keys/public/?c=auth&a=showLog">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="http://localhost/keys/public/?c=auth&a=showReg">Registro</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  // Código para manejar controladores y acciones. Página de manejo centralizada.
  // Incluyir autoload
  require_once __DIR__ . '/../../public/autoload.php';
    // var_dump($_GET);
    // die();
  if(isset($_GET)){
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

  ?>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>