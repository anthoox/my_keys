<!-- Modal añadir servicio -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/keys/public/?c=services&a=store" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceModalLabel">Añadir nuevo servicio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="service_name" class="form-label">Nombre del servicio</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
          </div>
          <div class="mb-3">
            <label for="user_name" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <!-- <div class="mb-3">
            <label for="category" class="form-label">Categoría (opcional)</label>
            <input type="text" class="form-control" id="category" name="category">
          </div> -->

          <div class="mb-3">
            <label for="notes" class="form-label">Notas (opcional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal para editar servicio -->

<div class="modal fade " id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editServiceForm" method="POST" action="<?= FULL_BASE_URL ?>/?c=services&a=editService">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editServiceModalLabel">Editar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="service_id" id="editServiceId">
          <div class="mb-3">
            <label for="editServiceName" class="form-label">Nombre del servicio</label>
            <input type="text" class="form-control" id="editServiceName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="editServiceUser" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="editServiceUser" name="user" required>
          </div>
          <div class="mb-3">
            <label for="editServicePassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="editServicePassword" name="password">
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
<!-- Modal para eliminar sevicio -->

<div class="modal fade " id="delServiceModal" tabindex="-1" aria-labelledby="delServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="delServiceForm" method="POST" action="<?= FULL_BASE_URL ?>/?c=services&a=delService">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="delServiceModalLabel">Eliminar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar esta contaseña?</p>
          <input type="hidden" name="service_id" id="deleteServiceId" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>