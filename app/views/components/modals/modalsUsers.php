  <!-- 
  Modales de Contraseña Maestra:

  Modal 1: warningModal
    - Propósito: Advertir al usuario antes de cambiar la contraseña maestra.
    - Contenido: Mensaje de advertencia y botones para cancelar o proceder.
    - Botón "Cambiar contraseña" abre el siguiente modal.

  Modal 2: changePasswordModal
    - Propósito: Permitir al usuario cambiar la contraseña maestra.
    - Formulario:
        Campos:
          - old_password: Contraseña actual
          - new_password: Nueva contraseña
          - confirm_password: Confirmación de nueva contraseña
        Método: POST
        Acción: <?= FULL_BASE_URL ?>/?c=users&a=changeMasterPassword
-->

  <!-- Modal 1: Advertencia -->
  <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5" id="warningModalLabel">Confirmar modificación</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <strong>¡Atención!</strong> Va a cambiar la contraseña de acceso a la aplicación.<br>
          ¿Está seguro de realizar cambios?
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
      <form method="POST" action="<?= FULL_BASE_URL ?>/?c=users&a=changeMasterPassword">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña de Acceso</h5>
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
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal de confirmación de eliminación -->
  <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteUserModalLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form id="deleteUserForm" method="post" action="<?= FULL_BASE_URL ?>/?c=users&a=deleteUser">
            <input type="hidden" name="userId" id="deleteUserId" value="">
            <button type="submit" class="btn btn-danger">Eliminar cuenta</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
  require_once __DIR__  . '/../../../views/components/footer.php'
  ?>