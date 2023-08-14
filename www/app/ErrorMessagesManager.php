<?php

namespace app;

class ErrorMessagesManager
{
    private static array $errorMessages = [];

    public static function getErrorMessage(string $messageName)
    {
        return self::$errorMessages[$messageName];
    }

    public static function addNewMessage($messageName, $messageText): void
    {
        self::$errorMessages[$messageName] = $messageText;
    }

    public static function deleteErrorMessage($messageName): void
    {
        unset(self::$errorMessages[$messageName]);
    }
}