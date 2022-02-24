<html>
<head>
    <title><?= $this->data['title']; ?></title>
    <meta name="description" content="<?= $this->data['meta_description']; ?>">
    <link rel="stylesheet" href="<?= BASE_URL_WITHOUT_INDEX_PHP . 'css/admin.css'; ?>"
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
                    <li><a href='<?= $this->link('admin/users') ?>'>Users</a></li>
                    <li><a href='<?= $this->link('admin/ads') ?>'>Ads</a></li>
                    <li><a href='<?= $this->link('user/logout/') ?>'>Logout</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<div class="content">