<?php

declare(strict_types=1);

namespace Helper;

class Logger
{
    public static function log(string $message): void
    {
        $path = PROJECT_ROOT_DIR . '\var\log\debug.log';
        $message = date('Y/m/d G:i:s') . ' ' . $message;
        error_log($message."\n", 3, $path);
    }
}































