<?php

namespace Controller;

use Core\AbstractController;

class Home extends AbstractController
{
    public function index()
    {
        $this->render('parts/home');
    }
}