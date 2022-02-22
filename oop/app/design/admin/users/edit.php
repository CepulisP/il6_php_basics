<h2>Edit user</h2>
<?php if (isset($_SESSION['admin_edit_error'])) : ?>
    <?= $_SESSION['admin_edit_error']; ?>
<?php endif; ?>
<?= $this->data['form'] ?>