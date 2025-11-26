<?php
// public/index.php

/**
 * Punto de entrada de la aplicación.
 * 
 * Funciona de dos formas:
 * 1. Si no hay parámetros en la URL → carga directamente la vista de inicio (home/index.php)
 * 2. Si hay parámetros 'c' (controlador) y 'a' (acción) → instancia el controlador y ejecuta la acción
 */

require_once __DIR__ . '/autoload.php';

// MODO DEBUG (true = muestra errores, false = limpio para producción)
define('DEBUG_MODE', false);

// Configuración de errores según modo debug
if (!DEBUG_MODE) {
  ini_set('display_errors', 0);
  error_reporting(0);
}

// Función de redirección al login (para compatibilidad con URLs inválidas)
function redirectToLogin(): void
{
  header("Location: " . FULL_BASE_URL . "/?c=home&a=index");
  exit();
}

/**
 * Si no hay parámetros GET → mostramos la vista home directamente
 * Esto permite que al entrar a 'public/' se vea la pantalla de inicio sin controlador.
 */
if (empty($_GET)) {
  require_once '../app/views/layout/main.php'; // Layout general (nav, footer, etc.)
  require_once '../app/views/home/index.php';  // Vista de inicio
  exit();
}

// Layout general (si vamos a cargar controlador)
require_once '../app/views/layout/main.php';

// Si no viene el controlador → redirige a login
if (!isset($_GET['c'])) {
  if (DEBUG_MODE) {
    // echo "Controlador no especificado";
  }
  redirectToLogin();
}

// Nombre del controlador
$controller_name = $_GET['c'] . 'Controller';

// Verificar existencia del controlador
if (!class_exists($controller_name)) {
  if (DEBUG_MODE) {
    echo "Controlador '$controller_name' no existe";
  }
  redirectToLogin();
}

// Instanciar el controlador
$controller = new $controller_name();

// Verificar existencia de la acción
if (!isset($_GET['a']) || !method_exists($controller, $_GET['a'])) {
  if (DEBUG_MODE) {
    echo "La acción solicitada no existe";
  }
  redirectToLogin();
}

// Ejecutar acción
$action = $_GET['a'];
$controller->$action();
