<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminEditProductView
{
    public static function make(): string
    {
        return View::make(
            'admin_edit_product',
            [

            ]
        );
    }
}