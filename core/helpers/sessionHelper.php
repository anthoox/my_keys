<?php

/**
 * Maneja el cierre de sesión por inactividad.
 *
 * @param int $timeout Tiempo máximo de inactividad en segundos (por defecto 10 minutos)
 */
function handleSessionTimeout(int $timeout = 600): void
{
  // Si no hay sesión iniciada, salir
  if (!isset($_SESSION['user'])) {
    return;
  }

  // Si es la primera actividad, registrarla
  if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
    return;
  }

  // Calcular inactividad
  $inactivity = time() - $_SESSION['last_activity'];

  // Si supera el límite → cerrar sesión
  if ($inactivity > $timeout) {
    session_unset();
    session_destroy();
    header("Location: " . FULL_BASE_URL . "/?c=auth&a=login&timeout=1");
    exit();
  }

  // Si no supera → actualizar el tiempo
  $_SESSION['last_activity'] = time();
}
