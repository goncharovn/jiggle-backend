<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class AdminCustomersComponent extends Component
{
    public function __construct()
    {

    }

    public function render(): string
    {
        return View::make(
            'admin_customers',
            [

            ]
        );
    }
}