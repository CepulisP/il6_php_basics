<?php

include 'vendor/autoload.php';
include 'config.php';

$messenger = new \Service\PriceChangeInformer\Cron;
$messenger->exec();