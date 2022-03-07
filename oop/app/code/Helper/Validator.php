<?php

declare(strict_types=1);

namespace Helper;

class Validator
{
    public static function checkPassword(string $pass, string $pass2): bool
    {
        return strtolower(trim($pass)) === strtolower(trim($pass2));
    }

    public static function checkEmail(string $email): bool
    {
        $email = strtolower(trim($email));
        return strpos($email, '@') !== false;
    }
}