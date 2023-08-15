<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\ErrorMessagesManager;
use app\FormValidator;
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
            $password = $_POST['password'];
            $user = $this->model->getUserByEmail($email);

            if (password_verify($password, $user['password']) && !empty($user)) {
                session_start();

                if ($user['2fa_enabled']) {
                    $_SESSION['email'] = $email;
                    header('Location: login/process-2fa');
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $email;

                    header('Location: /');
                }
            } else {
                ErrorMessagesManager::addNewMessage('formError', 'Wrong email or password.');
            }
        }

        $this->showLoginPage();
    }

    private function showLoginPage(): void
    {
        $this->view->render(
            'login',
            'Sign In',
            [
                'formError' => ErrorMessagesManager::getErrorMessage('formError',) ?? '',
            ]
        );
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

            if (password_verify($code, $hashedMFACode) && !empty($user)) {
                $_SESSION['user_id'] = $user['id'];

                header('Location: /');
            } else {
                ErrorMessagesManager::addNewMessage('formError', 'Invalid code.');
                $this->showMultiFactorPage();
            }
        } else {
            $MFACode = mt_rand(100000, 999999);
            $hashedMFACode = password_hash($MFACode, PASSWORD_DEFAULT);

            $this->model->setMFACode($hashedMFACode, $email);
            $this->view->render('multiFactor', 'Multi-factor Auth');
            $this->sendTwoFactorCode($email, $MFACode);
        }
    }

    private function showMultiFactorPage(): void
    {
        $this->view->render(
            'multiFactor',
            'Multi-factor Auth',
            [
                'formError' => ErrorMessagesManager::getErrorMessage('formError'),
            ]
        );
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