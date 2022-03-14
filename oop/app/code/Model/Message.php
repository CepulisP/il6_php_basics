<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;

class Message extends AbstractModel implements ModelInterface
{
    private string $message;

    private int $senderId;

    private int $recipientId;

    private int $seen;

    private string $createdAt;

    protected const TABLE = 'messages';

    public function __construct(?int $id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function getRecipientId(): int
    {
        return $this->recipientId;
    }

    public function setRecipientId(int $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    public function isSeen(): int
    {
        return $this->seen;
    }

    public function setSeen(int $seen): void
    {
        $this->seen = $seen;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUser(): User
    {
        return new User($this->senderId);
    }

    public function assignData(): void
    {
        $this->data = [
            'message' => $this->message,
            'sender_id' => $this->senderId,
            'recipient_id' => $this->recipientId,
            'seen' => $this->seen
        ];
    }

    public function load(int $id): ?Message
    {
        $db = new DBHelper();
        $message = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($message)) {
            $this->id = (int)$message['id'];
            $this->message = $message['message'];
            $this->senderId = (int)$message['sender_id'];
            $this->recipientId = (int)$message['recipient_id'];
            $this->seen = (int)$message['seen'];
            $this->createdAt = $message['created_at'];
            return $this;
        }
        return null;
    }

    public static function countNewMessages(int $userId, ?int $senderId = null): int
    {
        $db = new DBHelper();
        $db->select('count(*)')->from(self::TABLE)->where('recipient_id', $userId)->andWhere('seen', 0);

        if (isset($senderId)) $db->andWhere('sender_id', $senderId);

        $rez = $db->get();
        return (int)$rez[0][0];
    }

    public static function getSenders(int $userId): array
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

    public static function getChat(int $userId, int $senderId): array
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
            $chat[] = new Message((int)$item['id']);
        }
        return $chat;
    }
}