<?php

namespace app\Controllers;

use app\Controller;

class AccountController extends Controller
{
    public function index(): void
    {
        $this->view->render('My Account');
    }

    public function login()
    {
        $this->view->render('Log In');
    }

    public function signup()
    {
        $this->view->render('Sign Up');
    }

    public function resetPassword()
    {
        $this->view->render('Forgotten Password');
    }
}