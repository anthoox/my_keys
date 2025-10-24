<?php

function validateRegistrationForm()
{
  require_once __DIR__ . '/../../core/helpers/showError.php';

  // Validación del formulario
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $errors = [];
    $data = [];
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
