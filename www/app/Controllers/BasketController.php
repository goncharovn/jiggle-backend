<?php

namespace app\Controllers;

use app\Controller;

class BasketController extends Controller
{
    public function index(): void
    {
        $basketData = $this->model->getBasketData();
        $totalBasketCost = $this->model->getTotalBasketCost();

        session_start();

        $vars = [
            'basketData' => $basketData,
            'totalBasketCost' => $totalBasketCost,
        ];

        $this->view->render('Jiggle - Basket', $vars);
    }

    public function addToBasket()
    {
        $id = $_POST['product__id'];

        session_start();

        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        $_SESSION['basket'][] = $id;

        header('Location: /p/' . $id);
    }

    public function removeFromBasket()
    {
        $id = $_POST['product__id'];

        session_start();

        $basketData = $_SESSION['basket'] ?? [];

        $productPosition = array_search($id, $basketData);

        if ($productPosition !== false) {
            unset($basketData[$productPosition]);
        }

        $_SESSION['basket'] = $basketData;

        header('Location: /basket');
    }
}