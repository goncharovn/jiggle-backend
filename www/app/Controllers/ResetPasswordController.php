<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\ErrorMessagesManager;
use app\FormValidator;
use app\Models\UserModel;
use app\View;

class ResetPasswordController extends Controller
{
    public UserModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
        $this->view->layout = 'auth';
    }

    public function resetPassword(): void
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || AccessManager::isUserLoggedIn()) {
            $email = $_POST['email'] ?? $_SESSION['user_email'];

            if ($this->model->isUserRegistered($email)) {
                $resetKey = md5($email . time());

                $this->model->addResetKey($email, $resetKey);
                $this->sendResetPasswordEmail($email, $resetKey);
                $this->view->render(
                    'checkEmail',
                    'Check your email',
                    [
                        'email' => $email,
                    ]
                );
            } else {
                $this->view->render(
                    'reset_password',
                    'Forgotten Password',
                    [
                        'errorMessage' => 'User with this email address is not registered.',
                    ]
                );
            }
        } else {
            $this->view->render(
                'reset_password',
                'Forgotten Password'
            );
        }
    }

    public function changePassword(): void
    {
        $resetKey = $_GET['resetKey'];
        $user = $this->model->getUserByResetKey($resetKey);

        if (!$user) {
            View::showErrorPage(404);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if (!FormValidator::isValidPassword($newPassword)) {
                $this->view->render(
                    'change_password',
                    'Change Your Password',
                    [
                        'errorMessage' => ErrorMessagesManager::getErrorMessage('formError')
                    ]
                );
                exit();
            }

            if ($newPassword === $newPasswordConfirm) {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $this->model->changePassword($resetKey, $newPassword);
                $this->model->deleteResetKey($resetKey);

                $this->view->render(
                    'password_changed',
                    'Password changed'
                );
            } else {
                $this->view->render(
                    'change_password',
                    'Change Your Password',
                    [
                        'errorMessage' => 'Password mismatch.',
                    ]
                );
            }
        } else {
            $this->view->render(
                'change_password',
                'Change Your Password'
            );
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
}