<!-- view: services/services.php -->

<?php
// Mostrar mensaje de éxito si existe
if (!empty($_SESSION['success_message'])) {
  echo "
      <div id='cnt-error' class='d-flex justify-content-center align-items-center w-100 mt-3 position-absolute top-50 start-50 translate-middle'>
        <div class='alert alert-success col-4'>{$_SESSION['success_message']}
        </div>
      </div>";
  unset($_SESSION['success_message']); // Limpiar después de mostrar
}

// Mostrar mensaje de error si existe
if (!empty($_SESSION['error_message'])) {
  echo "
      <div id='cnt-error' class='d-flex justify-content-center align-items-center w-100 mt-3 position-absolute top-50 start-50 translate-middle'>
        <div class='alert alert-danger col-6'>{$_SESSION['error_message']}
        </div>
      </div>";
  unset($_SESSION['error_message']); // Limpiar después de mostrar
}
?>

<!-- Cierre del contenedor abierto en layout/main.php -->
</div>

<!-- Botón flotante para añadir servicio -->
<div class="position-fixed" style="bottom: 40px; right: 40px;">
  <button type="button" class="btn btn-primary rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#addServiceModal" aria-label="Añadir servicio">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 16 16">
      <path fill="#fbfbfb" d="M8 15c-3.86 0-7-3.14-7-7s3.14-7 7-7s7 3.14 7 7s-3.14 7-7 7M8 2C4.69 2 2 4.69 2 8s2.69 6 6 6s6-2.69 6-6s-2.69-6-6-6" />
      <path fill="#fbfbfb" d="M8 11.5c-.28 0-.5-.22-.5-.5V5c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5" />
      <path fill="#fbfbfb" d="M11 8.5H5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h6c.28 0 .5.22.5.5s-.22.5-.5.5" />
    </svg>
  </button>
</div>


<?php

// Incluir los modales relacionados con servicios (añadir, editar, eliminar)
require_once __DIR__ . '/../../../app/views/components/modals/modalsServices.php';

?>