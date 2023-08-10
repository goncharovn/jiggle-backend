<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductsModel;
use JetBrains\PhpStorm\NoReturn;

class ProductController extends Controller
{
    public ProductsModel $model;

    public function __construct(array $requestParams)
    {
        parent::__construct($requestParams);
        $this->model = new ProductsModel();
    }

    public function showProductPage(): void
    {
        session_start();

        $productId = (int)$this->requestParams['product_id'];
        $product = (array)$this->model->getProduct($productId);
        $isProductInBasket = $this->isProductInBasket($productId);
        $quantityOfProductInBasket = (int)$_SESSION['basket'][$productId]['quantity'];
        $quantityOfProductInStock = (int)$product['quantity'];
        $message = ($quantityOfProductInBasket > 1) ? 'items' : 'item';

        if ($_SESSION['errorMessageDisplayed']) {
            unset($_SESSION['errorMessage']);
        } else {
            $_SESSION['errorMessageDisplayed'] = true;
        }

        $this->view->render(
            'main/product',
            'Product',
            [
                'product' => $product,
                'isProductInBasket' => $isProductInBasket,
                'quantityOfProductInBasket' => $quantityOfProductInBasket,
                'quantityOfProductInStock' => $quantityOfProductInStock,
                'message' => $message,
                'errorMessage' => $_SESSION['errorMessage'],
            ]
        );
    }

    #[NoReturn] public function changeProductQuantityInBasket(): void
    {
        $productId = $_POST['product_id'];
        $product = (array)$this->model->getProduct($productId);
        $quantityOfProductInStock = (int)$product['quantity'];
        $action = $_POST['action'];

        if ($action === 'increase') {
            $this->changeBasketQuantity($productId, 1, $quantityOfProductInStock);
        } elseif ($action === 'decrease') {
            $this->changeBasketQuantity($productId, -1, $quantityOfProductInStock);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    #[NoReturn] public function removeEntireProductFromBasket(): void
    {
        $productId = $_POST['product_id'];

        session_start();

        unset($_SESSION['basket'][$productId]);

        header('Location: /basket');
        exit();
    }

    private function changeBasketQuantity(int $productId, int $quantityChange, int $quantityOfProductInStock): void
    {
        session_start();

        if (!isset($_SESSION['basket'][$productId])) {
            $_SESSION['basket'][$productId] = ['id' => $productId, 'quantity' => 0, 'errorMessage' => ''];
        }

        $quantityOfProductInBasket = $_SESSION['basket'][$productId]['quantity'] + $quantityChange;

        if ($quantityOfProductInBasket <= 0) {
            unset($_SESSION['basket'][$productId]);
        } elseif ($quantityOfProductInBasket <= $quantityOfProductInStock) {
            $_SESSION['basket'][$productId]['quantity'] = $quantityOfProductInBasket;
        } else {
            $_SESSION['errorMessage'] = "Only $quantityOfProductInStock item" . ($quantityOfProductInStock > 1 ? 's' : '') . " available.";
            $_SESSION['errorMessageDisplayed'] = false;
        }
    }

    private function isProductInBasket(int $productId): bool
    {
        return isset($_SESSION['basket'][$productId]);
    }
}