<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;
use jiggle\app\ErrorMessagesManager;

class LoginView
{
    public static function make(): string
    {
        return View::make(
            'login',
            [
                'formError' => ErrorMessagesManager::getErrorMessage('formError',) ?? ''
            ]
        );
    }
}