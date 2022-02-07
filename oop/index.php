<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor\autoload.php';
include 'config.php';

session_start();

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {

    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);

    $class = '\Controller\\' . ucfirst($path[0]);
    if (class_exists($class)) {
        $obj = new $class();
        if (isset($path[1])) {
            $method = $path[1];
            if (method_exists($obj, $method)) {
                if (isset($path[2])) {
                    $id = $path[2];
                    $obj->$method($id);
                } else {
                    $obj->$method();
                }
            } else {
                echo '404 bad method';
            }
        } else {
            echo '404 no method';
        }
    } else {
        echo '404 bad class';
    }
} else {
    include PROJECT_ROOT_DIR . '\app\design\parts\header.php';
    echo '<h2 style="text-align:center;">Home page</h2>';
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    include PROJECT_ROOT_DIR . '\app\design\parts\footer.php';
}