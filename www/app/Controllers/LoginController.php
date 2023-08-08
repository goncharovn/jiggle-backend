<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UserModel;

class LoginController extends Controller
{
    public UserModel $model;

    public function __construct()
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        parent::__construct();
        $this->model = new UserModel();
        $this->view->layout = 'auth';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $user = $this->model->getUserByEmail($email);

            if (password_verify($_POST['password'], $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
            } else {
                $this->view->render(
                    'account/login',
                    'Sign In',
                    [
                        'errorMessage' => 'Invalid email or password',
                    ]
                );
            }
        } else {
            $this->view->render('account/login', 'Log In');
        }
    }
}