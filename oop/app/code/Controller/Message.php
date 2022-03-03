<?php

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

    public function index()
    {
        $conversers = MessageModel::getSenders($_SESSION['user_id']);

        $senders = [];
        foreach ($conversers as $converser){
            $senders[] = [
                'id' => $converser->getId(),
                'nickname' => $converser->getNickname(),
                'new_msg_count' => MessageModel::countNewMessages($_SESSION['user_id'], $converser->getId())
            ];
        }

        usort($senders, function($b, $a) {
            return $a['new_msg_count'] <=> $b['new_msg_count'];
        });

        $this->data['senders'] = $senders;
        $this->render('message/inbox');
    }

    public function chat($senderId)
    {
        $chat = MessageModel::getChat($_SESSION['user_id'], $senderId);

        foreach ($chat as $item){
            $msg = new MessageModel($item->getId());
            $msg->setSeen(1);
            $msg->save();
        }

        $this->data['sender'] = new User($senderId);
        $this->data['chat'] = $chat;
        $this->render('message/chat');
    }

    public function send($recipientId = null)
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

    public function sendMessage($recipientId = null)
    {
        if (!isset($recipientId)) $recipientId = User::getIdByNickname($_POST['recipient']);

        if (empty($recipientId)) {
            $_SESSION['send_error'] = 'Recipient not found';
            Url::redirect('message/send');
        }
        unset($_SESSION['send_error']);

        $message = new MessageModel();
        $message->setMessage($_POST['message']);
        $message->setSenderId($_SESSION['user_id']);
        $message->setRecipientId($recipientId);
        $message->setSeen(0);
        $message->save();

        Url::redirect('message/chat/' . $recipientId);
    }
}