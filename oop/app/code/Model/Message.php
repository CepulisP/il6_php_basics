<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Message extends AbstractModel implements ModelInterface
{
    private $message;

    private $senderId;

    private $recipientId;

    private $seen;

    private $createdAt;

    protected const TABLE = 'messages';

    public function __construct($id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function getRecipientId()
    {
        return $this->recipientId;
    }

    public function setRecipientId($recipientId)
    {
        $this->recipientId = $recipientId;
    }

    public function isSeen()
    {
        return $this->seen;
    }

    public function setSeen($seen)
    {
        $this->seen = $seen;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUser()
    {
        return new User($this->senderId);
    }

    public function assignData()
    {
        $this->data = [
            'message' => $this->message,
            'sender_id' => $this->senderId,
            'recipient_id' => $this->recipientId,
            'seen' => $this->seen
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $message = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($message)) {
            $this->id = $message['id'];
            $this->message = $message['message'];
            $this->senderId = $message['sender_id'];
            $this->recipientId = $message['recipient_id'];
            $this->seen = $message['seen'];
            $this->createdAt = $message['created_at'];
        }
        return $this;
    }

    public static function getNewMessages($userId)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 0)->get();
        $messages = [];

        foreach ($data as $element) {
            $message = new Message($element['id']);
            $messages[] = $message;
        }

        return $messages;
    }

    public static function getOldMessages($userId)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 1)->get();
        $messages = [];

        foreach ($data as $element) {
            $message = new Message($element['id']);
            $messages[] = $message;
        }

        return $messages;
    }

    public static function countNewMessages($userId)
    {
        $db = new DBHelper();
        $rez = $db->select('count(*)')->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 0)->get();
        return $rez[0][0];
    }
}