<?php

namespace jiggle\app\Core;

abstract class Controller
{
    public array $requestParams;

    public function __construct($requestParams = [])
    {
        $this->requestParams = $requestParams;
    }
}