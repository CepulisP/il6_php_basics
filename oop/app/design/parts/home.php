<div>
    <h2 style="text-align:center;">Home page</h2>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <h3>Hello, <?php echo ucfirst($_SESSION['user']->getName()) ?>!</h3>
        <br>
<!--            <pre>-->
<!--                --><?php //print_r($_SESSION); ?>
<!--            </pre>-->
    <?php endif ?>
</div>