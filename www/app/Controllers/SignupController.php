<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AuthContentComponent;
use jiggle\app\Views\Components\AuthLayoutComponent;
use jiggle\app\Views\Components\CheckEmailSignupComponent;
use jiggle\app\Views\Components\SignupComponent;

class SignupController extends Controller
{
    private ?UserModel $user;

    public function __construct()
    {
        parent::__construct();

        if (AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }

        $this->user = null;
    }

    #[NoReturn]
    public function processSignup(): void
    {
        $this->user = UserModel::getUserByEmail($_POST['email']);

        if ($this->isUserExists()) {
            NotificationMessagesController::setMessage(
                'formError',
                'This email is already taken.'
            );
            $this->showSignupPage();
        }

        if (!FormController::isValidPassword($_POST['password'])) {
            $this->showSignupPage();
        }

        $this->registerUser();
    }

    #[NoReturn]
    public function showSignupPage(): void
    {
        echo new AuthLayoutComponent(
            'Sign Up',
            new AuthContentComponent(
                'Welcome',
                'Create your account to continue',
                NotificationMessagesController::getMessage('formError') ?? '',
                new SignupComponent($this?->user?->getEmail() ?? $_POST['email'] ?? '')
            )
        );

        exit();
    }

    #[NoReturn]
    public function confirmSignup(): void
    {
        $hash = $_GET['hash'];
        $this->user = UserModel::getUserByHash($hash);

        if ($this->isUserExists()) {
            $this->completeSignup();
        }
    }

    private function sendConfirmationEmail(string $hash): void
    {
        EmailController::sendEmail(
            'Confirm your Email',
            'Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-signup?hash=' . $hash . '">link</a>.',
            'Confirm your Email on Jiggle',
            $_POST['email']
        );
    }

    private function isUserExists(): bool
    {
        return !empty($this->user);
    }

    #[NoReturn]
    private function showCheckEmailPage(): void
    {
        echo new AuthLayoutComponent(
            'Check Your Email',
            new CheckEmailSignupComponent(
                $this->user->getEmail()
            )
        );

        exit();
    }

    #[NoReturn]
    private function registerUser(): void
    {

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $hash = md5($_POST['email'] . time());
        UserModel::addUser($_POST['email'], $password, $hash);
        $this->sendConfirmationEmail($hash);
        $this->showCheckEmailPage();
    }

    private function addUserToSession(): void
    {
        $_SESSION['user_id'] = $this->user->getId();
    }

    #[NoReturn]
    private function completeSignup(): void
    {
        $this->addUserToSession();
        AccessController::redirectToUrl('/');
    }
}