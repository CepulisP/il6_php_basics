<?php

namespace Controller;

use Core\AbstractController;
use Model\Ad;

class Home extends AbstractController
{
    public function index()
    {
        $this->data['new_ads'] = Ad::getOrderedAds('created_at', 'DESC', true, 5);
        $this->data['pop_ads'] = Ad::getOrderedAds('views', 'DESC', true, 5);

        $this->render('parts/home');
    }
}