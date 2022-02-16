<div>
    <h2>Home page</h2>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <h3>Hello, <?= ucfirst($_SESSION['user']->getName()) ?>!</h3>
        <br>
    <?php endif ?>
</div>