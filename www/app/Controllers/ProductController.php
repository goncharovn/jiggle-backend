<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\Models\ProductModel;
use JetBrains\PhpStorm\NoReturn;

class ProductController extends Controller
{
    public function __construct(array $requestParams)
    {
        parent::__construct($requestParams);
    }

    public function index(): void
    {
        $this->showProductPage();
    }

    private function showProductPage(): void
    {
        $productId = $this->requestParams['product_id'];
        $productSize = null;
        $productColor = $_GET['color'] ?? ProductModel::getDefaultProductColor($productId);

        if (isset($_GET['size'])) {
            $productSize = $_GET['size'];
        }

        $product = ProductModel::getProductVariant($productId, $productColor, $productSize);
        $variantId = $product->getVariantId();
        $availableColors = $product->getAvailableColors($productSize);
        $availableSizes = $product->getAvailableSizes($productColor);
        $isProductInBasket = BasketController::isProductVariantInBasket($variantId);
        $quantityOfProductInBasket = $_SESSION['basket'][$variantId]['basket_quantity'] ?? 0;
        $quantityOfProductInStock = $product->getQuantity();
        $message = ($quantityOfProductInBasket > 1) ? 'items' : 'item';

        if ($quantityOfProductInBasket >= $quantityOfProductInStock) {
            ErrorMessagesManager::addNewMessage(
                'quantityLimitError',
                "Only $quantityOfProductInStock item" . ($quantityOfProductInStock > 1 ? 's' : '') . " available."
            );
        }

        if ($_GET['size_error'] == '1') {
            ErrorMessagesManager::addNewMessage(
                'unselectedSizeError',
                "Please select a size."
            );
        }

        $this->view->render(
            'main/product',
            'Product',
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