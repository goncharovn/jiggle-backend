<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class CheckEmailView
{
    public static function make($email): string
    {
        return View::make(
            'check_email',
            [
                'email' => $email
            ]
        );
    }
}