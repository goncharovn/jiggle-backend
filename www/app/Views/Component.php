<?php

namespace jiggle\app\Views;

abstract class Component
{
    public abstract function render(): string;

    public function __toString()
    {
        return $this->render();
    }
}