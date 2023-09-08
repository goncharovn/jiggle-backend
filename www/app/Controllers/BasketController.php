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
        $variantId = $_POST['variant_id'] ?? null;
        $action = $_POST['action'] ?? null;

        $sizeSelected = $_POST['size_selected'];

        $httpRefererParts = explode('?', $_SERVER['HTTP_REFERER'], 2);
        $queryString = $httpRefererParts[1];
        parse_str($queryString, $parameters);

        if (!empty($queryString)) {
            $queryString = '&' . $queryString;
        }

        if ($sizeSelected === "0" && empty($parameters['sizeError'])) {
            $redirectUrl = $httpRefererParts[0] . '?sizeError=1' . $queryString;

            header('Location: ' . $redirectUrl);
            exit();
        }

        if (!$variantId || !$action) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $product = ProductModel::getProductVariant($variantId);

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

        foreach ($_SESSION['basket'] as $localVariant) {
            $quantityOfProductInBasket = $localVariant['basket_quantity'];
            $orderTotal += ProductModel::getProductVariant($localVariant['variant_id'])->getPrice() * $quantityOfProductInBasket;
        }

        return $orderTotal;
    }

    private static function getProductsVariantsInBasket(): array
    {
        $variantsInBasket = [];

        if (!empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $localVariant) {
                $dbVariant = ProductModel::getProductVariant($localVariant['variant_id']);
                $dbVariant->setBasketQuantity($localVariant['basket_quantity']);
                $variantsInBasket[] = $dbVariant;
            }
        }

        return $variantsInBasket;
    }
}