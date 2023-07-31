<?php

namespace app;

use app\View;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    function __construct()
    {
        $routes = require '../routes/web.php';

        foreach ($routes as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params): void
    {
        $route = '#^' . $route . '$#';

        $this->routes[$route] = $params;
    }

    function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                $this->params['id'] = $matches['id'];
                return true;
            }
        }
        return false;
    }

    function run(): void
    {
        if ($this->match()) {
            $controllerPath = 'app\Controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($controllerPath)) {
                $action = $this->params['action'];

                if (method_exists($controllerPath, $action)) {
                    $controller = new $controllerPath($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        };
    }
}