<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UserModel;

class AccountPagesController extends Controller
{
    public UserModel $model;

    public function __construct()
    {
        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        parent::__construct();
        $this->model = new UserModel();
    }

    public function index(): void
    {
        $this->view->render('account/index', 'My Account');
    }
}