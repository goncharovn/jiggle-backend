<?php

namespace jiggle\app\Controllers;

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
            header('Location: /');
        }
    }

    public function signout(): void
    {
        if (AccessController::isUserLoggedIn()) {
            session_destroy();
            header('Location: /');
        }
    }

    public function changeName(): void
    {
        $userId = $_SESSION['user_id'];

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $username = $firstName . ' ' . $lastName;

        $user = UserModel::getUserById($userId);
        $user->updateName($username);

        header('Location: /my-account/my-details');
    }

    public function changeEmail(): void
    {
        $newEmail = $_POST['email'];
        $userId = $_SESSION['user_id'];
        $hash = md5($newEmail . time());
        $user = UserModel::getUserById($userId);

        $user->updateNewEmail($newEmail);
        $user->updateHash($hash);

        $this->sendConfirmationEmail($newEmail, $hash);

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

    public function confirmEmail(): void
    {
        $hash = $_GET['hash'];
        $user = UserModel::getUserByHash($hash);
        $_SESSION['user_id'] = $user->getId();
        $user->updateEmail($user->getNewEmail());
        $_SESSION['user_email'] = $user->getNewEmail();

        header('Location: /');
    }

    private function sendConfirmationEmail($email, $hash): void
    {
        EmailController::sendEmail(
            'Confirm your Email',
            'Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-email?hash=' . $hash . '">link</a>.',
            'Confirm your Email on Jiggle',
            $_POST['email']
        );
    }
}