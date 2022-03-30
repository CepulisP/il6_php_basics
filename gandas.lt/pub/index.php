<?php

include '..\vendor\autoload.php';
include '..\config.php';

if (DEBUG_MODE) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}

session_start();

$router = new \Core\Router();
$launcher = new \Core\Launcher();

$launcher->start($router->getRouteInfo());