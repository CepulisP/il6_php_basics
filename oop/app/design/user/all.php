<div>
    <h2>All users</h2>
    <ol class="user-wrapper">
        <?php foreach ($this->data['users'] as $user) : ?>
            <li>
                <a href="<?php echo BASE_URL . 'user/show/' . $user->getId() ?>" style="color:white;">
                    <?php echo $user->getName() . ' ' . $user->getLastName() ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</div>