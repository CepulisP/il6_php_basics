<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
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
        $messages = MessageModel::getNewMessages($_SESSION['user_id']);

        foreach ($messages as $message){
            $seen = new MessageModel($message->getId());
            $seen->setSeen(1);
            $seen->save();
        }

        $this->data['new_messages'] = $messages;
        $this->data['old_messages'] = MessageModel::getOldMessages($_SESSION['user_id']);
        $this->render('message/inbox');
    }

    public function chat()
    {
        // chat under construction
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
        $form->input([
            'name' => 'sender_id',
            'value' => $_SESSION['user_id'],
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
        $recipientId = User::getIdByNickname($_POST['recipient']);

        if (empty($recipientId)) {
            $_SESSION['send_error'] = 'Recipient not found';
            Url::redirect('message/send');
        }
        unset($_SESSION['send_error']);

        $message = new MessageModel();
        $message->setMessage($_POST['message']);
        $message->setSenderId($_POST['sender_id']);
        $message->setRecipientId($recipientId);
        $message->setSeen(0);
        $message->save();

        Url::redirect('');
    }
}