<?php
require_once __DIR__ . '/../../core/config/config.php';

class UsersController {


  public function account(){

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " .  BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Cargar el modelo
    require_once __DIR__ . '/../models/UsersModel.php';
    $service_model = new UsersModel();
    $user_id = $_SESSION['user']['user_id'];
    $user_data = $service_model->getUserData($user_id);

    if(!empty($user_data)){
      // mostrar datos de usuario
      require_once __DIR__ . '/../../core/helpers/renderDataUser.php';
      renderDataUser($user_data);
      // die();
    }else{
      $_SESSION['errors'] = "Error al cargar los servicios.";
    }
    require_once __DIR__ . '/../views/users/account.php';
    die();
  }

  public function editUserData() {

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " .  BASE_URL . "/?c=auth&a=login");
      exit();
    }
/**
 * TODO MOSTRAR ERRORES
 */
    // Verificar que llegue el ID
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      session_start();

      $id = $_POST['userId'] ?? null;
      $user_name = $_POST['username'] ?? '';
      $email = $_POST['email'] ?? '';

      if ($id) {
        $model = new UsersModel();
        $updated = $model->editUserData($id, $user_name, $email);

        if ($updated) {
          $_SESSION['success_message'] = "Datos actualizados correctamente.";
        } else {
          $_SESSION['error_message'] = "No se realizaron cambios o ocurrió un error al actualizar.";
        }

        header("Location: " .  BASE_URL . "/?c=users&a=account");
        exit;
      } else {
        $_SESSION['error_message'] = "Error: falta el ID del usuario.";
        header("Location: " .  BASE_URL . "/?c=users&a=account");
        exit;
      }
    }
  }

  public function changeMasterPassword()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " .  BASE_URL . "/?c=auth&a=login");
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


      $user_id = $_SESSION['user']['user_id'] ?? null;
      $old_password = $_POST['old_password'] ?? '';
      $new_password = $_POST['new_password'] ?? '';
      $confirm_password = $_POST['confirm_password'] ?? '';


      if (!$user_id) {
        $_SESSION['error_message'] = "No se ha podido identificar al usuario.";
        header("Location: " .  BASE_URL . "/?c=users&a=account");
        exit;
      }

      // Validaciones básicas
      if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
        header("Location: " .  BASE_URL . "/?c=users&a=account");
        exit;
      }

      if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "Las contraseñas nuevas no coinciden.";
        header("Location: " .  BASE_URL . "/?c=users&a=account");
        exit;
      }

      // Llamamos al modelo
      require_once __DIR__ . '/../models/UsersModel.php';
      $model = new UsersModel();
      $success = $model->changeUserPassword($user_id, $old_password, $new_password);

      if ($success) {
        $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
      } else {
        $_SESSION['error_message'] = "La contraseña actual es incorrecta o ha ocurrido un error.";
      }

      header("Location: " .  BASE_URL . "/?c=users&a=account");
      exit;
    }
  }
}