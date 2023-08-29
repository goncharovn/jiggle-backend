<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminAddProductView
{
    public static function make(): string
    {
        return View::make(
            'admin_add_product',
            [

            ]
        );
    }
}