<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductsModel;

class ProductController extends Controller
{
    public ProductsModel $model;

    private string $errorMessage;

    public function __construct($requestParams)
    {
        parent::__construct($requestParams);
        $this->model = new ProductsModel();
        $this->errorMessage = '';
    }

    public function index(): void
    {
        session_start();

        $productId = (int)$this->requestParams['product_id'];
        $product = (array)$this->model->getProduct($productId);
        $quantityOfProductInStock = (int)$product['quantity'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest($productId, $quantityOfProductInStock);
        }

        $isProductInBasket = $this->isProductInBasket($productId);
        $quantityOfProductInBasket = (int)$_SESSION['basket'][$productId]['quantity'];

        $this->renderProductView(
            $product,
            $isProductInBasket,
            $quantityOfProductInBasket,
            $quantityOfProductInStock
        );
    }

    public function removeEntireProductFromBasket(): void
    {
        $productId = $_POST['product_id'];
        session_start();
        unset($_SESSION['basket'][$productId]);
        header('Location: /basket');
    }

    private function handlePostRequest(int $productId, int $quantityOfProductInStock): void
    {
        if (!isset($_POST['action'])) {
            return;
        }

        $action = $_POST['action'];

        if ($action === 'increase') {
            $this->changeBasketQuantity($productId, 1, $quantityOfProductInStock);
        } elseif ($action === 'decrease') {
            $this->changeBasketQuantity($productId, -1, $quantityOfProductInStock);
        }

        if (empty($this->errorMessage)) {
            header("Location: /p/$productId");
            exit();
        }
    }

    private function changeBasketQuantity(int $productId, int $quantityChange, int $quantityOfProductInStock): void
    {
        if (!isset($_SESSION['basket'][$productId])) {
            $_SESSION['basket'][$productId] = ['id' => $productId, 'quantity' => 0];
        }

        $quantityOfProductInBasket = $_SESSION['basket'][$productId]['quantity'] + $quantityChange;

        if ($quantityOfProductInBasket <= 0) {
            unset($_SESSION['basket'][$productId]);
        } elseif ($quantityOfProductInBasket <= $quantityOfProductInStock) {
            $_SESSION['basket'][$productId]['quantity'] = $quantityOfProductInBasket;
        } else {
            $this->errorMessage = "Only $quantityOfProductInStock item" . ($quantityOfProductInStock > 1 ? 's' : '') . " available.";
        }
    }

    private function renderProductView(array $product, bool $isProductInBasket, int $quantityOfProductInBasket, int $quantityOfProductInStock): void
    {
        $message = ($quantityOfProductInBasket > 1) ? 'items' : 'item';

        $this->view->render(
            'main/product',
            'Product',
            [
                'product' => $product,
                'isProductInBasket' => $isProductInBasket,
                'quantityOfProductInBasket' => $quantityOfProductInBasket,
                'quantityOfProductInStock' => $quantityOfProductInStock,
                'message' => $message,
                'errorMessage' => $this->errorMessage,
            ]
        );
    }

    private function isProductInBasket($productId): bool
    {
        return isset($_SESSION['basket'][$productId]);
    }
}