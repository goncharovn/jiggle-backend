<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class ProductsComponent extends Component
{
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function render(): string
    {


        return View::make(
            'products',
            [
                'products' => $this->products
            ]
        );
    }
}