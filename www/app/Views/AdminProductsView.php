<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminProductsView
{
    public static function make(): string
    {
        return View::make(
            'admin_products',
            [

            ]
        );
    }
}