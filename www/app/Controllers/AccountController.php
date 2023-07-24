<?php

namespace app\Controllers;

use app\Controller;

class AccountController extends Controller
{
    public function index(): void
    {
        echo 'Account page';
    }

    public function login() {
        echo 'Login page';
    }

    public function signup() {
        echo 'Signup page';
    }

    public function resetPassword() {
        echo 'Reset password page';
    }
}