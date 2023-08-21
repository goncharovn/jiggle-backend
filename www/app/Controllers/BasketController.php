<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductModel;

class BasketController extends Controller
{
    public function __construct(array $requestParams)
    {
        parent::__construct();
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductController::changeProductQuantityInBasket();
        }

        $this->showBasketPage();
    }

    private function showBasketPage(): void
    {
        session_start();

        $productsInBasket = $this->getProductsInBasket();
        $orderTotal = $this->getOrderTotal($productsInBasket);

        $this->view->render(
            'basket/index',
            'Jiggle - Basket',
            [
                'productsInBasket' => $productsInBasket,
                'orderTotal' => $orderTotal,
            ],
        );
    }

    private function getProductsIdsInBasket(): string
    {
        return implode(',', array_keys($_SESSION['basket'] ?? []));
    }

    private function getProductsInBasket(): array|null
    {
        $productsIdsInBasket = $this->getProductsIdsInBasket();
        $productsInBasket = ProductModel::getProductsInBasket($productsIdsInBasket);

        foreach ($productsInBasket as &$product) {
            $variantId = $product['variant_id'];

            if (isset($_SESSION['basket'][$variantId]['quantity'])) {
                $product['quantity'] = $_SESSION['basket'][$variantId]['quantity'];
            }
        }

        return $productsInBasket;
    }

    private function getOrderTotal($productsInBasket): float
    {
        $orderTotal = 0;

        foreach ($productsInBasket as $product) {
            $price = $product['price'];
            $quantityOfProductInBasket = $_SESSION['basket'][$product['variant_id']]['quantity'];
            $orderTotal += $price * $quantityOfProductInBasket;
        }

        return $orderTotal;
    }
}