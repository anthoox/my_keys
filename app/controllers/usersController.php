<?php

class UsersController {


  public function account(){

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Verificar sesión activa
    if (!isset($_SESSION['user']['user_id'])) {
      header("Location: /keys/public/?c=auth&a=login");
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
      header("Location: /keys/public/?c=auth&a=login");
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

        header("Location: /keys/public/?c=users&a=account");
        exit;
      } else {
        $_SESSION['error_message'] = "Error: falta el ID del usuario.";
        header("Location: /keys/public/?c=users&a=account");
        exit;
      }
    }
  }
}