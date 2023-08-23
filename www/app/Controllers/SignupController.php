<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\FormValidator;
use jiggle\app\Models\UserModel;

class SignupController extends Controller
{
    public function __construct()
    {
        if (AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        parent::__construct();
        $this->view->layout = 'auth';
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
                $this->view->render(
                    'signup',
                    'Sign Up',
                    [
                        'errorMessage' => 'This email is already taken.',
                    ]
                );
            } else {
                UserModel::addUser($email, $password, $hash);
                $this->sendConfirmationEmail($email, $hash);
                $this->view->render(
                    'check_email_signup',
                    'Check email',
                    [
                        'email' => $email,
                    ]
                );
            }
        } else {
            $this->view->render(
                'signup',
                'Sign Up'
            );
        }
    }

    private function showSignupPage($email = ''): void
    {
        $this->view->render(
            'signup',
            'Sign Up',
            [
                'errorMessage' => ErrorMessagesManager::getErrorMessage('formError') ?? '',
                'email' => $email ?? ''
            ]
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