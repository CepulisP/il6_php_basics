<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;

class Error extends ControllerAbstract
{
    public function error404(): void
    {

        $this->render('parts\errors\error404.html');

    }
}