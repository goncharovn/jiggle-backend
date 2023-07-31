<?php

use app\Router;

spl_autoload_register(function ($class) {
    $path = '../' . str_replace('\\', '/', $class . '.php');

    if (file_exists($path)) {
        require $path;
    } else {
        echo 'Class not found ' . $path . '</br>';
    }
});

$router = new Router;

$router->run();