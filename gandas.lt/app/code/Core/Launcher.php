<?php

declare(strict_types=1);

namespace Core;

use Controller\Error;

class Launcher
{
    public function start(array $routeInfo): void
    {

        list($controller, $method, $param) = $routeInfo;

        $controller = '\Controller\\' . ucfirst($controller);
        $controllerObject = new $controller();

        if (method_exists($controller, $method)) {

            $controllerObject->$method($param);

        } else {

            $error = new Error();
            $error->error404();

        }
    }
}