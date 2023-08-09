<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UsersModel;

class LoginController extends Controller
{
    public UsersModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UsersModel();
        $this->view->layout = 'auth';
    }

    public function login(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $user = $this->model->getUserByEmail($email);

            if (password_verify($_POST['password'], $user['password'])) {
                session_start();

                if ($user['2fa_enabled']) {
                    $_SESSION['email'] = $email;
                    header('Location: login/process-2fa');
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: /');
                }
            } else {
                $this->view->render(
                    'login',
                    'Sign In',
                    [
                        'errorMessage' => 'Invalid email or password',
                    ]
                );
            }
        } else {
            $this->view->render('login', 'Log In');
        }
    }

    public function enableMultiFactorAuth(): void
    {
        session_start();
        $user = $this->model->getUserById($_SESSION['user_id']);
        $this->model->enableMultiFactorAuth($user['email']);
        header('Location: /my-account/my-details');
    }

    public function disableMultiFactorAuth(): void
    {
        session_start();
        $user = $this->model->getUserById($_SESSION['user_id']);
        $this->model->disableMultiFactorAuth($user['email']);
        header('Location: /my-account/my-details');
    }

    public function processMultiFactorAuth(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        session_start();
        $email = $_SESSION['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->model->getUserByEmail($email);
            $code = $_POST['two_factor_code'];
            $hashedMFACode = $this->model->getMFACode($email);

            if (password_verify($code, $hashedMFACode)) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
            } else {
                $this->view->render(
                    'multiFactor',
                    'Multi-factor Auth',
                    [
                        'errorMessage' => 'Invalid code.'
                    ]
                );
            }
        } else {
            $MFACode = mt_rand(100000, 999999);
            $hashedMFACode = password_hash($MFACode, PASSWORD_DEFAULT);

            $this->model->setMFACode($hashedMFACode, $email);
            $this->view->render('multiFactor', 'Multi-factor Auth');
            $this->sendTwoFactorCode($email, $MFACode);
        }
    }

    private function sendTwoFactorCode($email, $code): void
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = "
                <html>
                <head>
                <title>Multi-factor code</title>
                </head>
                <body>
                <p>Enter this code $code.</p>
                </body>
                </html>
                ";

        if (!mail($email, "Multi-factor auth", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}