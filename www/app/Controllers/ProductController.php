<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Layouts\DefaultLayout;
use jiggle\app\Views\ProductPageView;

class ProductController extends Controller
{
    private ProductModel $product;
    private array $availableColors;
    private array $availableSizes;
    private bool $isProductInBasket;
    private int $quantityOfProductInBasket;
    private int $quantityOfProductInStock;
    private string $message;

    public function __construct(array $requestParams)
    {
        parent::__construct($requestParams);
    }

    public function showProductPage(): void
    {
        $this->prepareProductData();
        $this->renderProductPage();
    }

    private function prepareProductData(): void
    {
        $productId = $this->requestParams['product_id'];
        $productSize = $_GET['size'] ?? null;
        $productColor = $this->requestParams['color'] ?? ProductModel::getDefaultProductColor($productId);

        $this->product = $this->getProductVariant($productId, $productColor, $productSize);
        $this->availableColors = $this->getAvailableColors($productSize);
        $this->availableSizes = $this->getAvailableSizes($productColor);
        $this->isProductInBasket = $this->isProductInBasket();
        $this->quantityOfProductInBasket = $this->getQuantityInBasket();
        $this->quantityOfProductInStock = $this->product->getQuantity();
        $this->message = ($this->quantityOfProductInBasket > 1) ? 'items' : 'item';

        $this->checkQuantityLimitError();
        $this->checkUnselectedSizeError();
    }

    private function getProductVariant(int $productId, string $productColor, ?string $productSize): ProductModel
    {
        return ProductModel::getProductVariant($productId, $productColor, $productSize);
    }

    private function getAvailableColors(?string $productSize): array
    {
        return $this->product->getAvailableColors($productSize);
    }

    private function getAvailableSizes(string $productColor): array
    {
        return $this->product->getAvailableSizes($productColor);
    }

    private function isProductInBasket(): bool
    {
        $variantId = $this->product->getVariantId();
        return BasketController::isProductVariantInBasket($variantId);
    }

    private function getQuantityInBasket(): int
    {
        $variantId = $this->product->getVariantId();
        return $_SESSION['basket'][$variantId]['basket_quantity'] ?? 0;
    }

    private function checkQuantityLimitError(): void
    {
        if ($this->quantityOfProductInBasket >= $this->quantityOfProductInStock) {
            ErrorMessagesManager::addNewMessage(
                'quantityLimitError',
                "Only $this->quantityOfProductInStock item" . ($this->quantityOfProductInStock > 1 ? 's' : '') . " available."
            );
        }
    }

    private function checkUnselectedSizeError(): void
    {
        if ($_GET['sizeError'] === '1') {
            ErrorMessagesManager::addNewMessage(
                'unselectedSizeError',
                "Please select a size."
            );
        }
    }

    private function renderProductPage(): void
    {
        DefaultLayout::render(
            $this->product->getTitle(),
            ProductPageView::make(
                $this->product,
                $this->availableColors,
                $this->availableSizes,
                $this->isProductInBasket,
                $this->quantityOfProductInBasket,
                $this->quantityOfProductInStock,
                $this->message
            )
        );
    }
}