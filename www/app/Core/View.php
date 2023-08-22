<?php

namespace jiggle\app\Core;

use jiggle\app\AccessManager;

class View
{
    public string $layout = 'default';

    public function render(string $templateFile, string $title, array $parameters = []): void
    {
        extract($parameters);

        $isUserLoggedIn = AccessManager::isUserLoggedIn();
        $viewPath = dirname(__DIR__) . '/Views/' . $templateFile . '.php';

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
        $errorViewFile = dirname(__DIR__) . '/Views/errors/' . $code . '.php';

        if (file_exists($errorViewFile)) {
            require $errorViewFile;
        }
    }
}