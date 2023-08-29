<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;
use jiggle\app\ErrorMessagesManager;

class MultiFactorAuthView
{
    public static function make(): string
    {
        return View::make(
            'multi_factor',
            [
                'formError' => ErrorMessagesManager::getErrorMessage('formError') ?? ''
            ]
        );
    }
}