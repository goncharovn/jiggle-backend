<?php

namespace app;

class View
{
    public array $route;
    public string $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function render($template, $title, $vars = []): void
    {
        extract($vars);

        $viewPath = '../app/Views/' . $template . '.php';

        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            require 'Views/layouts/' . $this->layout . '.php';
        }
    }

    public static function errorCode($code): void
    {
        http_response_code($code);

        $errorViewPath = '../app/Views/errors/' . $code . '.php';
        if (file_exists($errorViewPath)) {
            require $errorViewPath;
        }
    }
}