<div class="home-content">
    <div class="item-row-container">
        <div class="item-row-title">
            <h3>Newest ads</h3>
        </div>
        <ul class="item-row">
            <?php foreach ($this->data['new_ads'] as $ad) : ?>
                    <li class="ad-container">
                        <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                            <img src="<?= $ad->getImage() ?>">
                            <span class="ad-container-title"><?= ucfirst($ad->getTitle()) ?></span>
                            <div class="ad-container-footer">
                                <?php if ($ad->getRating() > 0) : ?>
                                    <div class="rating">
                                        <span class="star">&#9734;</span>
                                        <div>
                                            <div>
                                                <span class="rating-value"><?= $ad->getRating() ?></span>
                                                <span class="rating-tag">/5</span>
                                            </div>
                                            <?php if ($ad->getRatingCount() > 1) : ?>
                                                <span class="rating-count"><?= $ad->getRatingCount() ?> users</span>
                                            <?php else : ?>
                                                <span class="rating-count"><?= $ad->getRatingCount() ?> user</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <span class="no-rating">No rating</span>
                                <?php endif; ?>
                                <span class="price"><?= $ad->getPrice() ?></span>
                                <span class="price-tag">€</span>
                            </div>
                        </a>
                    </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <hr class="flow-break">
    <div class="item-row-container">
        <div class="item-row-title ">
            <h3>Most popular ads</h3>
        </div>
        <ul class="item-row">
                <?php foreach ($this->data['pop_ads'] as $ad) : ?>
                    <li class="ad-container">
                        <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                            <img src="<?= $ad->getImage() ?>">
                            <span class="ad-container-title"><?= ucfirst($ad->getTitle()) ?></span>
                            <div class="ad-container-footer">
                                <?php if ($ad->getRating() > 0) : ?>
                                    <div class="rating">
                                        <span class="star">&#9734;</span>
                                        <div>
                                            <div>
                                                <span class="rating-value"><?= $ad->getRating() ?></span>
                                                <span class="rating-tag">/5</span>
                                            </div>
                                            <?php if ($ad->getRatingCount() > 1) : ?>
                                                <span class="rating-count"><?= $ad->getRatingCount() ?> users</span>
                                            <?php else : ?>
                                                <span class="rating-count"><?= $ad->getRatingCount() ?> user</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <span class="no-rating">No rating</span>
                                <?php endif; ?>
                                <span class="price"><?= $ad->getPrice() ?></span>
                                <span class="price-tag">€</span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
        </ul>
    </div>
    <hr class="flow-break">
</div>