<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Core\View;
use jiggle\app\ErrorMessagesManager;
use jiggle\app\FormValidator;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\CheckEmailView;
use jiggle\app\Views\Layouts\AuthLayout;
use jiggle\app\Views\ResetPasswordView;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resetPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || AccessManager::isUserLoggedIn()) {
            $user = UserModel::getUserById($_SESSION['user_id']);

            if (UserModel::isUserRegistered($user->getId())) {
                $resetKey = md5($user->getEmail() . time());
                $user->updateResetKey($resetKey);
                $this->sendResetPasswordEmail($user->getEmail(), $resetKey);

                AuthLayout::render(
                    'check_email',
                        CheckEmailView::make($user->getEmail())
                );
            } else {
                AuthLayout::render(
                    'Forgotten Password',
                    ResetPasswordView::make(
                        'reset_password',
                        'User with this email address is not registered.'
                    )
                );
            }
        } else {
            AuthLayout::render(
                'Forgotten Password',
                ResetPasswordView::make('reset_password')
            );
        }
    }

    public function changePassword(): void
    {
        $resetKey = $_GET['resetKey'];
        $user = UserModel::getUserByResetKey($resetKey);

        if (!$user->getId()) {
            View::showErrorPage(404);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if (!FormValidator::isValidPassword($newPassword)) {
                AuthLayout::render(
                    'Forgotten Password',
                    ResetPasswordView::make(
                        'reset_password',
                        'User with this email address is not registered.'
                    )
                );
                AuthLayout::render(
                    'Change Your Password',
                    ResetPasswordView::make(
                        'change_password',
                        ErrorMessagesManager::getErrorMessage('formError')
                    )
                );
                exit();
            }

            if ($newPassword === $newPasswordConfirm) {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->updatePassword($newPassword);
                $user->deleteResetKey();

                AuthLayout::render(
                    'Password Changed',
                    ResetPasswordView::make('password_changed')
                );
            } else {
                AuthLayout::render(
                    'Change Your Password',
                    ResetPasswordView::make(
                        'change_password',
                        'Password mismatch.'
                    )
                );
            }
        } else {
            AuthLayout::render(
                'Change Your Password',
                ResetPasswordView::make('change_password')
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