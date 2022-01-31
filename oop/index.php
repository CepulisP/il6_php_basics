<html>
    <head>
        <title>Gumtree | Another ad portal</title>
    </head>
    <body style="background-color: rgba(33,33,33,255);">
        <div class="content" style="color:white;">
            <h1 style="text-align:center;">Gumtree</h1>
            <div class="navigation" style="text-align:center;">
                    <a href='http://localhost/pamokos/oop/index.php/' style="color:white;text-decoration:none">&bullet; Home</a>
                    <a href='http://localhost/pamokos/oop/index.php/user/show/' style="color:white;text-decoration:none">&bullet; All ads</a>
                    <a href='http://localhost/pamokos/oop/index.php/user/register/' style="color:white;text-decoration:none">&bullet; Sign up</a>
                    <a href='http://localhost/pamokos/oop/index.php/user/login/' style="color:white;text-decoration:none">&bullet; Login</a>
            </div>
            <hr>

<?php

include 'vendor\autoload.php';
include 'config.php';

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

        if ($path[0] === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }

        echo '404 bad class';
    }
} else {
    echo '<h2 style="text-align:center;">Home page</h2>';
}

?>
            <div class="clickbait" style="text-align:right;">
                <b><a href="you-got-clickbaited" style="color:white;">CLICK ME!</a></b>
            </div>
        </div>
    </body>
</html>