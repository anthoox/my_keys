<!-- view: auth/register.php -->
<?php require_once __DIR__ . '/../../../core/helpers/showError.php'; ?>

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <h2 class="mb-4">Crear cuenta</h2>
    <form method="post" action="<?= FULL_BASE_URL ?>/?c=auth&a=register">
      <div class=" mb-3">
        <label for="username" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Nombre">
      </div>
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