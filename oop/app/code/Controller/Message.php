<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Logger;
use Helper\Url;
use Helper\FormHelper;
use Model\Message as MessageModel;
use Model\User;

class Message extends AbstractController implements ControllerInterface
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');
    }

    public function index(): void
    {
        $conversers = MessageModel::getSenders((int)$_SESSION['user_id']);

        $senders = [];
        foreach ($conversers as $converser){
            $senders[] = [
                'id' => $converser->getId(),
                'nickname' => $converser->getNickname(),
                'new_msg_count' => MessageModel::countNewMessages((int)$_SESSION['user_id'], (int)$converser->getId())
            ];
        }

        usort($senders, function($b, $a) {
            return $a['new_msg_count'] <=> $b['new_msg_count'];
        });

        $this->data['senders'] = $senders;
        $this->render('message/inbox');
    }

    public function chat(int $senderId): void
    {
        $chat = MessageModel::getChat((int)$_SESSION['user_id'], $senderId);

        foreach ($chat as $item){
            $msg = new MessageModel((int)$item->getId());
            if ($msg->getSenderId() !== $_SESSION['user_id']) {
                $msg->setSeen(1);
                $msg->save();
            }
        }

        $this->data['sender'] = new User($senderId);
        $this->data['chat'] = $chat;
        $this->render('message/chat');
    }

    public function send(?int $recipientId = null): void
    {
        $form = new FormHelper('message/sendmessage', 'POST');

        $recipientInput = [
            'name' => 'recipient',
            'id' => 'recipient',
            'type' => 'text',
            'placeholder' => 'Recipient'
        ];

        if (isset($recipientId)) $recipientInput['value'] = User::getNicknameById($recipientId);

        $form->label('recipient', 'Send to:');
        $form->input($recipientInput);
        $form->label('message', 'Message:');
        $form->textArea('message', null, 'Your message', 'message', 255);
        $form->input([
            'name' => 'submit',
            'value' => 'Send',
            'type' => 'submit'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('message/send');
    }

    public function sendMessage(?int $recipientId = null): void
    {
        if (!isset($recipientId)) $recipientId = User::getIdByNickname($_POST['recipient']);

        if (empty($recipientId)) {
            $_SESSION['send_error'] = 'Recipient not found';
            Url::redirect('message/send');
        }
        unset($_SESSION['send_error']);

        $message = new MessageModel();
        $message->setMessage($_POST['message']);
        $message->setSenderId((int)$_SESSION['user_id']);
        $message->setRecipientId((int)$recipientId);
        $message->setSeen(0);
        $message->save();

        Url::redirect('message/chat/' . $recipientId);
    }

    public static function systemMessage(string $message, array $recipientIds): void
    {
        foreach ($recipientIds as $recipientId) {
            $msg = new MessageModel();
            $msg->setMessage($message);
            $msg->setSenderId(42);
            $msg->setRecipientId((int)$recipientId);
            $msg->setSeen(0);
            $msg->save();
        }
    }
}