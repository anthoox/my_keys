<?php

class UsersController {


  public function account()
  {

    require_once __DIR__ . '/../views/users/account.php';
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
      $id = $_POST['userId'] ?? null;
      $user_name = $_POST['username'] ?? null;
      $email = $_POST['email'] ?? null;

      if ($id && $user_name || $email) {

        $model = new UsersModel();

        $updated = $model->editUserData($id, $user_name, $email);

        if ($updated) {
          header("Location: /keys/public/?c=users&a=account");
          exit;
        } else {
          header("Location: /keys/public/?c=users&a=account");
          exit;
        }
      } else {
        header("Location: /keys/public/?c=users&a=account");
        exit;
      }
    }
  }
}