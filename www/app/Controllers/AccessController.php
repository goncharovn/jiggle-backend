<?php

namespace jiggle\app\Controllers;

use JetBrains\PhpStorm\NoReturn;

class AccessController
{
    public static function isUserLoggedIn(): bool
    {
        if (!empty($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }

    #[NoReturn]
    public static function redirectToUrl($url): void
    {
        header("Location: $url");
        exit();
    }
}