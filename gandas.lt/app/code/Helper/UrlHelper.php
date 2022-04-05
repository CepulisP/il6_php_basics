<?php

declare(strict_types=1);

namespace Helper;

class UrlHelper
{
    public static function redirect(string $route): void
    {

        header('Location: ' . BASE_URL . $route);
        exit;

    }

}