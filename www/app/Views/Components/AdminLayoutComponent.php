<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class AdminLayoutComponent extends Component
{
    private string $title;
    private Component $content;

    public function __construct(string $title, Component $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render(): string
    {
        return View::make(
            'admin',
            [
                'title' => $this->title,
                'content' => $this->content
            ]
        );
    }
}