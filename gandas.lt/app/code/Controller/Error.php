<?php

declare(strict_types=1);

namespace Controller;

class Error
{
    public function error404(): void
    {
        echo '404 page not found';
    }
}