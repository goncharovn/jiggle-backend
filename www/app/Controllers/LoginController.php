<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\NotificationMessagesManager;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AuthContentComponent;
use jiggle\app\Views\Components\AuthLayoutComponent;
use jiggle\app\Views\Components\LoginFormComponent;
use jiggle\app\Views\Components\MultiFactorAuthComponent;

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
                NotificationMessagesManager::setMessage('formError', 'Wrong email or password.');
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
            NotificationMessagesManager::setMessage('formError', 'Invalid code.');
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

        echo new AuthLayoutComponent(
            'Multi-Factor Auth',
            new MultiFactorAuthComponent(),
        );
    }

    private function showLoginPage(): void
    {
        $content = new AuthContentComponent(
            'Welcome',
            'Please log in to Jiggle to continue',
            NotificationMessagesManager::getMessage('formError',) ?? '',
            new LoginFormComponent()
        );

        echo new AuthLayoutComponent(
            'Sign In',
            $content
        );
    }

    private function showMultiFactorPage(): void
    {
        echo new AuthLayoutComponent(
            'Multi-Factor Auth',
            new MultiFactorAuthComponent()
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