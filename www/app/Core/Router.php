<?php

namespace jiggle\app\Core;

use jiggle\database\Db;

class Router
{
    protected array $routes = [];
    protected array $requestParams = [];

    public function __construct()
    {
        $this->routes = require dirname(__FILE__, 3) . '/routes/web.php';
    }

    public function run(): void
    {
        Db::getInstance();
        session_start();

        if ($this->match()) {
            $controllerClass = $this->requestParams['controller'];

            if (class_exists($controllerClass)) {
                $action = $this->requestParams['action'];

                if (method_exists($controllerClass, $action)) {
                    $controller = new $controllerClass($this->requestParams);
                    $controller->$action();
                }
            }
        } else {
            View::showErrorPage(404);
        }
    }

    private function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $urlWithoutQueryString = preg_replace('/\?.*/', '', $url);

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $urlWithoutQueryString, $matches)) {
                $this->requestParams = $params;
                $this->requestParams['product_id'] = (int)$matches['id'];

                return true;
            }
        }

        return false;
    }
}