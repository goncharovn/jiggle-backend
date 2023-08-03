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

    public function removeProductIdFromBasket(): void
    {
        $id = $_POST['product_id'];

        session_start();

        $productsInBasket = $_SESSION['basket'] ?? [];

        $productPosition = array_search($id, $productsInBasket);

        if ($productPosition !== false) {
            unset($productsInBasket[$productPosition]);
        }

        $_SESSION['basket'] = $productsInBasket;

        header('Location: /basket');
    }

    private function getProductsIdsInBasket(): string
    {
        session_start();
        return implode(',', $_SESSION['basket'] ?? []);
    }
}