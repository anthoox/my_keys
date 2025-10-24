<!-- view: auth/login.php -->
<?php require_once __DIR__ . '/../../../core/helpers/showError.php'; ?>

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <h2 class="mb-4">Iniciar Sesión</h2>
    <form method="POST" action="http://localhost/keys/public/?c=auth&a=login">
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
  </div>
</div>
<?php
if (isset($_SESSION['errors'])) {
  showError($_SESSION['errors']); // limpiar después de mostrar
  unset($_SESSION['errors']);
  session_destroy();
}



?>