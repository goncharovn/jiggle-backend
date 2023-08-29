<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\NotificationMessagesManager;
use jiggle\app\FormValidator;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AuthContentComponent;
use jiggle\app\Views\Components\AuthLayoutComponent;
use jiggle\app\Views\Components\CheckEmailSignupComponent;
use jiggle\app\Views\Components\SignupComponent;

class SignupController extends Controller
{
    private ?UserModel $user;

    public function __construct()
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->user = null;

        parent::__construct();
    }

    public function signup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user = UserModel::getUserByEmail($_POST['email']);

            if (!empty($this->user->getId())) {
                NotificationMessagesManager::setMessage(
                    'formError',
                    'This email is already taken.'
                );
                $this->showSignupPage();
            }

            if (!FormValidator::isValidPassword($_POST['password'])) {
                $this->showSignupPage();
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $hash = md5($_POST['email'] . time());

            UserModel::addUser($_POST['email'], $password, $hash);
            $this->sendConfirmationEmail($hash);

            echo new AuthLayoutComponent(
                'Check Your Email',
                new CheckEmailSignupComponent(
                    $_POST['email']
                )
            );
        } else {
            $this->showSignupPage();
        }
    }

    #[NoReturn]
    private function showSignupPage(): void
    {
        echo new AuthLayoutComponent(
            'Sign Up',
            new AuthContentComponent(
                'Welcome',
                'Create your account to continue',
                NotificationMessagesManager::getMessage('formError') ?? '',
                new SignupComponent($this?->user?->getEmail() ?? $_POST['email'] ?? '')
            )
        );
        exit();
    }

    public function confirmSignup(): void
    {
        $hash = $_GET['hash'];
        $user = UserModel::getUserByHash($hash);

        if ($user->getId()) {
            $_SESSION['user_id'] = $user->getId();
            header('Location: /');
        }
    }

    private function sendConfirmationEmail($hash): void
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = '
                <html>
                <head>
                <title>Confirm your Email</title>
                </head>
                <body>
                <p>Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-signup?hash=' . $hash . '">link</a>.</p>
                </body>
                </html>
                ';

        if (!mail($_POST['email'], "Confirm your Email on Jiggle", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}