<?php

namespace app\Controllers;

use app\Controller;
use app\Model;
use app\Models\AccountModel;
use app\View;

class AccountController extends Controller
{
    public Model $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AccountModel();
        $this->view->layout = 'auth';
    }

    public function index(): void
    {
        $this->view->render('account/index', 'My Account');
    }

    public function signup(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->render('account/signup', 'Sign Up');
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

    public function login(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->render('account/login', 'Log In');
    }

    public function handleLogin(): void
    {
        $email = $_POST['email'] ?? '';
        $user = $this->model->getUserByEmail($email);

        if (password_verify($_POST['password'], $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];

            header('Location: /');
        } else {
            $errorMessage = 'Invalid email or password';

            $vars = [
                'errorMessage' => $errorMessage,
            ];

            $this->view->render('account/login', 'Sign In', $vars);
        }
    }

    public function resetPassword(): void
    {
        AccountController::redirectIfUserIsLoggedIn();

        $this->view->render('account/resetPassword', 'Forgotten Password');
    }

    public function handleResetPassword(): void
    {
        $email = $_POST['email'];

        if ($this->model->isUserRegistered($email)) {
            $resetKey = md5($email . time());

            $this->model->addResetKey($email, $resetKey);
            $this->sendResetPasswordEmail($email, $resetKey);
            $this->view->render('account/checkEmail', 'Check your email', [
                'email' => $email,
            ]);
        } else {
            $errorMessage = 'User with this email address is not registered.';

            $vars = [
                'errorMessage' => $errorMessage,
            ];

            $this->view->render('account/resetPassword', 'Forgotten Password', $vars);
        }
    }

    public function changePassword(): void
    {
        $resetKey = $_GET['resetKey'];
        $user = $this->model->getUserByResetKey($resetKey);

        if (!$user) {
            View::errorCode(404);
        } else if (isset($_POST['new_password'])) {
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if ($newPassword === $newPasswordConfirm) {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $this->model->changePassword($resetKey, $newPassword);
                $this->model->deleteResetKey($resetKey);

                $this->view->render('account/passwordChanged', 'Password changed');
            } else {
                $this->view->render('account/changePassword', 'Change Your Password', [
                    'errorMessage' => 'Password mismatch.',
                ]);
            }
        } else {
            $this->view->render('account/changePassword', 'Change Your Password');
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

    private function sendResetPasswordEmail($email, $resetKey): void
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = '
                <html>
                <head>
                <title>Reset your password</title>
                </head>
                <body>
                <p>Reset your password using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/change-password?resetKey=' . $resetKey . '">link</a>.</p>
                </body>
                </html>
                ';

        if (!mail($email, "Reset your password on Jiggle", $message, $headers)) {
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
}