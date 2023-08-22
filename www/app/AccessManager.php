<?php

namespace jiggle\app;

class AccessManager
{
    public static function isUserLoggedIn(): bool
    {
        session_start();

        if (!empty($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }
}