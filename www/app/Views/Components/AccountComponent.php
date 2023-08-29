<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class AccountComponent extends Component
{
    private string $accountMenu;
    private string $accountHeading;
    private AccountBodyComponent $accountBody;

    public function __construct(string $accountMenu, string $accountHeading, AccountBodyComponent $accountBody)
    {
        $this->accountMenu = $accountMenu;
        $this->accountHeading = $accountHeading;
        $this->accountBody = $accountBody;
    }

    public function render(): string
    {
        return View::make(
            'account',
            [
                'accountMenu' => $this->accountMenu,
                'accountHeading' => $this->accountHeading,
                'accountBody' => $this->accountBody
            ]
        );
    }
}