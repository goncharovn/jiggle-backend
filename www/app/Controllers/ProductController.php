<?php

namespace app\Controllers;

use app\Controller;
use app\Models\ProductsModel;
use JetBrains\PhpStorm\NoReturn;
use app\ErrorMessagesManager;

class ProductController extends Controller
{
    public ProductsModel $model;

    public function __construct(array $requestParams)
    {
        parent::__construct($requestParams);
        $this->model = new ProductsModel();
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productSize = $_POST['product_size'];

            if (empty($productSize)) {
                ErrorMessagesManager::addNewMessage(
                    'unselectedSizeError',
                    "Please select a size."
                );
            } else {
                $this->changeProductQuantityInBasket();
            }
        }

        $this->showProductPage();
    }

    private function showProductPage(): void
    {
        session_start();

        $productId = $this->requestParams['product_id'];
        $productSize = null;
        $productColor = $_GET['color'] ?? $this->model->getDefaultProductColor($productId);

        if (isset($_GET['size'])) {
            $productSize = $_GET['size'];
        }

        $product = $this->model->getProduct($productId, $productColor, $productSize);
        $variantId = $product['variant_id'];
        $availableColors = $this->model->getAvailableColors($productId, $productSize);
        $availableSizes = $this->model->getAvailableSizes($productId, $productColor);
        $isProductInBasket = $this->isProductInBasket($variantId);
        $quantityOfProductInBasket = $_SESSION['basket'][$variantId]['quantity'];
        $quantityOfProductInStock = $product['quantity'];
        $message = ($quantityOfProductInBasket > 1) ? 'items' : 'item';

        $this->view->render(
            'main/product',
            'Product',
            [
                'product' => $product,
                'availableColors' => $availableColors,
                'availableSizes' => $availableSizes,
                'isProductInBasket' => $isProductInBasket,
                'quantityOfProductInBasket' => $quantityOfProductInBasket,
                'quantityOfProductInStock' => $quantityOfProductInStock,
                'message' => $message,
                'quantityLimitError' => ErrorMessagesManager::getErrorMessage('quantityLimitError') ?? '',
                'unselectedSizeError' => ErrorMessagesManager::getErrorMessage('unselectedSizeError') ?? ''
            ]
        );
    }

    #[NoReturn] public function changeProductQuantityInBasket(): void
    {
        session_start();

        $productId = $_POST['product_id'];

        if (isset($productId)) {
            $productSize = $_POST['product_size'];
            $productColor = $_POST['product_color'];
            $action = $_POST['action'];

            $product = $this->model->getProduct($productId, $productColor, $productSize);

            $quantityOfProductInStock = $product['quantity'];

            $quantityChange = 0;
            if ($action === 'increase') {
                $quantityChange = 1;
            } elseif ($action === 'decrease') {
                $quantityChange = -1;
            }

            $variantId = $product['variant_id'];

            if (!isset($_SESSION['basket'][$variantId])) {
                $_SESSION['basket'][$variantId] = ['variant_id' => $variantId, 'quantity' => 0];
            }

            $quantityOfProductInBasket = $_SESSION['basket'][$variantId]['quantity'] + $quantityChange;

            if ($quantityOfProductInBasket <= 0) {
                unset($_SESSION['basket'][$variantId]);
            } elseif ($quantityOfProductInBasket <= $quantityOfProductInStock) {
                $_SESSION['basket'][$variantId]['quantity'] = $quantityOfProductInBasket;
            }

            if ($quantityOfProductInBasket >= $quantityOfProductInStock) {
                ErrorMessagesManager::addNewMessage(
                    'quantityLimitError',
                    "Only $quantityOfProductInStock item" . ($quantityOfProductInStock > 1 ? 's' : '') . " available."
                );
            }
        }
    }

    private function isProductInBasket($variantId): bool
    {
        return isset($variantId, $_SESSION['basket'][$variantId]);
    }

    #[NoReturn] public function removeProductFromBasket(): void
    {
        session_start();

        $variantId = $_POST['variant_id'];

        unset($_SESSION['basket'][$variantId]);

        header('Location: /basket');
        exit();
    }
}