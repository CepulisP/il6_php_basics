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
            <li><a href='<?php echo $this->link('') ?>'>Home</a></li>
            <li><a href='<?php echo $this->link('catalog/all/') ?>'>All ads</a></li>
            <li><a href='<?php echo $this->link('catalog/search/') ?>'>Search</a></li>
            <?php if ($this->isUserLoggedIn()) : ?>
                <li><a href='<?php echo $this->link('catalog/add/') ?>'>New ad</a></li>
                <li><a href='<?php echo $this->link('user/edit/') ?>'>Edit user</a></li>
                <li><a href='<?php echo $this->link('user/logout/') ?>'>Logout</a></li>
            <?php else : ?>
                <li><a href='<?php echo $this->link('user/register/') ?>'>Sign up</a></li>
                <li><a href='<?php echo $this->link('user/login/') ?>'>Login</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
<div class="content" style="color:white;">