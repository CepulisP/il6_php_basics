<?php

namespace Helper;

class Url
{
    public static function redirect($route)
    {
        header('Location: ' . BASE_URL . $route);
        exit;
    }
}