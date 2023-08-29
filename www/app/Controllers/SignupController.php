<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\FormValidator;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\CheckEmailSignupView;
use jiggle\app\Views\Layouts\AuthLayout;
use jiggle\app\Views\SignupView;

class SignupController extends Controller
{
    public function __construct()
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        parent::__construct();
    }

    public function signup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            if (!FormValidator::isValidEmail($email)) {
                $this->showSignupPage($email);
                exit();
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if (!FormValidator::isValidPassword($_POST['password'])) {
                $this->showSignupPage($email);
                exit();
            }

            $hash = md5($email . time());

            if (UserModel::isUserRegistered($email)) {
                AuthLayout::render(
                    'Sign Up',
                    SignupView::make(
                        'This email is already taken.',
                        $email
                    )
                );
            } else {
                UserModel::addUser($email, $password, $hash);
                $this->sendConfirmationEmail($email, $hash);

                AuthLayout::render(
                    'Check Your Email',
                    CheckEmailSignupView::make(
                        $email
                    )
                );
            }
        } else {
            AuthLayout::render(
                'Sign Up',
                SignupView::make()
            );
        }
    }

    private function showSignupPage(?string $email): void
    {
        AuthLayout::render(
            'Sign Up',
            SignupView::make(
                ErrorMessagesManager::getErrorMessage('formError') ?? '',
                $email
            )
        );
    }

    public function confirmSignup(): void
    {
        $hash = $_GET['hash'];
        $user = UserModel::getUserByHash($hash);

        if ($user->getId()) {
            $_SESSION['user_id'] = $user['id'];

            header('Location: /');
        }
    }

    private function sendConfirmationEmail($email, $hash): void
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

        if (!mail($email, "Confirm your Email on Jiggle", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}