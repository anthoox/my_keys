<?php
// public/autoload.php

spl_autoload_register(function ($class_name) {

    // Rutas donde buscar las clases
    $paths = [
        __DIR__ . '/../app/controllers/' . $class_name . '.php',
        __DIR__ . '/../app/models/'      . $class_name . '.php',
        __DIR__ . '/../core/'            . $class_name . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }

    // Mensaje de error si la clase no se encuentra
    echo "❌ No se encontró la clase: $class_name<br>";
});
