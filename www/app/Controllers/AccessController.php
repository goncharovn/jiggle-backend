<?php

namespace jiggle\app\Controllers;

class AccessController
{
    public static function isUserLoggedIn(): bool
    {
        if (!empty($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }
}