<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;

class ResetPasswordView
{
    public static function make(string $templateName, string $errorMessage = ''): string
    {
        return View::make(
            $templateName,
            [
                'errorMessage' => $errorMessage
            ]
        );
    }
}