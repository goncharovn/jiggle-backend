<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\ProductsModel;

class ProductController extends Controller
{
    public ProductsModel $model;

    public function __construct($requestParams)
    {
        parent::__construct($requestParams);
        $this->model = new ProductsModel();
    }

    public function index(): void
    {
        $productId = $this->requestParams['product_id'];
        $product = $this->model->getProduct($productId);
        $isProductInBasket = $this->isProductInBasket($productId);
        $this->view->render(
            'main/product',
            'Product',
            [
                'product' => $product,
                'isProductInBasket' => $isProductInBasket,
            ]
        );
    }

    public function addProductToBasket(): void
    {
        $id = $_POST['product_id'];
        session_start();
        $_SESSION['basket'][$id] = $id;
        header("Location: /p/$id");
    }

    public function removeProductFromBasket(): void
    {
        $id = $_POST['product_id'];
        session_start();
        unset($_SESSION['basket'][$id]);
        header('Location: /basket');
    }

    private function isProductInBasket($productId): bool
    {
        session_start();
        return isset($_SESSION['basket'][$productId]);
    }
}