<div>
    <?php if (isset($_SESSION['send_error'])) : ?>
        <?= $_SESSION['send_error']; ?>
    <?php endif; ?>
    <?= $this->data['form'] ?>
</div>