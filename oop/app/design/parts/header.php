<html>
<head>
    <title><?= $this->data['title']; ?></title>
    <meta name="description" content="<?= $this->data['meta_description']; ?>">
    <link rel="stylesheet" href="<?= BASE_URL_WITHOUT_INDEX_PHP . 'css/style.css'; ?>"
</head>
<body>
<header>
    <div class="main-header">
        <div class="nav user-nav">
            <?php if ($this->isUserLoggedIn()) : ?>
                <li><a href='<?= $this->link('message') ?>'>Inbox(<?= $this->getNewMessageCount() ?>)</a></li>
                <?php if ($this->isUserAdmin()) : ?>
                    <li><a href='<?= $this->link('admin/') ?>'>Admin</a></li>
                <?php endif; ?>
                <li><a href='<?= $this->link('user/logout/') ?>'>Logout</a></li>
            <?php else : ?>
                <li><a href='<?= $this->link('user/register/') ?>'>Sign up</a></li>
                <li><a href='<?= $this->link('user/login/') ?>'>Login</a></li>
            <?php endif ?>
        </div>
        <div class="header-mid">
            <img src="<?= IMAGE_PATH . 'car_logo.png'?>">
            <h1 class="web-name big-web-name">Auto-Market</h1>
            <form action="<?= $this->link('catalog/search') ?>">
                <input name="search" id="search" type="text" placeholder="Search">
                <select name="field">
                    <option selected value="title">Title</option>
                    <option value="description">Description</option>
                </select>
                <input name="submit" type="submit" value="Search">
            </form>
        </div>
        <div class="nav site-nav">
            <nav>
                <ul>
                    <li><a href='<?= $this->link('') ?>'>Home</a></li>
                    <li><a href='<?= $this->link('catalog/') ?>'>All ads</a></li>
                    <?php if ($this->isUserLoggedIn()) : ?>
                        <li><a href='<?= $this->link('catalog/add/') ?>'>New ad</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
<div class="content">