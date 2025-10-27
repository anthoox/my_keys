<div class="container  col-sm-12 col-md-6">
  <h1 class="mt-5">Mi cuenta</h1>
  <form class="row g-3 mt-3">
    <div class="mb-3">
      <label for="formGroupExampleInput" class="form-label">Usuario</label>
      <input type="text" class="form-control" id="formGroupExampleInput" placeholder="nombre">
    </div>
    <div class="mb-3">
      <label for="formGroupExampleInput2" class="form-label">Email</label>
      <input type="email" class="form-control" id="formGroupExampleInput2" placeholder="correo@correo.com">
    </div>

    <div class="col-12">
      <label for="inputAddress" class="form-label">Registrado</label>
      <input type="text" class="form-control" id="inputAddress" placeholder="26/10/2025" disabled>
    </div>

    <div class="col-6 mt-5">
      <button type="submit" class="btn btn-primary col-12">Guardar</button>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger col-6 mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Cambiar contraseña
    </button>
  </form>



  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Contraseña Maestra</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          !Atencion! Va a cambiar la contraseña maestra de la aplicación. Por su seguridad, enviaremos un email a su correo electronico para que valide el cambio de contraseña.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Enviar email</button>
        </div>
      </div>
    </form>
  </div>


</div>

<?= require_once __DIR__  . '/../../../core/components/footer.php' ?>