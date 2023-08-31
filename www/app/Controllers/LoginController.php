<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AuthContentComponent;
use jiggle\app\Views\Components\AuthLayoutComponent;
use jiggle\app\Views\Components\LoginFormComponent;
use jiggle\app\Views\Components\MultiFactorAuthComponent;

class LoginController extends Controller
{
    private UserModel $user;

    #[NoReturn]
    public function showLoginPage(): void
    {
        if (AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        $content = new AuthContentComponent(
            'Welcome',
            'Please log in to Jiggle to continue',
            NotificationMessagesController::getMessage('formError',) ?? '',
            new LoginFormComponent()
        );

        echo new AuthLayoutComponent(
            'Sign In',
            $content
        );

        exit();
    }

    #[NoReturn]
    public function processLogin(): void
    {
        if (AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        $email = $_POST['email'];
        $this->user = UserModel::getUserByEmail($email);

        if ($this->isPasswordMatch($_POST['password']) && $this->isUserExists()) {
            if ($this->user->isMultiFactorAuthEnabled()) {
                $this->requestTwoFactorAuthCode();
            } else {
                $this->completeLogin();
            }
        } else {
            $this->handleFailedLogin('Wrong email or password', function () {
                $this->showLoginPage();
            });
        }
    }

    #[NoReturn]
    public function showMultiFactorPage(): void
    {
        if (AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        echo new AuthLayoutComponent(
            'Multi-Factor Auth',
            new MultiFactorAuthComponent()
        );

        exit();
    }

    #[NoReturn]
    public function processMultiFactorAuth(): void
    {
        if (AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        $this->user = UserModel::getUserByEmail($_SESSION['email']);

        if ($this->isMultiFactorAuthCodeMatch($_POST['multi_factor_auth_code'])) {
            $this->completeLogin();
        } else {
            $this->handleFailedLogin('Invalid code', function () {
                $this->showMultiFactorPage();
            });
        }
    }

    #[NoReturn]
    public function toggleMultiFactorAuth(): void
    {
        if (!AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        $this->user = UserModel::getUserById($_SESSION['user_id']);
        $this->user->toggleMultifactorAuth();
    }

    #[NoReturn]
    private function requestTwoFactorAuthCode(): void
    {
        $this->generateAndSendMultiFactorAuthCode();
        $this->showMultiFactorPage();
    }

    #[NoReturn]
    private function completeLogin(): void
    {
        $this->addUserToSession();
        AccessController::redirectToUrl('/');
    }

    #[NoReturn]
    private function handleFailedLogin(string $errorMessage, callable $showPageCallback): void
    {
        NotificationMessagesController::setMessage('formError', $errorMessage);
        $showPageCallback();
    }

    private function isPasswordMatch(string $password): bool
    {
        return password_verify($password, $this->user->getPassword());
    }

    private function isMultiFactorAuthCodeMatch(string $multiFactorAuthCode): string
    {
        return password_verify($this->user->getMultiFactorAuthCode(), $multiFactorAuthCode);
    }

    private function generateAndSendMultiFactorAuthCode(): void
    {
        $multiFactorAuthCode = mt_rand(100000, 999999);
        $this->sendMultiFactorAuthCode($multiFactorAuthCode);

        $hashedMultiFactorAuthCode = password_hash($multiFactorAuthCode, PASSWORD_DEFAULT);
        $this->user->setMultiFactorAuthCode($hashedMultiFactorAuthCode);

        $_SESSION['email'] = $this->user->getEmail();
    }

    private function sendMultiFactorAuthCode(string $multiFactorAuthCode): void
    {
        EmailController::sendEmail(
            'Reset your password',
            "Enter this code $multiFactorAuthCode.",
            'Multi-factor auth on Jiggle',
            $this->user->getEmail()
        );
    }

    private function addUserToSession(): void
    {
        $_SESSION['user_id'] = $this->user->getId();
    }

    private function isUserExists(): bool
    {
        return !empty($this->user->getId());
    }
}