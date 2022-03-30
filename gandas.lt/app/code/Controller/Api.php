<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;

class Api extends ControllerAbstract
{
    public function index(): void
    {
        echo 'api/index';
    }
}