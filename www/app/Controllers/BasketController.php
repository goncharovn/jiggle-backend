<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\Core\Controller;
use jiggle\app\Models\ProductModel;
use jiggle\app\Views\Components\BasketComponent;
use jiggle\app\Views\Components\DefaultLayoutComponent;

class BasketController extends Controller
{
    public function showBasketPage(): void
    {
        echo new DefaultLayoutComponent(
            'Basket - Jiggle',
            new BasketComponent(
                self::getProductsVariantsInBasket(),
                self::getOrderTotal()
            )
        );
    }

    #[NoReturn]
    public static function changeProductVariantQuantityInBasket(): void
    {
        $productId = $_POST['product_id'] ?? null;
        $action = $_POST['action'] ?? null;
        $productColor = $_POST['product_color'] ?? null;
        $productSize = $_POST['product_size'] ?? null;

        if (empty($productSize) && empty($_GET['size_error'])) {
            $refererUrl = strtok($_SERVER['HTTP_REFERER'], '?');
            $redirectUrl = $refererUrl . '?sizeError=1';

            header('Location: ' . $redirectUrl);
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

    public static function getOrderTotal(): float
    {
        $orderTotal = 0;

        foreach (static::getProductsVariantsInBasket() as $productVariant) {
            $quantityOfProductInBasket = $_SESSION['basket'][$productVariant->getVariantId()]['basket_quantity'];
            $orderTotal += $productVariant->getPrice() * $quantityOfProductInBasket;
        }

        return $orderTotal;
    }

    private static function getProductsVariantsInBasket(): array
    {
        if (!empty($_SESSION['basket'])) {
            $productsVariantsIdsInBasket = $_SESSION['basket'];
            $productsVariantsInBasket = ProductModel::getProductsVariantsByIds($productsVariantsIdsInBasket);

            foreach ($productsVariantsInBasket as &$productVariant) {
                if (isset($_SESSION['basket'][$productVariant->getVariantId()]['basket_quantity'])) {
                    $productVariant->setBasketQuantity($_SESSION['basket'][$productVariant->getVariantId()]['basket_quantity']);
                }
            }
        } else {
            return [];
        }

        return $productsVariantsInBasket;
    }
}