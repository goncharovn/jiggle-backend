<?php

namespace jiggle\app\Views\Layouts;

use jiggle\app\AccessManager;
use jiggle\app\Controllers\BasketController;
use jiggle\app\Core\View;

class DefaultLayout
{
    public static function render(string $title, string $main): void
    {
        echo View::make(
            'default',
            [
                'title' => $title,
                'main' => $main,
                'orderTotal' => BasketController::getOrderTotal(),
                'isUserLoggedIn' => AccessManager::isUserLoggedIn()
            ]
        );
    }
}