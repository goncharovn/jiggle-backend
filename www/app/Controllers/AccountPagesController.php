<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UserModel;

class AccountPagesController extends Controller
{
    public UserModel $model;
    private bool $isAdmin = false;

    public function __construct()
    {
        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->isAdmin = $_SESSION['user_role'] === 'admin';

        parent::__construct();
        $this->model = new UserModel();
    }

    public function index(): void
    {

        $user = $this->model->getUserById($_SESSION['user_id']);

        $this->view->render(
            'account/index',
            'My Account',
            [
                'user' => $user,
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function orderHistory(): void
    {
        $this->view->render(
            'account/order_history',
            'My Account - Order History',
            [
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function deliveryAddress(): void
    {
        $this->view->render(
            'account/delivery_address',
            'My Account - Delivery Addresses',
            [
                'isAdmin' => $this->isAdmin,
            ]
        );
    }

    public function myDetails(): void
    {
        session_start();

        $user = $this->model->getUserById($_SESSION['user_id']);


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