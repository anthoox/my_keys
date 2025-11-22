<?php
require_once __DIR__ . '/../../core/config/config.php';
require_once __DIR__ . '/../../core/helpers/startSesion.php';



class UsersController
{

  /**
   * Muestra la página de cuenta del usuario.
   * Carga los datos desde el modelo y los envía a la vista.
   */
  public function account()
  {
    startSession();

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    require_once __DIR__ . '/../models/UsersModel.php';
    $userModel = new UsersModel();
    $user_id   = $_SESSION['user']['user_id'];

    // Obtener datos del usuario
    $user_data = $userModel->getUserData($user_id);

    if (!empty($user_data)) {
      require_once __DIR__ . '/../../core/helpers/renderDataUser.php';
      renderDataUser($user_data);
    } else {
      $_SESSION['errors'] = "Error al cargar los datos del usuario.";
    }

    require_once __DIR__ . '/../views/users/account.php';
    exit();
  }


  /**
   * Procesa el formulario de edición de nombre/email del usuario.
   */
  public function editUserData()
  {
    startSession();

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Solo permite POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: " . BASE_URL . "/?c=users&a=account");
      exit();
    }

    $id        = $_POST['userId'] ?? null;
    $user_name = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');

    if (!$id) {
      $_SESSION['error_message'] = "Error: falta el ID del usuario.";
      header("Location: " . BASE_URL . "/?c=users&a=account");
      exit();
    }

    require_once __DIR__ . '/../models/UsersModel.php';
    $model = new UsersModel();

    $updated = $model->editUserData($id, $user_name, $email);

    if ($updated) {
      $_SESSION['success_message'] = "Datos actualizados correctamente.";
    } else {
      $_SESSION['error_message'] = "No se realizaron cambios o ocurrió un error al actualizar.";
    }

    header("Location: " . BASE_URL . "/?c=users&a=account");
    exit();
  }


  /**
   * Permite al usuario cambiar su contraseña.
   */
  public function changeMasterPassword()
  {
    startSession();

    // Verificar autenticación
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: " . BASE_URL . "/?c=auth&a=login");
      exit();
    }

    // Solo POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: " . BASE_URL . "/?c=users&a=account");
      exit();
    }

    $user_id          = $_SESSION['user']['user_id'];
    $old_password     = $_POST['old_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validaciones básicas
    if (!$old_password || !$new_password || !$confirm_password) {
      $_SESSION['error_message'] = "Todos los campos son obligatorios.";
      header("Location: " . BASE_URL . "/?c=users&a=account");
      exit();
    }

    if ($new_password !== $confirm_password) {
      $_SESSION['error_message'] = "Las contraseñas nuevas no coinciden.";
      header("Location: " . BASE_URL . "/?c=users&a=account");
      exit();
    }

    require_once __DIR__ . '/../models/UsersModel.php';
    $model = new UsersModel();

    $password_changed = $model->changeUserPassword($user_id, $old_password, $new_password);

    if ($password_changed) {
      $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
    } else {
      $_SESSION['error_message'] = "La contraseña actual es incorrecta o ha ocurrido un error.";
    }

    header("Location: " . BASE_URL . "/?c=users&a=account");
    exit();
  }
}
