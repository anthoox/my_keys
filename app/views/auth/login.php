<!-- view: auth/login.php -->
<?php require_once __DIR__ . '/../../../core/helpers/showError.php'; ?>

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <h2 class="mb-4">Iniciar Sesión</h2>
    <form method="POST" action="/keys/app/views/auth/login.php">
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="tu@correo.com">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
    <?php
    // session_start(); //INICIO SESIÓN
    // if (isset($_SESSION['errors'])) {
    //   showError($_SESSION['errors']);
    //   unset($_SESSION['errors']); // limpiar después de mostrar
    // }
    ?>

    <?php
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //   $email    = trim($_POST['email'] ?? '');
    //   $password = trim($_POST['password'] ?? '');

    //   $errors = [];

    //   // Validar email
    //   if (empty($email)) {
    //     $errors['login'] = "El correo electrónico es obligatorio.";
    //   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $errors['login'] = "El correo no tiene un formato válido.";
    //   }

    //   // Validar contraseña
    //   if (empty($password)) {
    //     $errors['login'] = "La contraseña es obligatoria.";
    //   } elseif (strlen($password) < 6) {
    //     $errors['login'] = "La contraseña debe tener al menos 6 caracteres.";
    //   }

    //   if (isset($errors)) {
    //     $_SESSION['errors'] = $errors;
    //   }
    // }
    ?>


  </div>
</div>