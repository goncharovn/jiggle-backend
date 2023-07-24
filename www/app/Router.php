<?php

namespace app;

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
                return true;
            }
        }
        return false;
    }

    function run(): void
    {
        if ($this->match()) {
            $controller_path = 'app\Controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($controller_path)) {
                $action = $this->params['action'];

                if (method_exists($controller_path, $action)) {
                    $controller = new $controller_path($this->params);
                    $controller->$action();
                }
            } else {
                echo 'Controller Not Found ' . $controller_path . '</br>';
            }
        } else {
            echo '404 Not Found';
        };
    }
}