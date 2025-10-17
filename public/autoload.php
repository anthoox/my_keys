<?php

function autoload($class_name)
{
    include __DIR__ . '/../app/controllers/' . $class_name . '.php';
}

spl_autoload_register('autoload');
