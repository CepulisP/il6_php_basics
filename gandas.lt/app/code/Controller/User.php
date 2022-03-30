<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;

class User extends ControllerAbstract
{
    public function index(): void
    {
        echo 'user/index';
    }
}