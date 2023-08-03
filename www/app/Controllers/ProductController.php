<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\ProductsModel;

class ProductController extends Controller
{
    public Model $model;

    public function __construct($requestParams)
    {
        parent::__construct($requestParams);
        $this->model = new ProductsModel();
    }

    public function index(): void
    {
        $id = $this->requestParams['id'];

        $product = $this->model->getProduct($id);
        $isProductInBasket = $this->isProductInBasket($id);

        $vars = [
            'product' => $product,
            'isProductInBasket' => $isProductInBasket,
        ];

        $this->view->render('main/product', 'Product', $vars);
    }

    public function addProductIdToBasket(): void
    {
        $id = $_POST['product_id'];

        session_start();

        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        $_SESSION['basket'][] = $id;

        header('Location: /p/' . $id);
    }

    public function isProductInBasket($productId): bool
    {
        session_start();
        return in_array($productId, $_SESSION['basket'] ?? []);
    }
}