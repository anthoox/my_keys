<!-- public/index.php -->
<!-- Aqui se inicia la aplicacion y redirigue al login -->
<?php

require_once __DIR__ . '/autoload.php';

// MODO DEBUG (true = muestra errores, false = limpio para producción)
define('DEBUG_MODE', true);
// Código para manejar controladores y acciones. Página de manejo centralizada.

// Función para redirigir siempre al login
function redirectToLogin()
{
  header("Location: " . FULL_BASE_URL . "/?c=auth&a=login");
  exit();
}

// Evitar que PHP muestre errores en producción
if (!DEBUG_MODE) {
  ini_set('display_errors', 0);
  error_reporting(0);
}

if (empty($_GET)) {
  require_once '../app/views/layout/main.php';
  redirectToLogin();
}

require_once '../app/views/layout/main.php';


// Si no viene "c" en la URL → error → login
if (!isset($_GET['c'])) {
  if (DEBUG_MODE) {
    // echo "Controlador no especificado";
  }
  redirectToLogin();
}

$controller_name = $_GET['c'] . 'Controller';

// Verificar existencia del controlador
if (!class_exists($controller_name)) {
  if (DEBUG_MODE) {
    echo "Controlador '$controller_name' no existe";
  }
  redirectToLogin();
}

$controller = new $controller_name();

// Verificar existencia de la acción
if (!isset($_GET['a']) || !method_exists($controller, $_GET['a'])) {
  if (DEBUG_MODE) {
    echo "La acción solicitada no existe";
  }
  redirectToLogin();
}
// Si todo OK → ejecutar acción
$action = $_GET['a'];
$controller->$action();
