<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Controllers\AccessController;
use jiggle\app\Controllers\BasketController;
use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class DefaultLayoutComponent extends Component
{
    private string $title;
    private Component $main;

    public function __construct(string $title, Component $main)
    {
        $this->title = $title;
        $this->main = $main;
    }

    public function render(): string
    {
        return View::make(
            'default',
            [
                'title' => $this->title,
                'main' => $this->main,
                'orderTotal' => BasketController::getOrderTotal(),
                'isUserLoggedIn' => AccessController::isUserLoggedIn()
            ]
        );
    }
}