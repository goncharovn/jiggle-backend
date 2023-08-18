<?php

namespace app;

use database\Db;

class Router
{
    protected array $routes = [];
    protected array $requestParams = [];

    public function __construct()
    {
        $routes = require '../routes/web.php';

        foreach ($routes as $route => $params) {
            $this->routes[$route] = $params;
        }
    }

    public function run(): void
    {
        Db::getInstance();

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
                $this->requestParams['product_id'] = $matches['id'];

                return true;
            }
        }

        return false;
    }
}