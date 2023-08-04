<?php

namespace app;

class Router
{
    protected array $routes = [];
    protected array $requestParams = [];

    public function __construct()
    {
        $routes = require '../routes/web.php';

        foreach ($routes as $route => $params) {
            $this->addRoute($route, $params);
        }
    }

    public function addRoute($route, $params): void
    {
        $route = '#^' . $route . '$#';

        $this->routes[$route] = $params;
    }

    public function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');

        $urlWithoutQueryString = preg_replace('/\?.*/', '', $url);

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $urlWithoutQueryString, $matches)) {
                $this->requestParams = $params;
                $this->requestParams['id'] = $matches['id'];

                return true;
            }
        }

        return false;
    }

    public function run(): void
    {
        if ($this->match()) {
            $controllerClass = __NAMESPACE__ . '\Controllers\\' . ucfirst($this->requestParams['controller']) . 'Controller';

            if (class_exists($controllerClass)) {
                $action = $this->requestParams['action'];

                if (method_exists($controllerClass, $action)) {
                    $controller = new $controllerClass($this->requestParams);
                    $controller->$action();
                }
            }
        } else {
            View::errorCode(404);
        }
    }
}