<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductsModel;

class BasketController extends Controller
{
    public ProductsModel $model;
    private ProductController $productController;

    public function __construct(array $requestParams)
    {
        parent::__construct();
        $this->model = new ProductsModel();
        $this->productController = new ProductController($requestParams);
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productController->changeProductQuantityInBasket();
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
        $productsInBasket = $this->model->getProductsInBasket($productsIdsInBasket);

        foreach ($productsInBasket as &$product) {
            $variantId = $product['variant_id'];

            if (isset($_SESSION['basket'][$variantId]['quantity'])) {
                $product['quantity'] = $_SESSION['basket'][$variantId]['quantity'];
            }
        }

        return $productsInBasket;
    }

    private function getOrderTotal($productsInBasket): float|int
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