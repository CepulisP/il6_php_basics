<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;
use Helper\UrlHelper;
use Service\GetNewsFromApi\WebitNews;

class Api extends ControllerAbstract
{
    public function index(): void
    {

        echo 'api/index';

    }

    public function exec(): void
    {

        $news = new WebitNews();
        $news->exec();

        UrlHelper::redirect('');

    }
}