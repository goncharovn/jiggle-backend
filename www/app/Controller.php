<?php

namespace app;

use database\Db;

abstract class Controller
{
    public array $route;
    public View $view;

    public function __construct($route)
    {
        $db = new Db;
        $this->route = $route;
        $this->view = new View($route);
    }
}