<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UsersModel;

class ProfileController extends Controller
{
    public UsersModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UsersModel();
    }

    public function signout(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            $_SESSION['user_id'] = null;
            header('Location: /');
        }
    }
}