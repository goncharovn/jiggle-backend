<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class AccountMenuComponent extends Component
{
    private bool $isAdmin;

    public function __construct(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function render(): string
    {
        return View::make(
            'account_menu',
            [
                'isAdmin' => $this->isAdmin
            ]
        );
    }
}