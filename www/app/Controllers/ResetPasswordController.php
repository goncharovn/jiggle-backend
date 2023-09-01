<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
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
    private ?UserModel $user;
    private string $errorMessage;

    public function __construct()
    {
        parent::__construct();

        $this->user = null;
        $this->errorMessage = '';
    }

    public function showResetPasswordPage(): void
    {
        echo new AuthLayoutComponent(
            'Forgotten Password',
            new AuthContentComponent(
                'Forgotten Password',
                'Enter your email address, and we will send you instructions to reset your password.',
                $this->errorMessage,
                new ResetPasswordComponent()
            )
        );
    }

    public function processResetPassword(): void
    {
        $this->user = UserModel::getUserById($_SESSION['user_id']) ?? UserModel::getUserByEmail($_POST['email']);

        if ($this->isUserExists()) {
            $this->requestResetPassword();
        } else {
            $this->errorMessage = 'User with this email address is not registered.';
            $this->showResetPasswordPage();
        }
    }

    public function showChangePasswordPage(): void
    {
        $resetKey = $_GET['resetKey'] ?? null;
        $parametersString = $resetKey ? "?resetKey=$resetKey" : '';

        echo new AuthLayoutComponent(
            'Change Your Password',
            new AuthContentComponent(
                'Change Your Password',
                'Enter a new password below to change your password.',
                $this->errorMessage,
                new ChangePasswordComponent($parametersString)
            )
        );
    }

    public function processChangePassword(): void
    {
        $resetKey = $_GET['resetKey'];
        $this->user = UserModel::getUserByResetKey($resetKey);

        if ($this->isUserExists()) {
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if ($newPassword === $newPasswordConfirm) {
                $this->user->updatePassword(password_hash($newPassword, PASSWORD_DEFAULT));
                $this->user->deleteResetKey();

                echo new AuthLayoutComponent(
                    'Password Changed',
                    new PasswordChangedComponent()
                );
            } else {
                $this->errorMessage = 'Password mismatch.';
                $this->showChangePasswordPage();
            }

            if (!FormController::isValidPassword($newPassword)) {
                $this->errorMessage = NotificationMessagesController::getMessage('formError');
                $this->showChangePasswordPage();
            }
        } else {
            View::showErrorPage(404);
        }
    }

    #[NoReturn]
    private function showCheckEmailPage(): void
    {
        echo new AuthLayoutComponent(
            'Check Your Email',
            new CheckEmailComponent($this->user->getEmail())
        );

        exit();
    }

    #[NoReturn]
    private function requestResetPassword(): void
    {
        $resetKey = md5($this->user->getEmail() . time());
        $this->user->updateResetKey($resetKey);
        $this->sendResetPasswordEmail($this->user->getEmail(), $resetKey);
        $this->showCheckEmailPage();
    }

    private function sendResetPasswordEmail(string $email, string $resetKey): void
    {
        EmailController::sendEmail(
            'Reset your password',
            'Reset your password using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/change-password?resetKey=' . $resetKey . '">link</a>.',
            'Reset your password on Jiggle',
            $email
        );
    }

    private function isUserExists(): bool
    {
        return !empty($this->user);
    }
}