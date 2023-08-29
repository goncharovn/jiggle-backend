<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class CheckEmailSignupView
{
    public static function make($email): string
    {
        return View::make(
            'check_email_signup',
            [
                'email' => $email
            ]
        );
    }
}