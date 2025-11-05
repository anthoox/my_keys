<div class="container  col-sm-12 col-md-6">
  <h1 class="mt-5">Mi cuenta</h1>
  <form method="post" class="row g-3 mt-3" action="http://localhost/keys/public/?c=users&a=editUserData">
    <div class=" mb-3">
      <label for="formGroupExampleInput" class="form-label">Usuario</label>
      <input type="text" class="form-control" id="formGroupExampleInput" placeholder="nombre" name="username">
    </div>
    <div class="mb-3">
      <label for="formGroupExampleInput2" class="form-label">Email</label>
      <input type="email" class="form-control" id="formGroupExampleInput2" placeholder="correo@correo.com" name="email">
    </div>
    <input type="hidden" name="userId" id="editUserId">


    <div class="col-12">
      <label for="inputAddress" class="form-label">Registrado</label>
      <input type="text" class="form-control" id="inputAddress" placeholder="26/10/2025" disabled>
    </div>

    <div class="col-6 mt-5">
      <button type="submit" class="btn btn-primary col-12">Guardar</button>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary col-6 mt-5" data-bs-toggle="modal" data-bs-target="#warningModal">
      Cambiar contraseña
    </button>
    <div class="col-12 mt-2">
      <button type="button" class="btn btn-danger col-12">Eliminar cuenta</button>
    </div>
  </form>


  <!-- Modal 1: Advertencia -->
  <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="warningModalLabel">Contraseña Maestra</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <strong>¡Atención!</strong> Vas a cambiar la contraseña maestra de la aplicación.<br>
          Por seguridad, recibirás un correo electrónico para confirmar el cambio.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="openChangePasswordModal">
            Cambiar contraseña
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 2: Cambio de contraseña -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="http://localhost/keys/public/?c=auth&a=changeMasterPassword">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña Maestra</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="oldPassword" class="form-label">Contraseña actual</label>
              <input type="password" class="form-control" id="oldPassword" name="old_password" required>
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">Nueva contraseña</label>
              <input type="password" class="form-control" id="newPassword" name="new_password" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>


</div>

<?= require_once __DIR__  . '/../../../core/components/footer.php' ?>