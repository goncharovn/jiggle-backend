<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;

class AdminController extends Controller
{
    public function __construct(array $requestParams)
    {
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
            ]
        );
    }

    public function showAddProductPage(): void
    {
        $this->view->render(
            'admin/add_product',
            'Admin - Add Product',
            [
            ]
        );
    }

    public function showEditProductPage(): void
    {
        $this->view->render(
            'admin/edit_product',
            'Admin - Edit Product',
            [
            ]
        );
    }

    public function showEditProductVariantPage(): void
    {
        $this->view->render(
            'admin/edit_product_variant',
            'Admin - Edit Product Variant',
            [
            ]
        );
    }

    public function showOrdersPage(): void
    {
        $this->view->render(
            'admin/orders',
            'Admin - Orders',
            [
            ]
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