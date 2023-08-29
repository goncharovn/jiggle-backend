<?php

namespace jiggle\app;

class NotificationMessagesManager
{
    private static array $messages = [];

    public static function getMessage(string $messageName)
    {
        return self::$messages[$messageName] ?? '';
    }

    public static function setMessage($messageName, $messageText): void
    {
        self::$messages[$messageName] = $messageText;
    }

    public static function deleteErrorMessage($messageName): void
    {
        unset(self::$messages[$messageName]);
    }
}