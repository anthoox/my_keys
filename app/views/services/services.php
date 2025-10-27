<!-- view: services/services.php -->

<!-- Ejemplo de tarjeta -->
<div class="container my-5">


</div>
<!-- Botón flotante para añadir servicio -->
<div class="position-fixed" style="bottom: 40px; right: 40px;">
  <button type="button" class="btn btn-primary rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#addServiceModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 16 16">
      <path fill="#fbfbfb" d="M8 15c-3.86 0-7-3.14-7-7s3.14-7 7-7s7 3.14 7 7s-3.14 7-7 7M8 2C4.69 2 2 4.69 2 8s2.69 6 6 6s6-2.69 6-6s-2.69-6-6-6" />
      <path fill="#fbfbfb" d="M8 11.5c-.28 0-.5-.22-.5-.5V5c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5" />
      <path fill="#fbfbfb" d="M11 8.5H5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h6c.28 0 .5.22.5.5s-.22.5-.5.5" />
    </svg>
  </button>
</div>

<!-- Modal de Bootstrap -->
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

          <div class="mb-3">
            <label for="category" class="form-label">Categoría (opcional)</label>
            <input type="text" class="form-control" id="category" name="category">
          </div>

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

</div>

<?= require_once __DIR__  . '/../../../core/components/footer.php' ?>