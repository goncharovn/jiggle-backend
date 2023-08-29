<?php

namespace jiggle\app\Core;

class View
{
    public static function make(string $templateName, array $templateData = [])
    {
        $templateFile = dirname(__DIR__) . '/Views/templates/' . $templateName . '.php';

        if (file_exists($templateFile)) {
            ob_start();
            extract($templateData);
            require $templateFile;
            return (string) ob_get_clean();
        } else {
            return "File not found: $templateFile";
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