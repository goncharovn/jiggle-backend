<?php

namespace jiggle\app\Views;

use jiggle\app\AccessManager;
use jiggle\app\Controllers\BasketController;
use jiggle\app\Core\View;
use jiggle\app\Views\Layouts\DefaultLayout;

class BasketView
{
    public static function make(array $productsVariantsInBasket, int $orderTotal): string
    {
        return View::make(
            'basket',
            [
                'productsVariantsInBasket' => $productsVariantsInBasket,
                'orderTotal' => $orderTotal,
            ],
        );
    }
}