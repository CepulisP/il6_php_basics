<?php

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {
    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);
    $class = ucfirst($path[0]);
    $method = $path[1];
    $param = $path[2];
    include 'app/code/Controller/' . $class . '.php';
    $obj = new $class();
    $obj->$method($param);
} else {
    echo 'home page';
}