<div class="content-wrapper">
    <div class="title">
        <h2><?= $this->data['ad']->getTitle() ?></h2>
    </div>
    <div class="image">
        <img width="100" src="<?= IMAGE_PATH . $this->data['ad']->getImage() ?>">
    </div>
    <div class="description">
        <p><?= $this->data['ad']->getDescription() ?></p>
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