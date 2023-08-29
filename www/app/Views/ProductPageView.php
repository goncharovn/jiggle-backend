<?php

namespace jiggle\app\Views;

use jiggle\app\Core\View;
use jiggle\app\ErrorMessagesManager;

class ProductPageView
{
    public static function make(
        $product,
        $availableColors,
        $availableSizes,
        $isProductInBasket,
        $quantityOfProductInBasket,
        $quantityOfProductInStock,
        $message
    ): string
    {
        return View::make(
            'product',
            [
                'product' => $product,
                'availableColors' => $availableColors,
                'availableSizes' => $availableSizes,
                'isProductInBasket' => $isProductInBasket,
                'quantityOfProductInBasket' => $quantityOfProductInBasket,
                'quantityOfProductInStock' => $quantityOfProductInStock,
                'message' => $message,
                'quantityLimitError' => ErrorMessagesManager::getErrorMessage('quantityLimitError') ?? '',
                'unselectedSizeError' => ErrorMessagesManager::getErrorMessage('unselectedSizeError') ?? ''
            ]
        );
    }
}