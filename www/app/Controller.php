<?php

namespace app;

abstract class Controller
{
    public array $route;

    public function __construct($route)
    {
        $this->route = $route;
    }
}