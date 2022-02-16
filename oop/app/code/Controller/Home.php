<?php

namespace Controller;

use Core\AbstractController;
use Model\Ad;

class Home extends AbstractController
{
    public function index()
    {
        $this->data['new_ads'] = Ad::getAds(null, null, 'DESC', 'created_at', 5);
        $this->data['pop_ads'] = Ad::getAds(null, null, 'DESC', 'views', 5);

        $this->render('parts/home');
    }
}