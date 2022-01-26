<?php

include 'vendor/autoload.php';

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {

    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);

    if (isset($path[0])) {
        $class = ucfirst($path[0]);
        $class = '\Controller\\' . $class;
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
            }else{
                echo '404 no method';
            }
        } else {
            echo '404 bad class';
        }
    }
} else {
    echo 'home page';
}