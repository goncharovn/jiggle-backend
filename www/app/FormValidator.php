<?php

namespace jiggle\app;

class FormValidator
{
    public static function isValidEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ErrorMessagesManager::addNewMessage('formError', 'Invalid email.');
        } elseif (strlen($email) > 255) {
            ErrorMessagesManager::addNewMessage('formError', 'Email address is too long.');
        } else {
            return true;
        }

        return false;
    }

    public static function isValidPassword($password): bool
    {
        if (strlen($password) < '6') {
            ErrorMessagesManager::addNewMessage('formError', 'Password must contain at least 6 characters.');
        } elseif (!preg_match("#[0-9]+#", $password)) {
            ErrorMessagesManager::addNewMessage('formError', 'Password must contain at least 1 number.');
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            ErrorMessagesManager::addNewMessage('formError', 'Password must contain at least 1 capital letter.');
        } elseif (!preg_match("#[a-z]+#", $password)) {
            ErrorMessagesManager::addNewMessage('formError', 'Password must contain at least 1 lowercase letter.');
        } elseif (strlen($password) > '128') {
            ErrorMessagesManager::addNewMessage('formError', 'Password must not contain more than 128 characters.');
        }
        else {
            return true;
        }

        return false;
    }
}