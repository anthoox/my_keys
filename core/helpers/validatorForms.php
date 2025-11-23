<?php

/**
 * Valida y sanitiza los campos del formulario de autenticación (login o registro).
 *
 * Esta función:
 *  - Sanitiza username, email y password.
 *  - Valida formato de usuario (cuando está presente).
 *  - Valida email y contraseña.
 *  - Devuelve solo los datos correctos.
 *  - Guarda los errores en $_SESSION['errors'].
 *
 * @return array|null Devuelve los datos válidos o null si no es POST.
 */
function validateAuthForm()
{
  require_once __DIR__ . '/../../core/helpers/showError.php';

  $errors = [];
  $data   = [];

  // Procesar solo si se envió un formulario por POST
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**
     * --- Validación del nombre de usuario (solo si viene en el formulario) ---
     * Esto permite usar la misma función tanto para login como para registro.
     */
    if (isset($_POST['username'])) {

      $username = trim($_POST['username'] ?? '');
      $pattern  = "/^[a-zA-Z0-9_.-]+$/";

      if (empty($username)) {
        $errors['username'] = "El nombre de usuario es obligatorio.";
      } elseif (strlen($username) < 3) {
        $errors['username'] = "El nombre de usuario debe tener al menos 3 caracteres.";
      } elseif (!preg_match($pattern, $username)) {
        $errors['username'] = "El nombre de usuario solo puede contener letras, números y ciertos símbolos.";
      } else {
        $data['username'] = $username;
      }
    }

    // Sanitizar email y contraseña
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // --- Validación del email ---
    if (empty($email)) {
      $errors['email'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "El correo no tiene un formato válido.";
    } else {
      $data['email'] = $email;
    }

    // --- Validación de contraseña ---
    if (empty($password)) {
      $errors['password'] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 6) {
      $errors['password'] = "La contraseña debe tener al menos 6 caracteres.";
    } else {
      $data['password'] = $password;
    }

    // Guardar errores en sesión si existen
    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
    }

    // Siempre devolver los datos sanitizados (aunque falten campos)
    return $data;
  }

  return null;
}



/**
 * Valida el formulario de creación/edición de servicios (contraseñas, usuario, categoría, etc).
 *
 * Esta función:
 *  - Solo procesa datos si la petición es POST.
 *  - Valida campos obligatorios: service_name, password, user_name.
 *  - Sanitiza todos los datos recibidos.
 *  - Permite category y notes como opcionales.
 *  - Guarda errores en $_SESSION['errors'].
 *
 * @return array|null Devuelve datos válidos o null si hay errores o no es POST.
 */
function validateServiceForm()
{
  require_once __DIR__ . '/../../core/helpers/showError.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return null;
  }

  $errors = [];
  $data   = [];

  // Sanitización de inputs
  $serviceName = trim($_POST['service_name'] ?? '');
  $password    = trim($_POST['password'] ?? '');
  $userName    = trim($_POST['user_name'] ?? '');
  $category    = trim($_POST['category'] ?? '');
  $notes       = trim($_POST['notes'] ?? '');

  // --- Validar nombre del servicio ---
  if (empty($serviceName)) {
    $errors['service_name'] = "El nombre del servicio es obligatorio.";
  } else {
    $data['service_name'] = $serviceName;
  }

  // --- Validar contraseña ---
  if (empty($password)) {
    $errors['password'] = "La contraseña es obligatoria.";
  } else {
    $data['password'] = $password;
  }

  // --- Validar nombre de usuario ---
  if (empty($userName)) {
    $errors['user_name'] = "El nombre de usuario es obligatorio.";
  } else {
    $data['user_name'] = $userName;
  }

  // Campos opcionales
  $data['category'] = $category ?: null;
  $data['notes']    = $notes ?: null;

  // Si existen errores, guardarlos y devolver null
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    return null;
  }

  return $data;
}
