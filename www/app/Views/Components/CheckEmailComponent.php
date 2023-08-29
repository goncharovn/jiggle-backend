<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class CheckEmailComponent extends Component
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
    public function render(): string
    {
        return View::make(
            'check_email',
            [
                'email' => $this->email
            ]
        );
    }
}