<?php
spl_autoload_register(function ($class) {
    $classPath = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($classPath)) {
        include_once $classPath;
    }
});
