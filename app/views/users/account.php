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

<?php require_once __DIR__  . '/../../../core/components/footer.php' ?>