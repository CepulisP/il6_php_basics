<div>
    <div class="page-title">
        <h2>All ads</h2>
    </div>
    <div class="form-wrapper">
        <div class="form-label">
            Sort by:
        </div>
        <div class="form">
            <?= $this->data['form']; ?>
        </div>
    </div>
    <div class="content-wrapper">
        <table style="color:white;">
            <tr>
                <?php $count = 1; ?>
                <?php foreach ($this->data['ads'] as $ad) : ?>
                <td style="padding:0 50px 0 50px;">
                    <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>" style="color:white;text-decoration:none;">
                        <b style="font-size:24px;"><?= ucfirst($ad->getTitle()) ?></b>
                        <br>
                        <img width="100" src="<?= IMAGE_PATH . $ad->getImage() ?>">
                        <br>
                        <?= $ad->getPrice() ?> Eur
                    </a>
                    <br>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <?php if ($_SESSION['user_id'] == $ad->getUserId()) : ?>
                            <a href="<?= $this->link('catalog/edit', $ad->getId()) ?>" style="color:white;">Edit</a>
                            <br>
                        <?php endif; ?>
                    <?php endif; ?>
                    <hr>
                </td>
                <?php if ($count % 5 == 0) : ?>
            </tr>
            <tr>
                <?php endif; ?>
                <?php $count++; ?>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
</div>