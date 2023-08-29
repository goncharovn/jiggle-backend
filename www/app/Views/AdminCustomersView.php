<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminCustomersView
{
    public static function make(): string
    {
        return View::make(
            'admin_customers',
            [

            ]
        );
    }
}