<html>
<head>
    <title><?= $this->data['title']; ?></title>
    <meta name="description" content="<?= $this->data['meta_description']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= BASE_URL_WITHOUT_INDEX_PHP . 'css/style.css'; ?>"
</head>
<body>
<header class="main-header">
    <div class="header-top">
        <div class="web-logo">
            <a href='<?= $this->link('') ?>'>
                <img src="<?= IMAGE_PATH . 'web_logo.png'?>">
            </a>
        </div>
        <div class="search-bar">
            <form class="search-form" action="<?= $this->link('catalog/search') ?>">
                <select class="search-field" name="field">
                    <option selected value="title">Title</option>
                    <option value="description">Description</option>
                </select>
                <input name="search" id="search" autocomplete="nope" type="text" placeholder="Search" class="search-term">
                <input type="submit" value="&#x1F50E;&#xFE0E;" class="search-btn">
            </form>
        </div>
        <nav class="nav user-nav">
            <ul>
                <?php if ($this->isUserLoggedIn()) : ?>
                    <li><a href="<?= $this->link('catalog/savedads') ?>" class="btn-saved"><img src="<?= IMAGE_PATH . 'heart.png' ?>"></a></li>
                    <?php if ($this->isUserAdmin()) : ?>
                        <li><a class="btn btn-admin" href='<?= $this->link('admin/') ?>'>Admin</a></li>
                    <?php endif; ?>
                    <li><a class="btn-inbox" href='<?= $this->link('message') ?>'>
                            <img src="<?= IMAGE_PATH . 'mail.png' ?>">
                            <?php if (99 < $this->getNewMessageCount()) : ?>
                                <div class="mark inbox-full">99+</div>
                            <?php elseif ($this->getNewMessageCount() > 0) : ?>
                                <div class="mark inbox-mid"><?= $this->getNewMessageCount() ?></div>
                            <?php else : ?>
                                <div class="mark inbox-empty">0</div>
                            <?php endif; ?>
                        </a></li>
                    <li><a class="btn btn-logout" href='<?= $this->link('user/logout/') ?>'>Logout</a></li>
                <?php else : ?>
                    <a class="btn btn-signup" href='<?= $this->link('user/register/') ?>'>Register</a>
                    <a class="btn btn-login" href='<?= $this->link('user/login/') ?>'>Sign in</a>
                <?php endif ?>
            </ul>
        </nav>
    </div>
    <nav class="nav site-nav">
        <ul>
            <li><a href='<?= $this->link('') ?>'>Home</a></li>
            <li><a href='<?= $this->link('catalog/') ?>'>Catalog</a></li>
            <?php if ($this->isUserLoggedIn()) : ?>
                <li><a href='<?= $this->link('catalog/add/') ?>'>Create listing</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
<div class="page-content">