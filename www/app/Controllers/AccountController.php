<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\AccountModel;

class AccountController extends Controller
{
    public Model $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AccountModel();
    }

    public function index(): void
    {
        $this->view->render('account/index', 'My Account');
    }

    public function signup(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->layout = 'auth';
        $this->view->render('account/signup', 'Sign Up');
    }

    public function login(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->layout = 'auth';
        $this->view->render('account/login', 'Log In');
    }

    public function resetPassword(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->layout = 'auth';
        $this->view->render('account/resetPassword', 'Forgotten Password');
    }

    public function handleSignup(): void
    {
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $hash = md5($email . time());

        if ($this->model->isUserRegistered($email)) {
            $errorMessage = 'This email is already taken.';

            $vars = [
                'errorMessage' => $errorMessage,
            ];

            $this->view->layout = 'auth';
            $this->view->render('account/signup', 'Sign Up', $vars);
        } else {
            $this->model->addUser($email, $password, $hash);
            $this->sendConfirmationEmail($email, $hash);
            $user = $this->model->getUserByEmail($email);

            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email_confirmed'] = false;

            header('Location: /');
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

    private static function redirectIfUserIsLoggedIn(): void
    {
        session_start();
        if (!empty($_SESSION['user_id'])) {
            header('Location: /');
        }
    }

    public function handleLogin()
    {

    }
}