<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class PasswordChangedComponent extends Component
{
    public function render(): string
    {
        return View::make('password_changed');
    }
}