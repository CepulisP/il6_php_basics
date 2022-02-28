<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;

class Error extends AbstractController implements ControllerInterface
{
    public function index()
    {
        echo 'under construction';
    }

    public function error404()
    {
        $this->render('parts/errors/error404');
    }
}