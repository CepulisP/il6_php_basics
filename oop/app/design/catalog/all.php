<div>
    <div class="page-title">
        <h2>All ads</h2>
    </div>
    <div class="form-wrapper">
        <div class="form">
            <?= $this->data['form']; ?>
        </div>
    </div>
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
                <br>
                <?php if ($ad->getRating() == null){
                    echo 'No rating';
                }else{
                    echo 'Rating: ' . $ad->getRating();
                } ?>
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
</div>