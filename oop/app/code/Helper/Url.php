<?php

declare(strict_types=1);

namespace Helper;

use Model\Ad;

class Url
{
    public static function generateSlug(string $title): string
    {
        $slug = trim(strtolower(str_replace([' ', ',', '.'], '-', $title)));
        return trim(str_replace(['--', '---', '----'], '-', $slug), '-');
    }

    public static function redirect(string $route): void
    {
        header('Location: ' . BASE_URL . $route);
        exit;
    }

    public static function link(string $path, ?string $param = null): string
    {
        $link = BASE_URL . $path;
        if ($param !== null) {
            $link .= '/' . $param;
        }
        return $link;
    }
}