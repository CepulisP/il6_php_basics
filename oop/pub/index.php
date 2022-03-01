<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '..\vendor\autoload.php';
include '..\config.php';

session_start();

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {

    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);

    $class = '\Controller\\' . ucfirst($path[0]);
    if (class_exists($class)) {
        $obj = new $class();

        if (isset($path[1])) {
            $method = $path[1];
        } else {
            $method = 'index';
        }

        if (method_exists($obj, $method)) {
            if (isset($path[2])) {
                $id = $path[2];
                $obj->$method($id);
            } else {
                $obj->$method();
            }
        } else {
            $error = new \Controller\Error();
            $error->error404();
        }
    } else {
        $error = new \Controller\Error();
        $error->error404();
    }
} else {
    $obj = new \Controller\Home();
    $obj->index();
}