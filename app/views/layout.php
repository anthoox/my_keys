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
          <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="http://localhost/keys/public/?UsersController=prueba">Registro</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  require_once __DIR__ . '/../controller/users.php';
  // CONFIGURACIÓN DE PRUEBA MVC
  $crearUsuario = new UsersController();
  $crearUsuario->create();
  if (isset($_GET['UsersController'])) {
    $crearUsuario = new UsersController();
    $action = $_GET['UsersController'];

    $crearUsuario->$action();
  };

  ?>
  <div class="container my-4">
    <?php if (isset($content)) echo $content; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>