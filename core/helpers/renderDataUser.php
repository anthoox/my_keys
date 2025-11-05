<?php
function renderDataUser(object $user_data){

  echo '<div class="container">
  <div class="row g-4">';

  if (empty($user_data)) {
    echo "<p class='text-center text-muted'>Error al cargar cuenta</p>";
    echo '</div></div>'; // cerramos container aunque no haya servicios
    return;
    
  }


    $user_id = htmlspecialchars($user_data->getId());
    $user_name = htmlspecialchars($user_data->getUsername());
    $user_email = htmlspecialchars($user_data->getEmail());

    $created_at_raw = $user_data->getCreatedAt();
    $created_at = $created_at_raw ? date('Y-m-d', strtotime($created_at_raw)) : 'Sin fecha';

    echo "
    <div class='container  col-sm-12 col-md-6'>
      <h1 class='mt-5'>Mi cuenta</h1>
      <!-- cambiar metodo al que se envia -->
      <form method='post' class='row g-3 mt-3' action='http://localhost/keys/public/?c=users&a=editUserData'>
        <div class=' mb-3'>
          <label for='formGroupExampleInput' class='form-label'>Nombre de usuario</label>
          <input type='text' class='form-control' id='formGroupExampleInput' value='$user_name' name='username'>
        </div>
        <div class='mb-3'>
          <label for='formGroupExampleInput2' class='form-label'>Email</label>
          <input type='email' class='form-control' id='formGroupExampleInput2' value='$user_email' name='email'>
        </div>
        <input type='hidden' name='userId' id='editUserId' value='$user_id'>
        <div class='col-12'>
        <label for='inputAddress' class='form-label'>Registrado</label>
        <input type='text' class='form-control' id='inputAddress' placeholder='$created_at' disabled>
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
    ";
  
  echo '</div>'; // Cierra row
}