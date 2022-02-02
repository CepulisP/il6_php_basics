<?php

namespace Helper;

class Validator
{
    public static function checkPassword($pass, $pass2)
    {
        return strtolower(trim($pass)) === strtolower(trim($pass2));
    }

    public static function checkEmail($email)
    {
        $email = strtolower(trim($email));
        return strpos($email, '@') !== false;
    }
}