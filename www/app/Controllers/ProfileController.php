<?php

namespace app\Controllers;

use app\AccessManager;
use app\Controller;
use app\ErrorMessagesManager;
use app\Models\UserModel;

class ProfileController extends Controller
{
    public UserModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();

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
        session_start();

        $userId = $_SESSION['user_id'];

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $userName = $firstName . ' ' . $lastName;

        $this->model->updateUserName($userName, $userId);

        header('Location: /my-account/my-details');
    }

    public function changeEmail(): void
    {
        session_start();

        $email = $_POST['email'];

        $userId = $_SESSION['user_id'];

        $hash = md5($email . time());

        $this->model->updateUserNewEmail($email, $userId);
        $this->model->updateUserHash($hash, $userId);

        $this->sendConfirmationEmail($email, $hash);

        $user = $this->model->getUserById($userId);

        $this->view->render(
            'account/my_details',
            'My Account - My Details',
            [
                'user' => $user,
                'emailMessage' => "Check  $email to update your email address."
            ]
        );
    }

    public function confirmEmail()
    {
        session_start();

        $hash = $_GET['hash'];
        $user = $this->model->getUserByHash($hash);

        if (!empty($user)) {
            $_SESSION['user_id'] = $user['id'];
            $this->model->updateUserEmail($user['new_email'], $user['id']);
            $_SESSION['user_email'] = $user['new_email'];

            header('Location: /');
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
                <p>Confirm your email using this <a href="http://' . $_SERVER['HTTP_HOST'] . '/confirm-email?hash=' . $hash . '">link</a>.</p>
                </body>
                </html>
                ';

        if (!mail($email, "Confirm your Email on Jiggle", $message, $headers)) {
            echo 'Email sending error';
        }
    }
}