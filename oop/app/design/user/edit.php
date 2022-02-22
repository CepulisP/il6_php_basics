<div>
    <h2>Edit user</h2>
    <?php if (isset($_SESSION['edit_error'])) : ?>
        <?= $_SESSION['edit_error']; ?>
    <?php endif; ?>
    <div class="form-wrapper">
        <?= $this->data['form']; ?>
    </div>
</div>