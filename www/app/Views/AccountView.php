<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class AccountView
{
    public static function make($templateName, $user, $accountMenu): string
    {
        return View::make(
            $templateName,
            [
                'user' => $user,
                'accountMenu' => $accountMenu
            ]
        );
    }
}