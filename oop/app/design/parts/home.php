<div class="home-content">
    <div class="new-ads">
        <div class="new-ads-title">
            <h3>Newest ads</h3>
        </div>
        <div class="new-ads-content item-row">
            <?php foreach ($this->data['new_ads'] as $ad) : ?>
                    <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                        <div class="ad-container">
                            <?= ucfirst($ad->getTitle()) ?>
                            <img src="<?= $ad->getImage() ?>">
                            <?= $ad->getPrice() ?> Eur
                        </div>
                    </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="pop-ads">
        <div class="pop-ads-title">
            <h3>Most popular ads</h3>
        </div>
        <div class="pop-ads-content item-row">
                <?php foreach ($this->data['pop_ads'] as $ad) : ?>
                    <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                        <div class="ad-container">
                            <?= ucfirst($ad->getTitle()) ?>
                            <img src="<?= $ad->getImage() ?>">
                            <?= $ad->getPrice() ?> Eur
                        </div>
                    </a>
                <?php endforeach; ?>
        </div>
    </div>
</div>