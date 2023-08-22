<?php

namespace app\Controllers;

use app\Controller;

class AdminController extends Controller
{
    public function __construct(array $requestParams)
    {
        session_start();

        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: /');
        }

        parent::__construct($requestParams);
        $this->view->layout = 'admin';
    }

    public function showProductsPage(): void
    {
        $this->view->render(
            'admin/products',
            'Admin - Products',
            [
            ],
        );
    }

    public function showAddProductPage(): void
    {
        $this->view->render(
            'admin/add_product',
            'Admin - Add Product',
            [
            ],
        );
    }
    public function showOrdersPage(): void
    {
        $this->view->render(
            'admin/orders',
            'Admin - Orders',
            [
            ],
        );
    }

    public function showCustomersPage(): void
    {
        $this->view->render(
            'admin/customers',
            'Admin - Customers',
            [
            ],
        );
    }
}