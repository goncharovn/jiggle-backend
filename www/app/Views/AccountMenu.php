<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AccountMenu
{
    public static function make($isAdmin): string
    {
        return View::make(
            'account_menu',
            [
                'isAdmin' => $isAdmin
            ]
        );
    }
}