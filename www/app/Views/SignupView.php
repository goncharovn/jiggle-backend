<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class SignupView
{
    public static function make(string $errorMessage = '', string $email = ''): string
    {
        return View::make(
            'signup',
            [
                'errorMessage' => $errorMessage,
                'email' => $email
            ]
        );
    }
}