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
    protected const ITEMS_PER_PAGE = 10;

    public function index(): void
    {
        $this->data['new_ads'] = Ad::getOrderedAds('created_at', 'DESC', true, self::ITEMS_PER_PAGE);
        $this->data['pop_ads'] = Ad::getOrderedAds('views', 'DESC', true, self::ITEMS_PER_PAGE);

        $this->render('parts/home');
    }
}