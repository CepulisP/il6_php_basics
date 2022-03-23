<form action="<?= $this->link('database/importads') ?>" method="POST">
    <input type="text" name="file_name" placeholder="filename.csv">
    <input type="submit" value="Import ads" class="btn">
</form>
<a href="<?= $this->link('database/exportads') ?>" class="btn">Export ads</a>