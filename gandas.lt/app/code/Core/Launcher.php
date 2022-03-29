<?php

declare(strict_types=1);

namespace Core;

class Launcher
{
    public function start(array $routeInfo): void
    {
        list($controller, $method, $param) = $routeInfo;
    }
}