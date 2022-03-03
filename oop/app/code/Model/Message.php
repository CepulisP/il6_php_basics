<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;

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
        $data = $db->select()->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 1)->get();
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

    public static function countNewMessages($userId, $senderId = null)
    {
        $db = new DBHelper();
        $db->select('count(*)')->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 0);

        if (isset($senderId)) $db->andWhere('sender_id', $senderId);

        $rez = $db->get();
        return $rez[0][0];
    }

    public static function getSenders($userId)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('DISTINCT sender_id')
            ->from(self::TABLE)
            ->where('recipient_id', $userId)
            ->andWhere('sender_id', $userId, '<>')
            ->orderby('seen', 'ASC')
            ->get();
        $ids = [];

        foreach ($rez as $element)
        {
            $ids[] = $element['sender_id'];
        }

        return User::getUsers($ids);
    }

    public static function getChat($userId, $senderId)
    {
        $db = new DBHelper();
        $rez = $db
            ->select()
            ->from(self::TABLE)
            ->where('recipient_id', $userId)
            ->andWhere('sender_id', $senderId)
            ->orWhere('recipient_id', $senderId)
            ->andWhere('sender_id', $userId)
            ->get();

        $chat = [];

        foreach ($rez as $item){
            $chat[] = new Message($item['id']);
        }
        return $chat;
    }
}