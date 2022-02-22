<?php
/**
 * @var \Model\User $user ;
 */
?>
<form action="'<?= BASE_URL ?>'admin/changeuserstatus" method="POST">
    <table>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Created at</th>
            <th>Active</th>
            <th>Login attempts</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($this->data['users'] as $user) : ?>
            <tr>
                <td><input name="<?= $user->getId() ?>" type="checkbox"></td>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getName() ?></td>
                <td><?= $user->getLastName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getPhone() ?></td>
                <td><?= $user->getCity() ?></td>
                <td><?= $user->getCreatedAt() ?></td>
                <td><?= $user->isActive() ?></td>
                <td><?= $user->getLoginAttempts() ?></td>
                <td><?= $user->getRoleId() ?></td>
                <td>
                    <a href="<?= $this->link('admin/useredit', $user->getId()) ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" name="action" value="Activate">
    <input type="submit" name="action" value="Deactivate">
</form>