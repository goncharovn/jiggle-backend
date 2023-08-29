<?php

namespace jiggle\app\Views\Layouts;

use jiggle\app\Core\View;

class AdminLayout
{
    public static function render(string $title, string $content): void
    {
        echo View::make(
            'admin',
            [
                'title' => $title,
                'content' => $content
            ]
        );
    }
}