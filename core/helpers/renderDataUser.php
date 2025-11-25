<?php
require_once __DIR__ . '/../config/config.php';

/**
 * Renderiza los datos de un usuario en un formulario para editar su información.
 *
 * @param object|null $user_data Objeto usuario que debe implementar métodos getId(), getUsername(), getEmail(), getCreatedAt().
 */
function renderDataUser(?object $user_data): void
{
  echo '<div class="container">
    <div class="row g-4">';

  if (empty($user_data)) {
    echo "<p class='text-center text-muted'>Error al cargar cuenta</p>";
    echo '</div></div>'; // Cerramos container aunque no haya datos
    return;
  }

  // Escapar datos para evitar XSS
  $user_id = htmlspecialchars($user_data->getId(), ENT_QUOTES, 'UTF-8');
  $user_name = htmlspecialchars($user_data->getUsername(), ENT_QUOTES, 'UTF-8');
  $user_email = htmlspecialchars($user_data->getEmail(), ENT_QUOTES, 'UTF-8');

  $created_at_raw = $user_data->getCreatedAt();
  $created_at = $created_at_raw ? date('Y-m-d', strtotime($created_at_raw)) : 'Sin fecha';

  // Renderizado del formulario
  echo "
    <div class='container col-sm-12 col-md-6'>
      <h1 class='mt-5'>Mi cuenta</h1>
      <form method='post' class='row g-3 mt-3' action='" . FULL_BASE_URL . "/?c=users&a=editUserData'>
        <div class='mb-3'>
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

        <!-- Botón para modal de cambio de contraseña -->
        <button type='button' class='btn btn-primary col-6 mt-5' data-bs-toggle='modal' data-bs-target='#warningModal'>
          Cambiar contraseña
        </button>

        <div class='col-12 mt-2'>
  <button 
    type='button' 
    class='btn btn-danger col-12' 
    data-bs-toggle='modal' 
    data-bs-target='#deleteUserModal'
    data-user-id='$user_id'>
    Eliminar cuenta
  </button>
</div>

      </form>
    </div>";

  echo '</div>'; // Cierra row
}
