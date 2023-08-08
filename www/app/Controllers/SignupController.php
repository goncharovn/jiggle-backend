<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\Models\UserModel;

class SignupController extends Controller
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

    public function signup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $hash = md5($email . time());

            if ($this->model->isUserRegistered($email)) {
                $this->view->render(
                    'account/signup',
                    'Sign Up',
                    [
                        'errorMessage' => 'This email is already taken.',
                    ]
                );
            } else {
                $this->model->addUser($email, $password, $hash);
                $this->sendConfirmationEmail($email, $hash);
                $user = $this->model->getUserByEmail($email);

                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email_confirmed'] = false;
                header('Location: /');
            }
        } else {
            $this->view->render('account/signup', 'Sign Up');
        }
    }

    public function confirmSignup(): void
    {
        $hash = $_GET['hash'];
        $user = $this->model->getUserByHash($hash);
        $isEmailConfirmed = $user['email_confirmed'];

        if ($isEmailConfirmed) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email_confirmed'] = true;
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