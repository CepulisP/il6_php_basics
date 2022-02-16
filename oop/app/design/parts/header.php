<html>
<head>
    <title>Auto-Market | Auto ad portal</title>
    <link rel="stylesheet" href="<?= BASE_URL_WITHOUT_INDEX_PHP . 'css/style.css'; ?>"
</head>
<body>
<header>
    <div class="header">
        <div class="icon">
            <img src="<?= IMAGE_PATH . 'car_logo.png'?>">
        </div>
        <div class="title">
            <h1>Auto-Market</h1>
        </div>
        <div class="navigation">
            <nav>
                <ul>
                    <li><a href='<?= $this->link('') ?>'>Home</a></li>
                    <li><a href='<?= $this->link('catalog/all/') ?>'>All ads</a></li>
                    <li><a href='<?= $this->link('catalog/search/') ?>'>Search</a></li>
                    <?php if ($this->isUserLoggedIn()) : ?>
                        <li><a href='<?= $this->link('catalog/add/') ?>'>New ad</a></li>
                        <li><a href='<?= $this->link('user/edit/') ?>'>Edit user</a></li>
                        <li><a href='<?= $this->link('user/logout/') ?>'>Logout</a></li>
                    <?php else : ?>
                        <li><a href='<?= $this->link('user/register/') ?>'>Sign up</a></li>
                        <li><a href='<?= $this->link('user/login/') ?>'>Login</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
<div class="content">