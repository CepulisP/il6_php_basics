<div class="chat">
    <div class="chat-title">
        <h3>Chat with <?= $this->data['sender']->getNickname() ?></h3>
    </div>
    <div class="chat-box">
        <?php foreach ($this->data['chat'] as $msg) : ?>
            <?php if ($msg->getSenderId() == $this->data['sender']->getId()) : ?>
                <div class="sender-message">
            <?php else : ?>
                <div class="user-message">
            <?php endif; ?>
                    <div class="message_date">
                        <?= $msg->getCreatedAt() ?>
                    </div>
                    <div class="message_content">
                        <p><?= $msg->getMessage() ?></p>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
    <form action="<?= $this->link('message/sendmessage', $this->data['sender']->getId()) ?>" method="POST">
        <div class="chat-input">
            <div class="chat-input-text">
                <textarea name="message" placeholder="Your message" maxlength="255"></textarea>
            </div>
            <div class="chat-input-submit">
                <input type="submit" name="submit" value="send">
            </div>
        </div>
    </form>
</div>