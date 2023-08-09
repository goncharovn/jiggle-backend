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
        $productsIdsInBasket = $this->getProductsIdsInBasket();
        $productsInBasket = $this->model->getBasketData($productsIdsInBasket);
        $orderTotal = $this->model->getOrderTotal($productsIdsInBasket);
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
}