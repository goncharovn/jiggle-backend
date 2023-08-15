<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UsersModel;

class AccountPagesController extends Controller
{
    public UsersModel $model;

    public function __construct()
    {
        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        parent::__construct();
        $this->model = new UsersModel();
    }

    public function index(): void
    {
        $user = $this->model->getUserById($_SESSION['user_id']);

        $this->view->render(
            'account/index',
            'My Account',
            [
                'user' => $user
            ]
        );
    }

    public function orderHistory(): void
    {
        $this->view->render('account/orderHistory', 'My Account - Order History');
    }

    public function deliveryAddress(): void
    {
        $this->view->render('account/deliveryAddress', 'My Account - Delivery Addresses');
    }

    public function myDetails(): void
    {
        session_start();

        $user = $this->model->getUserById($_SESSION['user_id']);

        $this->view->render(
            'account/myDetails',
            'My Account - My Details',
            [
                'user' => $user
            ]
        );
    }
}