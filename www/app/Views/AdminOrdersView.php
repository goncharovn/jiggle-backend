<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AdminOrdersView
{
    public static function make():string
    {
        return View::make(
            'admin_orders',
            [

            ]
        );
    }
}