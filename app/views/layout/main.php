<?php

/**
 * * Inicio de sesión tras el login ya que al redirigir con header() pierde la sesión 
 * */
require_once __DIR__ . '/../../../core/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestor de Claves</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= FULL_BASE_URL ?>/css/style.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gestor de Claves</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto d-flex align-items-center">

          <?php if (isset($_SESSION['user'])) : ?>
            <li class="nav-item"><a class="nav-link" href="<?= FULL_BASE_URL ?>/?c=services&a=alls">Inicio</a></li>

            <li class="nav-item"><a class="nav-link" href="<?= FULL_BASE_URL ?>/?c=users&a=account">Mi cuenta</a></li>

            <li class="nav-item"><a class="nav-link" href="<?= FULL_BASE_URL ?>/?c=auth&a=logout">Salir</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= FULL_BASE_URL ?>/?c=auth&a=login">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= FULL_BASE_URL ?>/?c=auth&a=register">Registro</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">