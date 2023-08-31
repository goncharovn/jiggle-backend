<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class ChangePasswordComponent extends Component
{
    private string $parametersString;

    public function __construct(string $parametersString)
    {
        $this->parametersString = $parametersString;
    }

    public function render(): string
    {
        return View::make(
            'change_password',
            [
                'parametersString' => $this->parametersString
            ]
        );
    }
}