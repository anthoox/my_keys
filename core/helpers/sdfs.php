<div class='container  col-sm-12 col-md-6'>
  <h1 class='mt-5'>Mi cuenta</h1>
  <!-- cambiar metodo al que se envia -->
  <form method='post' class='row g-3 mt-3' action='http://localhost/keys/public/?c=users&a=getUserData'>
    <div class=' mb-3'>
      <label for='formGroupExampleInput' class='form-label'>Nombre de usuario</label>
      <input type='text' class='form-control' id='formGroupExampleInput' placeholder='nombre' name='username'>
    </div>
    <div class='mb-3'>
      <label for='formGroupExampleInput2' class='form-label'>Email</label>
      <input type='email' class='form-control' id='formGroupExampleInput2' placeholder='correo@correo.com' name='email'>
    </div>
    <input type='hidden' name='userId' id='editUserId'>


    <div class='col-12'>
      <label for='inputAddress' class='form-label'>Registrado</label>
      <input type='text' class='form-control' id='inputAddress' placeholder='26/10/2025' disabled>
    </div>

    <div class='col-6 mt-5'>
      <button type='submit' class='btn btn-primary col-12'>Guardar</button>
    </div>
    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary col-6 mt-5' data-bs-toggle='modal' data-bs-target='#warningModal'>
      Cambiar contraseña
    </button>
    <div class='col-12 mt-2'>
      <button type='button' class='btn btn-danger col-12'>Eliminar cuenta</button>
    </div>
  </form>