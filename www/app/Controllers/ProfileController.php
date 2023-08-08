<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UserModel;

class ProfileController extends Controller
{
    public UserModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
    }

    public function signout(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            $_SESSION['user_id'] = null;
            header('Location: /');
        }
    }
}