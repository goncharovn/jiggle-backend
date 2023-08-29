<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Controllers\NotificationMessagesController;
use jiggle\app\Core\View;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Component;

class ProductPageComponent extends Component
{
    private ProductModel $product;
    private array $availableColors;
    private array $availableSizes;
    private bool $isProductInBasket;
    private int $quantityOfProductInBasket;
    private int $quantityOfProductInStock;
    private string $message;
    private string $quantityLimitError;
    private string $unselectedSizeError;

    public function __construct(
        ProductModel $product,
        array $availableColors,
        array $availableSizes,
        bool $isProductInBasket,
        int $quantityOfProductInBasket,
        int $quantityOfProductInStock,
        string $message
    )
    {
        $this->product = $product;
        $this->availableColors = $availableColors;
        $this->availableSizes = $availableSizes;
        $this->isProductInBasket = $isProductInBasket;
        $this->quantityOfProductInBasket = $quantityOfProductInBasket;
        $this->quantityOfProductInStock = $quantityOfProductInStock;
        $this->message = $message;
        $this->quantityLimitError = NotificationMessagesController::getMessage('quantityLimitError') ?? '';
        $this->unselectedSizeError = NotificationMessagesController::getMessage('unselectedSizeError') ?? '';
    }

    public function render(): string
    {
        return View::make(
            'product',
            [
                'product' => $this->product,
                'availableColors' => $this->availableColors,
                'availableSizes' => $this->availableSizes,
                'isProductInBasket' => $this->isProductInBasket,
                'quantityOfProductInBasket' => $this->quantityOfProductInBasket,
                'quantityOfProductInStock' => $this->quantityOfProductInStock,
                'message' => $this->message,
                'quantityLimitError' => $this->quantityLimitError,
                'unselectedSizeError' => $this->unselectedSizeError
            ]
        );
    }
}