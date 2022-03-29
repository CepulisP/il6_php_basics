<?php

declare(strict_types=1);

namespace Core;

class Router
{
    public function getRouteInfo(): array
    {

        $allowedControllers = ['user', 'api', 'news'];

        if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {

            $path = explode('/', strtolower(trim($_SERVER['PATH_INFO'], '/')));

            $pathOne = $path[0] ?? null;

            if (in_array($pathOne, $allowedControllers)) {

                $controller = $pathOne;
                $method = $path[1] ?? 'index';
                $param = $path[2] ?? null;

            } else {

                $controller = 'news';
                $method = 'show';
                $param = $pathOne;

            }

        } else {

            $controller = 'home';
            $method = $path[1] ?? 'index';
            $param = $path[2] ?? null;

        }

        return [$controller, $method, $param];
    }

}