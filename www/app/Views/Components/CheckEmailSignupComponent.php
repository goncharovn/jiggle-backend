<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class CheckEmailSignupComponent extends Component
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function render(): string
    {
        return View::make(
            'check_email_signup',
            [
                'email' => $this->email
            ]
        );
    }
}