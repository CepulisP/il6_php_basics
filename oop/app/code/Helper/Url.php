<?php

namespace Helper;

use Model\Ad;

class Url
{
    public static function generateSlug($title)
    {
        $slug = trim(strtolower(str_replace([' ', ',', '.'], '-', $title)));
        return str_replace(['--', '---', '----'], '-', $slug);
    }

    public static function redirect($route)
    {
        header('Location: ' . BASE_URL . $route);
        exit;
    }

    public static function link($path, $param = null)
    {
        $link = BASE_URL . $path;
        if ($param !== null) {
            $link .= '/' . $param;
        }
        return $link;
    }
}