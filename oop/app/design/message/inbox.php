<div>
    <div class="chat-title">
        <h3>Your conversations</h3>
    </div>
    <div class="conversations">
        <?php if (!empty($this->data['senders'])) : ?>
            <div class="conversation-wrapper">

                <?php foreach ($this->data['senders'] as $sender) : ?>



                            <div class="sender">
                                <a href="<?= $this->link('message/chat', $sender['id']) ?>">
                                <?= $sender['nickname'] . '(' . $sender['new_msg_count'] . ')' ?>
                                </a>
                            </div>


                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div>
                No conversations yet
            </div>
        <?php endif; ?>
    </div>
</div>