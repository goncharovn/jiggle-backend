<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class MultiFactorAuthComponent extends Component
{
    public function __construct()
    {

    }

    public function render(): string
    {
        return View::make('multi_factor');
    }
}