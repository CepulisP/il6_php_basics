<div>
    <h2>Register</h2>
    <?php if (isset($_SESSION['register_error'])) : ?>
        <?= $_SESSION['register_error']; ?>
    <?php endif; ?>
    <div class="form-wrapper">
        <?= $this->data['form']; ?>
    </div>
</div>