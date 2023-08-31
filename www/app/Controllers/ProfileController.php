<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AccountBodyComponent;
use jiggle\app\Views\Components\AccountComponent;
use jiggle\app\Views\Components\AccountMenuComponent;
use jiggle\app\Views\Components\DefaultLayoutComponent;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!AccessController::isUserLoggedIn()) {
            AccessController::redirectToUrl('/');
        }
    }

    public function signout(): void
    {
        if (AccessController::isUserLoggedIn()) {
            session_destroy();
            AccessController::redirectToUrl('/');
        }
    }

    #[NoReturn]
    public function changeName(): void
    {
        $username = $_POST['first_name'] . ' ' . $_POST['last_name'];
        $user = UserModel::getUserById($_SESSION['user_id']);
        $user->updateName($username);
        AccessController::redirectToUrl('/my-account/my-details');
    }

    public function changeEmail(): void
    {
        $newEmail = $_POST['email'];
        $hash = md5($newEmail . time());
        $user = UserModel::getUserById($_SESSION['user_id']);
        $user->updateNewEmail($newEmail);
        $user->updateHash($hash);

        $this->sendConfirmationEmail($hash);

        echo new DefaultLayoutComponent(
            'My Account - My Details',
            new AccountComponent(
                new AccountMenuComponent($user->getRole() === 'admin'),
                'My Details',
                new AccountBodyComponent(
                    'my_details',
                    $user
                )
            )
        );
    }

    #[NoReturn]
    public function confirmEmail(): void
    {
        $hash = $_GET['hash'];
        $user = UserModel::getUserByHash($hash);
        $_SESSION['user_id'] = $user->getId();
        $user->updateEmail($user->getNewEmail());
        $_SESSION['user_email'] = $user->getNewEmail();
        AccessController::redirectToUrl('/');
    }

    private function sendConfirmationEmail(string $hash): void
    {
        EmailController::sendEmail(
            'Confirm your Email',
            'Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-email?hash=' . $hash . '">link</a>.',
            'Confirm your Email on Jiggle',
            $_POST['email']
        );
    }
}