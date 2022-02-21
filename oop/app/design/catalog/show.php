<div class="content-wrapper">
    <div class="title">
        <h2><?= ucfirst($this->data['ad']->getTitle()); ?></h2>
    </div>
    <div class="image">
        <img src="<?= IMAGE_PATH . $this->data['ad']->getImage() ?>">
    </div>
    <div class="description">
        <p>
            <?= $this->data['ad']->getDescription() ?>
        </p>
    </div>
    <div class="details">
        Manufacturer: <?= $this->data['manufacturer'] ?>
        <br>
        Model: <?= $this->data['model'] ?>
        <br>
        Year of manufacture: <?= $this->data['ad']->getYear() ?>
        <br>
        Type: <?= $this->data['type'] ?>
        <br>
        VIN: <?= $this->data['ad']->getVin() ?>
        <br>
        Created by: <?= $this->data['user_name'] ?> <?= $this->data['user_last_name'] ?>
        <br>
    </div>
</div>
<?php if (!empty($this->data['related'])) : ?>
    <div class="related">
        <div class="title">
            <h3>Related ads</h3>
        </div>
        <div class="related-list">
            <?php foreach ($this->data['related'] as $ad) : ?>
                <div class="element">
                    <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                        <b>
                            <?= ucfirst($ad->getTitle()) ?>
                        </b>
                        <br>
                        <img src="<?= IMAGE_PATH . $ad->getImage() ?>">
                        <br>
                        <?= $ad->getPrice() ?> Eur
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>