<?php

namespace jiggle\app\Core;

abstract class Controller
{
    public array $requestParams;
    public View $view;

    public function __construct($requestParams = [])
    {
        $this->requestParams = $requestParams;
        $this->view = new View();
    }
}