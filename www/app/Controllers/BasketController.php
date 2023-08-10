<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\BasketModel;

class BasketController extends Controller
{
    public Model $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new BasketModel();
    }

    public function index(): void
    {
        session_start();

        $productsIdsInBasket = $this->getProductsIdsInBasket();
        $orderTotal = $this->model->getOrderTotal($productsIdsInBasket);
        $productsInBasket = $this->getProductsInBasket($productsIdsInBasket);

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
        session_start();

        return implode(',', array_keys($_SESSION['basket'] ?? []));
    }

    private function getProductsInBasket($productsIdsInBasket): array|null
    {
        $productsInBasket = $this->model->getBasketData($productsIdsInBasket);

        foreach ($productsInBasket as &$product) {
            $productId = $product['id'];

            if (isset($_SESSION['basket'][$productId]['quantity'])) {
                $product['quantity'] = $_SESSION['basket'][$productId]['quantity'];
            }
        }

        return $productsInBasket;
    }
}