<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
        }
    }

    public function signout(): void
    {
        if (AccessManager::isUserLoggedIn()) {
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

        $this->view->render(
            'account/my_details',
            'My Account - My Details',
            [
                'user' => $user,
                'emailMessage' => "Check  $newEmail to update your email address.",
            ]
        );
    }

    public function confirmEmail()
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
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = '
                <html>
                <head>
                <title>Confirm your Email</title>
                </head>
                <body>
                <p>Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-email?hash=' . $hash . '">link</a>.</p>
                </body>
                </html>
                ';

        if (!mail($email, "Confirm your Email on Jiggle", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}