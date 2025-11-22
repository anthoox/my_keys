<?php

function validateAuthForm()
{
  require_once __DIR__ . '/../../core/helpers/showError.php';
  $errors = [];
  $data = [];
  // Validación del formulario
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username'])){
      $username = trim($_POST['username'] ?? '');
      // Validar usuario
      $pattern = "/^[a-zA-Z0-9_.-]+$/";
      if (empty($username)) {
        $errors['username'] = "El nombre de usuario es obligatorio.";
      } elseif (strlen($username) < 3) {
        $errors['username'] = "El nombre de usuario debe tener al menos 3 caracteres.";
      } elseif (!preg_match($pattern, $username)) {
        $errors['username'] = "El nombre de usuario solo puede contener letras, números y caracteres especiales, sin espacios.";
      } else {
        $data['username'] = $username;
      }
    }
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');




    // Validar email
    if (empty($email)) {
      $errors['email'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "El correo no tiene un formato válido.";
    } else {
      $data['email'] = $email;
    }

    // Validar contraseña
    if (empty($password)) {
      $errors['password'] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 6) {
      $errors['password'] = "La contraseña debe tener al menos 6 caracteres.";
    } else {
      $data['password'] = $password;
    }
    // Guardar errores en sesión si existen
    if (isset($errors)) {
      $_SESSION['errors'] = $errors;
    }

    if (isset($errors)) {
      return $data;
    }
  }
}
function validateServiceForm()
{
  require_once __DIR__ . '/../../core/helpers/showError.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return null;
  }

  $errors = [];
  $data = [];

  $serviceName = trim($_POST['service_name'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $userName = trim($_POST['user_name'] ?? '');
  $category = trim($_POST['category'] ?? '');
  $notes = trim($_POST['notes'] ?? '');

  // Validar nombre del servicio
  if (empty($serviceName)) {
    $errors['service_name'] = "El nombre del servicio es obligatorio.";
  } else {
    $data['service_name'] = $serviceName;
  }

  // Validar contraseña
  if (empty($password)) {
    $errors['password'] = "La contraseña es obligatoria.";
  } else {
    $data['password'] = $password;
  }

  if (empty($userName)) {
    $errors['user_name'] = "El nombre de usuario es obligatorio.";
  } else {
    $data['user_name'] = $userName;
  }

  // Asignar categoría y notas (permitir valores nulos)
  $data['category'] = $category ?: null;
  $data['notes'] = $notes ?: null;

  // Si hay errores, guardarlos y devolver null
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    return null;
  }

  // Devolver datos válidos
  return $data;
}
