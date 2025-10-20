<!-- public/index.php -->
<!-- Aqui se inicia la aplicacion y redirigue al login -->


<h1>Index</h1>
<?php
require_once __DIR__ . '/autoload.php';


require_once '../app/views/layout.php';

// prueba de conexion a la base de datos
// require_once __DIR__ . '/../core/DataBase.php';

// $db = DataBase::getInstance()->getConnection();

// echo "✅ Conexión establecida correctamente<br>";