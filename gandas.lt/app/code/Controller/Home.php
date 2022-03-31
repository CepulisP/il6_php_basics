<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;

class Home extends ControllerAbstract
{
    public function index(): void
    {

        $this->render('parts\home.html');

    }
}