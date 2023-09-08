<?php

namespace jiggle\app\Views\Components;

use jiggle\app\Controllers\NotificationMessagesController;
use jiggle\app\Core\View;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Component;

class ProductPageComponent extends Component
{
    private ProductModel $product;
    private string $message;
    private string $quantityLimitError;
    private string $unselectedSizeError;
    private int $sizeSelected;

    public function __construct(
        ProductModel $product,
        string       $message,
        int          $sizeSelected
    )
    {
        $this->product = $product;
        $this->message = $message;
        $this->sizeSelected = $sizeSelected;
        $this->quantityLimitError = NotificationMessagesController::getMessage('quantityLimitError') ?? '';
        $this->unselectedSizeError = NotificationMessagesController::getMessage('unselectedSizeError') ?? '';
    }

    public function render(): string
    {
        return View::make(
            'product',
            [
                'product' => $this->product,
                'message' => $this->message,
                'sizeSelected' => $this->sizeSelected,
                'quantityLimitError' => $this->quantityLimitError,
                'unselectedSizeError' => $this->unselectedSizeError
            ]
        );
    }
}