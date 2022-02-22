<div>
    <h2>Login</h2>
    <div class="form-wrapper">
        <?= $this->data['form']; ?>
        <?php if (isset($_SESSION['login_error'])) : ?>
            <?= $_SESSION['login_error']; ?>
        <?php endif; ?>
    </div>
</div>