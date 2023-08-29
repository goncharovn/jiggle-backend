<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Core\View;
use jiggle\app\Views\Component;

class BasketComponent extends Component
{
    private array $productsVariantsInBasket;
    private int $orderTotal;

    public function __construct(array $productsVariantsInBasket, int $orderTotal)
    {
        $this->productsVariantsInBasket = $productsVariantsInBasket;
        $this->orderTotal = $orderTotal;
    }

    public function render(): string
    {
        return View::make(
            'basket',
            [
                'productsVariantsInBasket' => $this->productsVariantsInBasket,
                'orderTotal' => $this->orderTotal,
            ],
        );
    }
}