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

        $basketData = $this->model->getBasketData($productsIdsInBasket);
        $totalBasketCost = $this->model->getTotalBasketCost($productsIdsInBasket);

        $vars = [
            'basketData' => $basketData,
            'totalBasketCost' => $totalBasketCost,
        ];

        $this->view->render('basket/index', 'Jiggle - BasketModel', $vars);
    }

    private function getProductsIdsInBasket(): string
    {
        session_start();
        return implode(',', $_SESSION['basket'] ?? []);
    }
}