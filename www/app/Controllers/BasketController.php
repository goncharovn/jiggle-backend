<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\Models\ProductModel;

class BasketController extends Controller
{
    public function showBasketPage(): void
    {
        $productsVariantsInBasket = $this->getProductsVariantsInBasket();
        $orderTotal = $this->getOrderTotal($productsVariantsInBasket);

        $this->view->render(
            'basket/index',
            'Jiggle - Basket',
            [
                'productsVariantsInBasket' => $productsVariantsInBasket,
                'orderTotal' => $orderTotal,
            ],
        );
    }

    #[NoReturn]
    public static function changeProductVariantQuantityInBasket(): void
    {
        $productId = $_POST['product_id'] ?? null;
        $action = $_POST['action'] ?? null;
        $productColor = $_POST['product_color'] ?? null;
        $productSize = $_POST['product_size'] ?? null;

        if (empty($productSize)) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?size_error=1');
            exit();
        }

        if (!$productId || !$action || !$productColor || !$productSize) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $product = ProductModel::getProductVariant($productId, $productColor, $productSize);

        $quantityOfProductInStock = $product->getQuantity();
        $quantityChange = 0;

        if ($action === 'increase') {
            $quantityChange = 1;
        } elseif ($action === 'decrease') {
            $quantityChange = -1;
        }

        $variantId = $product->getVariantId();

        if (!isset($_SESSION['basket'][$variantId])) {
            $_SESSION['basket'][$variantId] = ['variant_id' => $variantId, 'basket_quantity' => 0];
        }

        $quantityOfProductInBasket = $_SESSION['basket'][$variantId]['basket_quantity'] + $quantityChange;

        if ($quantityOfProductInBasket <= 0) {
            unset($_SESSION['basket'][$variantId]);
        } elseif ($quantityOfProductInBasket <= $quantityOfProductInStock) {
            $_SESSION['basket'][$variantId]['basket_quantity'] = $quantityOfProductInBasket;
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    #[NoReturn]
    public function removeProductVariantFromBasket(): void
    {
        $variantId = $_POST['variant_id'];

        unset($_SESSION['basket'][$variantId]);

        header('Location: /basket');
        exit();
    }

    public static function isProductVariantInBasket($variantId): bool
    {
        return isset($variantId, $_SESSION['basket'][$variantId]);
    }

    private function getProductsVariantsInBasket(): array
    {
        if (!empty($_SESSION['basket'])) {
            $productsVariantsIdsInBasket = $_SESSION['basket'];
            $productsVariantsInBasket = ProductModel::getProductsVariantsByIds($productsVariantsIdsInBasket);

            foreach ($productsVariantsInBasket as &$productVariant) {
                if (isset($_SESSION['basket'][$productVariant['variant_id']]['basket_quantity'])) {
                    $productVariant['basket_quantity'] = $_SESSION['basket'][$productVariant['variant_id']]['basket_quantity'];
                }
            }
        } else {
            return [];
        }

        return $productsVariantsInBasket;
    }

    private function getOrderTotal($productsVariantsInBasket): float
    {
        $orderTotal = 0;

        foreach ($productsVariantsInBasket as $productVariant) {
            $quantityOfProductInBasket = $_SESSION['basket'][$productVariant['variant_id']]['basket_quantity'];
            $orderTotal += $productVariant['price'] * $quantityOfProductInBasket;
        }

        return $orderTotal;
    }
}