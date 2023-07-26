<?php

namespace app;

use app\View;

abstract class Controller
{
    public array $route;
    public $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }
}