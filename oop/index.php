<html>
    <head>
        <title>Another ad portal</title>
    </head>
    <body style="background-color: rgba(33,33,33,255);">
        <div class="content" style="color:white;">
            <h1 style="text-align:center;">Skalbiu.lt</h1>
            <hr>

<?php

include 'vendor/autoload.php';

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
    echo '<h2 style="text-align:center;">Home page</h2>';
}

?>
        </div>
        <div class="clickbait" style="text-align:right;">
            <b><a href="you-got-clickbaited" style="color:white;">CLICK ME!</a></b>
        </div>
    </body>
</html>