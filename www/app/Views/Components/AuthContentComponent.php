<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class AuthContentComponent extends Component
{
    private string $subheading;
    private string $message;
    private string $errorMessage;
    private Component $form;

    public function __construct(
        string $subheading,
        string $message,
        string $errorMessage,
        Component $form
    )
    {
        $this->subheading = $subheading;
        $this->message = $message;
        $this->errorMessage = $errorMessage;
        $this->form = $form;
    }

    public function render(): string
    {
        return View::make(
            'auth_content',
            [
                'subheading' => $this->subheading,
                'message' => $this->message,
                'errorMessage' => $this->errorMessage,
                'form' => $this->form
            ]
        );
    }
}