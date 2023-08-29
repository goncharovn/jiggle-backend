<?php

namespace jiggle\app\Controllers;

class EmailController
{
    public static function sendEmail($title, $text, $subject, $to): void
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Jiggle <nagoncharov11@gmail.com>\r\n";

        $message = "
                <html>
                <head>
                <title>$title</title>
                </head>
                <body>
                <p>$text</p>
                </body>
                </html>
                ";

        if (!mail($to, $subject, $message, $headers)) {
            echo 'Email sending error';
        }
    }
}