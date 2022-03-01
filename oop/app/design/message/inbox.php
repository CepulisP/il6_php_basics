<div class="new-messages">
    <div class="message-title">
        <h3>New messages</h3>
    </div>
    <?php foreach ($this->data['new_messages'] as $message) : ?>
        <div class="message">
            <div class="message_user">
                <?php $author = $message->getUser() ?>
                <?= $author->getName() ?>
                <?= $author->getLastName() ?>
            </div>
            <div class="message_date">
                <?= $message->getCreatedAt() ?>
            </div>
            <div class="message_content">
                <p><?= $message->getMessage() ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="old-messages">
    <div class="message-title">
        <h3>Old messages</h3>
    </div>
    <?php foreach ($this->data['old_messages'] as $message) : ?>
        <div class="message">
            <div class="message_user">
                <?php $author = $message->getUser() ?>
                <?= $author->getName() ?>
                <?= $author->getLastName() ?>
            </div>
            <div class="message_date">
                <?= $message->getCreatedAt() ?>
            </div>
            <div class="message_content">
                <p><?= $message->getMessage() ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>