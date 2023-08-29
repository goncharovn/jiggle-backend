<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class ChangePasswordComponent extends Component
{
    public function render(): string
    {
        return View::make('change_password');
    }
}