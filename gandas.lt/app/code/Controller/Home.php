<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;

class Home extends ControllerAbstract
{
    public function index(): void
    {

        echo $this->twig->render('parts\home.html');

    }
}