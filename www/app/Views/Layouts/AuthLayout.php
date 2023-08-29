<?php

namespace jiggle\app\Views\Layouts;

use jiggle\app\Controllers\BasketController;
use jiggle\app\Core\View;

class AuthLayout
{
    public static function render(string $title, string $content): void
    {
        echo View::make(
            'auth',
            [
                'title' => $title,
                'content' => $content
            ]
        );
    }
}