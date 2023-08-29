<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\AdminAddProductView;
use jiggle\app\Views\AdminCustomersView;
use jiggle\app\Views\AdminEditProductVariantView;
use jiggle\app\Views\AdminEditProductView;
use jiggle\app\Views\AdminOrdersView;
use jiggle\app\Views\AdminProductsView;
use jiggle\app\Views\Layouts\AdminLayout;

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
        AdminLayout::render(
            'Admin - Products',
            AdminProductsView::make()
        );
    }

    public function showAddProductPage(): void
    {
        AdminLayout::render(
            'Admin - Add Product',
            AdminAddProductView::make()
        );
    }

    public function showEditProductPage(): void
    {
        AdminLayout::render(
            'Admin - Edit Product',
            AdminEditProductView::make()
        );
    }

    public function showEditProductVariantPage(): void
    {
        AdminLayout::render(
            'Admin - Edit Product Variant',
            AdminEditProductVariantView::make()
        );
    }

    public function showOrdersPage(): void
    {
        AdminLayout::render(
            'Admin - Orders',
            AdminOrdersView::make()
        );
    }

    public function showCustomersPage(): void
    {
        AdminLayout::render(
            'Admin - Customers',
            AdminCustomersView::make()
        );
    }
}