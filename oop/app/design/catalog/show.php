<div class="content-wrapper">
    <div class="title">
        <h2><?= ucfirst($this->data['ad']->getTitle()); ?></h2>
    </div>
    <div class="image">
        <img src="<?= $this->data['ad']->getImage() ?>">
    </div>
    <div class="description">
        <p>
            <?= ucfirst($this->data['ad']->getDescription()) ?>
        </p>
    </div>
    <div class="details">
        Price: <?= ucfirst($this->data['ad']->getPrice()) ?> Eur
        <br>
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
        <?= ucfirst($this->data['author']->getName()) ?>
        <?= ucfirst($this->data['author']->getLastName()) ?>
        <br>
    </div>
</div>
<div class="related">
    <div class="title">
        <h3>Related ads</h3>
    </div>
    <div class="related-list">
        <?php if (!empty($this->data['related'])) : ?>
            <?php foreach ($this->data['related'] as $ad) : ?>
                <div class="element">
                    <a href="<?= $this->link('catalog/show', $ad->getSlug()) ?>">
                        <b>
                            <?= ucfirst($ad->getTitle()) ?>
                        </b>
                        <br>
                        <img src="<?= $ad->getImage() ?>">
                        <br>
                        <?= $ad->getPrice() ?> Eur
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            No related ads found
        <?php endif; ?>
    </div>
</div>
<div class="comments-wrapper">
    <?= $this->data['comment_box'] ?>
    <?php if (isset($_SESSION['comment_error'])) : ?>
        <?= $_SESSION['comment_error']; ?>
    <?php endif; ?>
    <div class="comments">
        <h3>Comments</h3>
        <?php foreach ($this->data['comments'] as $comment) : ?>
            <div class="comment">
                <div class="comment_user">
                    <?php $author = $comment->getUser() ?>
                    <?= $author->getName() ?>
                    <?= $author->getLastName() ?>
                </div>
                <div class="comment_date">
                    <?= $comment->getCreatedAt() ?>
                </div>
                <div class="comment_content">
                    <p><?= $comment->getComment() ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
