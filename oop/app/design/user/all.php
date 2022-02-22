<div>
    <h2>All users</h2>
    <ol class="user-wrapper">
        <?php foreach ($this->data['users'] as $user) : ?>
            <li>
                <a href="<?= $this->link('user/show', $user->getId()) ?>">
                    <?= $user->getName() . ' ' . $user->getLastName() ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</div>