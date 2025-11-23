<?php

/**
 * * Inicio de sesión tras el login ya que al redirigir con header() pierde la sesión 
 * */
require_once __DIR__ . '/../../../core/config/config.php';
require_once __DIR__ . '/../../../core/helpers/startSesion.php';

startSession();

require_once __DIR__ . '/../../views/components/header.php'; 

?>
<div class="container mt-4">