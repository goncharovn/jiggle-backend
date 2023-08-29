<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Component;

class AccountBodyComponent extends Component
{
    private string $templateName;
    private UserModel $user;

    public function __construct($templateName, $user)
    {
        $this->templateName = $templateName;
        $this->user = $user;
    }

    public function render(): string
    {
        return View::make(
            $this->templateName,
            [
                'user' => $this->user
            ]
        );
    }
}