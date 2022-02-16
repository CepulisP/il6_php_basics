<div>
    <h2>Login</h2>
    <div class="form-wrapper">
        <?= $this->data['form']; ?>
        <?php if (isset($_SESSION['message'])) : ?>
            <?= $_SESSION['message']; ?>
        <?php endif; ?>
    </div>
</div>