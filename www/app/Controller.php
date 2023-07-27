<?php

namespace app;

use database\Db;

use app\Models;

abstract class Controller
{
    public array $route;
    public View $view;

    public Model $model;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'app\Models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path();
        }
    }
}