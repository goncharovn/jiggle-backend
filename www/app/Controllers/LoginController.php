<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\Models\UserModel;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->layout = 'auth';
    }

    public function processLogin(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = UserModel::getUserByEmail($email);

            if (password_verify($password, $user->getPassword()) && !empty($user)) {
                if ($user->isTwoFactorAuthEnabled()) {
                    $_SESSION['email'] = $email;
                    header('Location: login/process-2fa');
                } else {
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_role'] = $user->getRole();

                    header('Location: /');
                }
            } else {
                ErrorMessagesManager::addNewMessage('formError', 'Wrong email or password.');
            }
        }

        $this->showLoginPage();
    }

    public function enableMultiFactorAuth(): void
    {
        $user = UserModel::getUserById($_SESSION['user_id']);
        $user->enableMultiFactorAuth();

        header('Location: /my-account/my-details');
    }

    public function disableMultiFactorAuth(): void
    {
        $user = UserModel::getUserById($_SESSION['user_id']);
        $user->disableMultiFactorAuth();

        header('Location: /my-account/my-details');
    }

    public function processMultiFactorAuth(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $email = $_SESSION['email'];
        $user = UserModel::getUserByEmail($email);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['two_factor_code'];
            $hashedMFACode = $user->getMFACode();

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

            $user->setMFACode($hashedMFACode);
            $this->view->render(
                'multi_factor',
                'Multi-factor Auth'
            );
            $this->sendTwoFactorCode($email, $MFACode);
        }
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

    private function showMultiFactorPage(): void
    {
        $this->view->render(
            'multi_factor',
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