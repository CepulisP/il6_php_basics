<form action="<?= $this->link('database/import') ?>" method="POST">
    <input type="text" name="file_name">
    <input type="submit" value="import" class="btn">
</form>
<a href="<?= $this->link('database/export') ?>" class="btn">Export ads</a>