<html>
<head>
    <title>Gumtree | Ad portal</title>
    <link rel="stylesheet" href="<?php echo BASE_URL_WITHOUT_INDEX_PHP . 'css/style.css'; ?>"
</head>
<body>
<header style="text-align:center;">
    <h1 style="color:white;">Gumtree</h1>
    <nav>
        <ul>
            <li><a href='<?php echo BASE_URL ?>'>Home</a></li>
            <li><a href='<?php echo BASE_URL ?>catalog/all/'>All ads</a></li>

            <?php if($this->isUserLoggedIn()) : ?>

            <li><a href='<?php echo BASE_URL ?>catalog/add/'>New ad</a></li>
            <li><a href='<?php echo BASE_URL ?>user/edit/'>Edit user</a></li>
            <li><a href='<?php echo BASE_URL ?>user/logout/'>Logout</a></li>

            <?php else : ?>

            <li><a href='<?php echo BASE_URL ?>user/register/'>Sign up</a></li>
            <li><a href='<?php echo BASE_URL ?>user/login/'>Login</a></li>

            <?php endif ?>
        </ul>
    </nav>
</header>
<div class="content" style="color:white;">