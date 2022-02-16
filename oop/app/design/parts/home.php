<div>
    <div class="home-title">
        <h2>Home page</h2>
    </div>
    <div class="greeting">
        <?php if (isset($_SESSION['user_id'])) : ?>
            <h3>Hello, <?= ucfirst($_SESSION['user']->getName()) ?>!</h3>
            <br>
        <?php endif ?>
    </div>
    <div class="home-content">
        <div class="new-ads">
            <div class="new-ads-title">
                <h3>Newest ads</h3>
            </div>
            <div class="new-ads-content">
                <table>
                    <tr>
                        <?php foreach ($this->data['new_ads'] as $ad) : ?>
                            <td>
                                <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                                    <b>
                                        <?= ucfirst($ad->getTitle()) ?>
                                    </b>
                                    <br>
                                    <img src="<?= IMAGE_PATH . $ad->getImage() ?>">
                                    <br>
                                    <?= $ad->getPrice() ?> Eur
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="most-popular-ads">
            <div class="most-popular-ads-title">
                <h3>Most popular ads</h3>
            </div>
            <div class="most-popular-ads-content">
                <table>
                    <tr>
                        <?php foreach ($this->data['pop_ads'] as $ad) : ?>
                            <td>
                                <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                                    <b>
                                        <?= ucfirst($ad->getTitle()) ?>
                                    </b>
                                    <br>
                                    <img src="<?= IMAGE_PATH . $ad->getImage() ?>">
                                    <br>
                                    <?= $ad->getPrice() ?> Eur
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>