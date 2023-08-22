<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;

class AccountPagesController extends Controller
{
    private bool $isAdmin = false;

    public function __construct()
    {
        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->isAdmin = $_SESSION['user_role'] === 'admin';

        parent::__construct();
    }

    public function showOverviewPage(): void
    {
        $user = UserModel::getUserById($_SESSION['user_id']);

        $this->view->render(
            'account/index',
            'My Account',
            [
                'user' => $user,
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function showOrderHistoryPage(): void
    {
        $this->view->render(
            'account/order_history',
            'My Account - Order History',
            [
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function showDeliveryAddressPage(): void
    {
        $this->view->render(
            'account/delivery_address',
            'My Account - Delivery Addresses',
            [
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function showMyDetailsPage(): void
    {
        session_start();

        $user = UserModel::getUserById($_SESSION['user_id']);


        $this->view->render(
            'account/my_details',
            'My Account - My Details',
            [
                'user' => $user,
                'isAdmin' => $this->isAdmin,
            ]
        );
    }
}