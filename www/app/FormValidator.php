<?php

namespace jiggle\app;

class FormValidator
{
    public static function isValidEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ErrorMessagesManager::addNewMessage('formError', 'Invalid email.');
        } else {
            return true;
        }

        return false;
    }

    public static function isValidPassword($password): bool
    {
        $errorMessages = [
            strlen($password) < 6 => 'Password must contain at least 6 characters.',
            !preg_match("#[0-9]+#", $password) => 'Password must contain at least 1 number.',
            !preg_match("#[A-Z]+#", $password) => 'Password must contain at least 1 capital letter.',
            !preg_match("#[a-z]+#", $password) => 'Password must contain at least 1 lowercase letter.',
            strlen($password) > 128 => 'Password must not contain more than 128 characters.'
        ];

        foreach ($errorMessages as $condition => $message) {
            if ($condition) {
                ErrorMessagesManager::addNewMessage('formError', $message);
                return false;
            }
        }

        return false;
    }
}