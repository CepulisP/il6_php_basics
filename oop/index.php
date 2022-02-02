<html>
<head>
    <title>Gumtree | Ad portal</title>
</head>
<body style="background-color: rgba(33,33,33,255);">
<div class="navigation" style="text-align:center;">
    <h1 style="color:white;">Gumtree</h1>
    <a href='http://localhost/pamokos/oop/index.php/' style="color:white;text-decoration:none">&bullet; Home</a>
    <a href='http://localhost/pamokos/oop/index.php/catalog/all/' style="color:white;text-decoration:none">&bullet; All
        ads</a>
    <a href='http://localhost/pamokos/oop/index.php/user/register/' style="color:white;text-decoration:none">&bullet;
        Sign up</a>
    <a href='http://localhost/pamokos/oop/index.php/user/login/' style="color:white;text-decoration:none">&bullet;
        Login</a>
    <hr>
</div>
<div class="content" style="color:white;">

    <?php

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
        echo '<h2 style="text-align:center;">Home page</h2>';
        print_r($_SESSION);
    }

    ?>
</div>
</body>
</html>