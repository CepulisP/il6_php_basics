<div>
    <div class="page-title">
        <h2>Search</h2>
    </div>
    <div class="form">
        <?= $this->data['form']; ?>
    </div>
    <?php if (!empty($this->data['ads'])) : ?>
        <div class="content-wrapper">
            <?php foreach ($this->data['ads'] as $ad) : ?>
                <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                    <b>
                        <?= ucfirst($ad->getTitle()) ?>
                    </b>
                    <br>
                    <img src="<?= $ad->getImage() ?>">
                    <br>
                    <?= $ad->getPrice() ?> Eur
                </a>
                <br>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <?php if ($_SESSION['user_id'] == $ad->getUserId()) : ?>
                        <a href="<?= $this->link('catalog/edit', $ad->getId()) ?>">Edit</a>
                        <br>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>