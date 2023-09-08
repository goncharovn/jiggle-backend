<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Components\DefaultLayoutComponent;
use jiggle\app\Views\Components\ProductPageComponent;

class ProductController extends Controller
{
    private ProductModel $product;
    private string $message;

    public function __construct(array $requestParams)
    {
        parent::__construct($requestParams);
        $this->message = '';
    }

    public function showProductPage(): void
    {
        $this->prepareProductData();
        $this->renderProductPage();
    }

    private function prepareProductData(): void
    {
        $this->product = ProductModel::getProductById($this->requestParams['product_id']);

        $availableColors = $this->product->getAvailableColors();
        $this->product->setColor($_GET['color'] ?? $availableColors[0]['name']);
        $availableSizesByColor = $this->product->getAvailableSizesByColor();
        $this->product->setSize($_GET['size'] ?? '');
        $this->product->setImageName($this->product->fetchImageName());

        $namesOfAvailableSizesByColor = array_column($availableSizesByColor, 'name');
        if (!empty($this->product->getSize()) && in_array($this->product->getSize(), $namesOfAvailableSizesByColor)) {
            $this->product->setQuantity($this->product->fetchQuantity());
            $this->product->setVariantId($this->product->fetchVariantId());
            $this->product->setBasketQuantity($_SESSION['basket'][$this->product->getVariantId()]['basket_quantity'] ?? 0);
            $this->message = ($this->product->getBasketQuantity() > 1) ? 'items' : 'item';
            $this->checkQuantityLimitError();
        } else {
            $this->product->setQuantity(0);
        }

        $this->checkUnselectedSizeError();
    }

    private function checkQuantityLimitError(): void
    {
        if ($this->product->getBasketQuantity() >= $this->product->getQuantity()) {
            NotificationMessagesController::setMessage(
                'quantityLimitError',
                "Only {$this->product->getQuantity()} item" . ($this->product->getQuantity() > 1 ? 's' : '') . " available."
            );
        }
    }

    private function checkUnselectedSizeError(): void
    {
        if ($_GET['sizeError'] === '1') {
            NotificationMessagesController::setMessage(
                'unselectedSizeError',
                "Please select a size."
            );
        }
    }

    private function isSizeSelected(): bool
    {
        return (int)isset($_GET['size']);
    }

    private function renderProductPage(): void
    {
        echo new DefaultLayoutComponent(
            $this->product->getTitle(),
            new ProductPageComponent(
                $this->product,
                $this->message,
                $this->isSizeSelected()
            )
        );
    }
}