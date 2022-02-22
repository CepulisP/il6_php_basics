<div class="content-wrapper">
    <div class="title">
        <h2><?= ucfirst($this->data['ad']->getTitle()); ?></h2>
    </div>
    <div class="image">
        <img src="<?= IMAGE_PATH . $this->data['ad']->getImage() ?>">
    </div>
    <div class="description">
        <p>
            <?= ucfirst($this->data['ad']->getDescription()) ?>
        </p>
    </div>
    <div class="details">
        Manufacturer: <?= ucfirst($this->data['ad']->getManufacturer()) ?>
        <br>
        Model: <?= ucfirst($this->data['ad']->getModel()) ?>
        <br>
        Year of manufacture: <?= ucfirst($this->data['ad']->getYear()) ?>
        <br>
        Type: <?= ucfirst($this->data['ad']->getType()) ?>
        <br>
        VIN: <?= ucfirst($this->data['ad']->getVin()) ?>
        <br>
        Created by:
        <?= ucfirst($this->data['ad']->getUser()->getName()) ?>
        <?= ucfirst($this->data['ad']->getUser()->getLastName()) ?>
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