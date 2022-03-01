<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Url;
use Helper\FormHelper;
use Model\Message as MessageModel;

class Message extends AbstractController implements ControllerInterface
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');

        $this->data['new_messages'] = MessageModel::getNewMessages($_SESSION['user_id']);
        $this->data['old_messages'] = MessageModel::getOldMessages($_SESSION['user_id']);

        foreach ($this->data['new_messages'] as $message){
            $seen = new MessageModel($message->getId());
            $seen->setSeen(1);
            $seen->save();
        }

        $this->render('message/inbox');
    }

    public function send($recipientId)
    {
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');

        $form = new FormHelper('message/sendmessage', 'POST');

        $form->input([
            'name' => 'sender_id',
            'value' => $_SESSION['user_id'],
            'type' => 'hidden'
        ]);
        $form->input([
            'name' => 'recipient_id',
            'value' => $recipientId,
            'type' => 'hidden'
        ]);
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

    public function sendMessage()
    {
        $message = new MessageModel();
        $message->setMessage($_POST['message']);
        $message->setSenderId($_POST['sender_id']);
        $message->setRecipientId($_POST['recipient_id']);
        $message->setSeen(0);
        $message->save();

        Url::redirect('');
    }
}