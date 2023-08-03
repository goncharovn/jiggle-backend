<?php

namespace app\Controllers;

use app\Controller;

class AccountController extends Controller
{
    public function index(): void
    {
        $this->view->render('account/index', 'My Account');
    }

    public function signup()
    {
        $this->view->layout = 'auth';
        $this->view->render('account/signup', 'Sign Up');
    }

    public function login()
    {
        $this->view->layout = 'auth';
        $this->view->render('account/login','Log In');
    }

    public function resetPassword()
    {
        $this->view->layout = 'auth';
        $this->view->render('account/reset-password','Forgotten Password');
    }

    public function handleSignup()
    {
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//        $hash = md5($email . time());
//
//        $headers = "MIME-Version: 1.0\r\n";
//        $headers .= "Content-type: text/html; charset=utf-8\r\n";
//        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";
//
//        $message = '
//                <html>
//                <head>
//                <title>Confirm your Email</title>
//                </head>
//                <body>
//                <p>Confirm your email using this <a href="http://jiggle.com/confirmed.php?hash=' . $hash . '">link</a>.</p>
//                </body>
//                </html>
//                ';

        if ($this->model->isUserRegistered($email)) {
            $errorMessage = 'This email is already taken.';

            $vars = [
                'errorMessage' => $errorMessage,
            ];

            $this->view->layout = 'auth';
            $this->view->render('account/signup', 'Sign Up', $vars);

        } else {
            $this->model->addUser($email, $password, '123');
            header('Location: /login');
        }

//        if (mail($email, "Confirm your Email on Jiggle", $message, $headers)) {
//            header('Location: /');
//        } else {
//            echo 'Error';
//        }
    }

    public function handleLogin()
    {

    }
}