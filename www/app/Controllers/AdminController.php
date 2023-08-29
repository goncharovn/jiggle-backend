<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AdminAddProductComponent;
use jiggle\app\Views\Components\AdminCustomersComponent;
use jiggle\app\Views\Components\AdminEditProductComponent;
use jiggle\app\Views\Components\AdminEditProductVariantComponent;
use jiggle\app\Views\Components\AdminLayoutComponent;
use jiggle\app\Views\Components\AdminOrdersComponent;
use jiggle\app\Views\Components\AdminProductsComponent;

class AdminController extends Controller
{
    private UserModel $user;

    public function __construct(array $requestParams)
    {
        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->user = UserModel::getUserById($_SESSION['user_id']);

        if ($this->user->getRole() !== 'admin') {
            header('Location: /');
        }

        parent::__construct($requestParams);
    }

    public function showProductsPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Products',
            new AdminProductsComponent()
        );
    }

    public function showAddProductPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Add Product',
            new AdminAddProductComponent()
        );
    }

    public function showEditProductPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Edit Product',
            new AdminEditProductComponent()
        );
    }

    public function showEditProductVariantPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Edit Product Variant',
            new AdminEditProductVariantComponent()
        );
    }

    public function showOrdersPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Orders',
            new AdminOrdersComponent()
        );
    }

    public function showCustomersPage(): void
    {
        echo new AdminLayoutComponent(
            'Admin - Customers',
            new AdminCustomersComponent()
        );
    }
}