<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Logger;
use Model\Ad;
use Model\Rating;

class Home extends AbstractController implements ControllerInterface
{
    public function index(): void
    {
        $this->data['new_ads'] = Ad::getOrderedAds('created_at', 'DESC', true, 5);
        $this->data['pop_ads'] = Ad::getOrderedAds('views', 'DESC', true, 5);

        $this->render('parts/home');
    }
}