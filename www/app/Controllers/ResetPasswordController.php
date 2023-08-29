<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Core\View;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AuthContentComponent;
use jiggle\app\Views\Components\AuthLayoutComponent;
use jiggle\app\Views\Components\ChangePasswordComponent;
use jiggle\app\Views\Components\CheckEmailComponent;
use jiggle\app\Views\Components\PasswordChangedComponent;
use jiggle\app\Views\Components\ResetPasswordComponent;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resetPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || AccessController::isUserLoggedIn()) {
            $user = UserModel::getUserById($_SESSION['user_id']);

            if (empty($user->getId())) {
                $user = UserModel::getUserByEmail($_POST['email']);
            }

            if (!empty($user->getId())) {
                $resetKey = md5($user->getEmail() . time());
                $user->updateResetKey($resetKey);
                $this->sendResetPasswordEmail($user->getEmail(), $resetKey);

                echo new AuthLayoutComponent(
                    'Check Your Email',
                    new CheckEmailComponent($user->getEmail())
                );
            } else {
                echo new AuthLayoutComponent(
                    'Forgotten Password',
                    new AuthContentComponent(
                        'Forgotten Password',
                        'Enter your email address, and we will send you instructions to reset your password.',
                        'User with this email address is not registered.',
                        new ResetPasswordComponent()
                    )
                );
            }
        } else {
            echo new AuthLayoutComponent(
                'Forgotten Password',
                new AuthContentComponent(
                    'Forgotten Password',
                    'Enter your email address, and we will send you instructions to reset your password.',
                    '',
                    new ResetPasswordComponent()
                )
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

            if (!FormController::isValidPassword($newPassword)) {
                echo new AuthLayoutComponent(
                    'Change Your Password',
                    new AuthContentComponent(
                        'Change Your Password',
                        'Enter a new password below to change your password.',
                        NotificationMessagesController::getMessage('formError'),
                        new ChangePasswordComponent()
                    )
                );
                exit();
            }

            if ($newPassword === $newPasswordConfirm) {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->updatePassword($newPassword);
                $user->deleteResetKey();

                echo new AuthLayoutComponent(
                    'Password Changed',
                    new PasswordChangedComponent()
                );
            } else {
                echo new AuthLayoutComponent(
                    'Change Your Password',
                    new AuthContentComponent(
                        'Change Your Password',
                        'Enter a new password below to change your password.',
                        'Password mismatch.',
                        new ChangePasswordComponent()
                    )
                );
            }
        } else {
            echo new AuthLayoutComponent(
                'Change Your Password',
                new AuthContentComponent(
                    'Change Your Password',
                    'Enter a new password below to change your password.',
                    '',
                    new ChangePasswordComponent()
                )
            );
        }
    }

    private function sendResetPasswordEmail($email, $resetKey): void
    {
        EmailController::sendEmail(
            'Reset your password',
            'Reset your password using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/change-password?resetKey=' . $resetKey . '">link</a>.',
            'Reset your password on Jiggle',
            $email
        );
    }
}