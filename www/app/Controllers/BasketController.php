<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductsModel;

class BasketController extends Controller
{
    public ProductsModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ProductsModel();
    }

    public function showBasketPage(): void
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
        $productsInBasket = $this->model->getProductsInBasket($productsIdsInBasket);

        foreach ($productsInBasket as &$product) {
            $productId = $product['id'];

            if (isset($_SESSION['basket'][$productId]['quantity'])) {
                $product['quantity'] = $_SESSION['basket'][$productId]['quantity'];
            }
        }

        return $productsInBasket;
    }

    private function getOrderTotal($productsInBasket): float|int
    {
        $orderTotal = 0;
        foreach ($productsInBasket as $product) {
            $price = $product['price'];
            $quantityOfProductInBasket = $_SESSION['basket'][$product['id']]['quantity'];
            $orderTotal += $price * $quantityOfProductInBasket;
        }

        return $orderTotal;
    }
}