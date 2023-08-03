<?php

use app\Router;

spl_autoload_register(function (string $class) {
    $path = '../' . str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');

    if (file_exists($path)) {
        require $path;
    } else {
        echo 'Class not found ' . $path;
    }
});

$router = new Router;

$router->run();