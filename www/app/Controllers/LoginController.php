<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Layouts\AuthLayout;
use jiggle\app\Views\LoginView;
use jiggle\app\Views\MultiFactorAuthView;

class LoginController extends Controller
{
    private UserModel $user;

    public function processLogin(): void
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $this->user = UserModel::getUserByEmail($email);

            if (password_verify($password, $this->user->getPassword())) {
                if ($this->user->isTwoFactorAuthEnabled()) {
                    $this->showMultiFactorAuthPage();
                    exit();
                } else {
                    $_SESSION['user_id'] = $this->user->getId();
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
        $this->user = UserModel::getUserByEmail($_SESSION['email']);
        $code = $_POST['two_factor_code'];
        $hashedMFACode = $this->user->getMFACode();

        if (password_verify($code, $hashedMFACode) && !empty($this->user->getId())) {
            $_SESSION['user_id'] = $this->user->getId();
            header('Location: /');
        } else {
            ErrorMessagesManager::addNewMessage('formError', 'Invalid code.');
            $this->showMultiFactorPage();
        }
    }

    private function showMultiFactorAuthPage(): void
    {
        $MFACode = mt_rand(100000, 999999);
        $hashedMFACode = password_hash($MFACode, PASSWORD_DEFAULT);
        $this->user->setMFACode($hashedMFACode);
        $this->sendTwoFactorCode($MFACode);
        $_SESSION['email'] = $this->user->getEmail();

        AuthLayout::render(
            'multi_factor',
            MultiFactorAuthView::make()
        );
    }

    private function showLoginPage(): void
    {
        AuthLayout::render(
            'Sign In',
            LoginView::make()
        );
    }

    private function showMultiFactorPage(): void
    {
        AuthLayout::render(
            'Multi-Factor Auth',
            MultiFactorAuthView::make()
        );
    }

    private function sendTwoFactorCode($code): void
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = "Enter this code $code.";

        if (!mail($this->user->getEmail(), "Multi-factor auth", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}