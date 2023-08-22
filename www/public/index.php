<?php

namespace jiggle\public;

use jiggle\app\Core\Router;

spl_autoload_register(function (string $className) {
    $namespacePrefix = 'jiggle\\';
    $baseDirectory = dirname(__DIR__) . '/';
    $prefixLength = strlen($namespacePrefix);

    if (strncmp($namespacePrefix, $className, $prefixLength) !== 0) {
        return;
    }

    $relativeClassName = substr($className, $prefixLength);
    $classFile = $baseDirectory . str_replace('\\', '/', $relativeClassName) . '.php';

    if (file_exists($classFile)) {
        require $classFile;
    } else {
        echo 'Class not found ' . $classFile;
    }
});

$router = new Router;

$router->run();