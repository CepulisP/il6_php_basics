<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;

class Error extends AbstractController implements ControllerInterface
{
    public function index(): void {}

    public function error404(): void
    {
        $this->render('parts/errors/error404');
    }
}