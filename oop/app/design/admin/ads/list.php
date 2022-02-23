<?php
/**
 * @var \Model\Ad $ad;
 */
?>
<form action="<?= $this->link('admin/massadupdate') ?>" method="POST">
    <table>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>Price</th>
            <th>Year</th>
            <th>Type</th>
            <th>Author</th>
            <th>Image</th>
            <th>Link</th>
            <th>Created at</th>
            <th>VIN</th>
            <th>Views</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
            <?php foreach ($this->data['ads'] as $ad) : ?>
                <tr>
                    <td><input name="selected[]" value="<?= $ad->getId() ?>" type="checkbox"></td>
                    <td><?= $ad->getId() ?></td>
                    <td><?= $ad->getTitle() ?></td>
                    <td><?= $ad->getDescription() ?></td>
                    <td><?= $ad->getManufacturer() ?></td>
                    <td><?= $ad->getModel() ?></td>
                    <td><?= $ad->getPrice() ?></td>
                    <td><?= $ad->getYear() ?></td>
                    <td><?= $ad->getType() ?></td>
                    <td>
                        <a href="<?= $this->link('admin/useredit', $ad->getUserId()) ?>">
                            <?= $ad->getUser()->getName().' '.$ad->getUser()->getLastName() ?>
                        </a>
                    </td>
                    <td><img src="<?= IMAGE_PATH . $ad->getImage() ?>"></td>
                    <td><?= $ad->getSlug() ?></td>
                    <td><?= $ad->getCreatedAt() ?></td>
                    <td><?= $ad->getVin() ?></td>
                    <td><?= $ad->getViews() ?></td>
                    <td><?= $ad->isActive() ?></td>
                    <td>
                        <a href="<?= $this->link('admin/adedit', $ad->getId()) ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>
    <select name="action" id="action">
        <option value="">Select action</option>
        <option value="0">Deactivate</option>
        <option value="1">Activate</option>
        <option value="2">Delete</option>
    </select>
    <label for="action"> selected ads</label>
    <input name="submit" type="submit" value="Enter">
</form>