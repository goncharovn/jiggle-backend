<?php

namespace jiggle\app;

class FormValidator
{
    public static function isValidEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            NotificationMessagesManager::setMessage('formError', 'Invalid email.');
        } else {
            return true;
        }

        return false;
    }

    public static function isValidPassword($password): bool
    {
        if (!preg_match("#([0-9]+|[A-Z]+|[a-z]+)#", $password) ||
            strlen($password) < 6 ||
            strlen($password) > 128) {
            NotificationMessagesManager::setMessage(
                'formError',
                'Password must contain from 6 to 128 characters, lowercase letter, uppercase letter and number'
            );
            return false;
        }

        return true;
    }
}