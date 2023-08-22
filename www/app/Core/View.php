<?php

namespace jiggle\app\Core;

use jiggle\app\AccessManager;

class View
{
    public string $layout = 'default';

    public function render($template, $title, $vars = []): void
    {
        extract($vars);

        $isUserLoggedIn = AccessManager::isUserLoggedIn();
        $viewPath = dirname(__DIR__) . '/Views/' . $template . '.php';

        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            require dirname(__DIR__) . '/Views/layouts/' . $this->layout . '.php';
        }
    }

    public static function showErrorPage($code): void
    {
        http_response_code($code);

        $errorViewPath = '../app/Views/errors/' . $code . '.php';
        if (file_exists($errorViewPath)) {
            require $errorViewPath;
        }
    }
}