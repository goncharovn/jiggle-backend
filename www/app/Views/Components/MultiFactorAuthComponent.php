<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class MultiFactorAuthComponent extends Component
{
    private string $formError;

    public function __construct(string $formError)
    {
        $this->formError = $formError;
    }

    public function render(): string
    {
        return View::make(
            'multi_factor',
            [
                'formError' => $this->formError
            ]
        );
    }
}