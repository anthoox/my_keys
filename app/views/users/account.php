<?php

/**
 * Vista de la cuenta del usuario
 * 
 * Esta vista muestra mensajes de éxito o error almacenados en la sesión
 * y carga los modales relacionados con la gestión de usuarios.
 * 
 * Requisitos:
 * - $_SESSION['success_message']: Mensaje de éxito opcional
 * - $_SESSION['error_message']: Mensaje de error opcional
 * - modalsUsers.php: Modales relacionados con usuarios (cambiar contraseña, etc.)
 */

// Mostrar mensaje de éxito si existe
if (!empty($_SESSION['success_message'])) {
  echo "
      <div id='cnt-error' class='d-flex justify-content-center align-items-center w-100 mt-3'>
        <div class='alert alert-success col-6'>{$_SESSION['success_message']}
        </div>
      </div>";
  unset($_SESSION['success_message']); // Limpiar después de mostrar
}

// Mostrar mensaje de error si existe
if (!empty($_SESSION['error_message'])) {
  echo "
      <div id='cnt-error' class='d-flex justify-content-center align-items-center w-100 mt-3'>
        <div class='alert alert-danger col-6'>{$_SESSION['error_message']}
        </div>
      </div>";
  unset($_SESSION['error_message']); // Limpiar después de mostrar
}
?>

</div> <!-- Cierre de container principal -->
</div> <!-- Cierre de row u otra estructura de layout -->

<?php
/**
 * Incluir los modales relacionados con los usuarios
 * Ejemplo: cambio de contraseña, advertencias, etc.
 */
require_once __DIR__  . '/../../../app/views/components/modals/modalsUsers.php';
?>