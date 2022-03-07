<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Comment extends AbstractModel implements ModelInterface
{
    private string $comment;

    private int $adId;

    private int $userId;

    private string $userIp;

    private string $createdAt;

    protected const TABLE = 'comments';

    public function __construct(?int $id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $id): void
    {
        $this->userId = $id;
    }

    public function getUserIp(): string
    {
        return $this->userIp;
    }

    public function setUserIp(string $ip): void
    {
        $this->userIp = $ip;
    }

    public function getAdId(): int
    {
        return $this->adId;
    }

    public function setAdId(int $id): void
    {
        $this->adId = $id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUser(): User
    {
        return new User($this->userId);
    }

    public function getAd(): Ad
    {
        return new Ad($this->adId);
    }

    public function assignData(): void
    {
        $this->data = [
            'comment' => $this->comment,
            'ad_id' => $this->adId,
            'user_id' => $this->userId,
            'user_ip' => $this->userIp
        ];
    }

    public function load(int $id): Comment
    {
        $db = new DBHelper();
        $comment = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($comment)) {
            $this->id = (int)$comment['id'];
            $this->comment = $comment['comment'];
            $this->adId = (int)$comment['ad_id'];
            $this->userId = (int)$comment['user_id'];
            $this->userIp = $comment['user_ip'];
            $this->createdAt = $comment['created_at'];
        }
        return $this;
    }

    public static function getAllComments(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment((int)$element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function getAdComments(int $adId, ?int $limit = null): array
    {
        $db = new DBHelper();
        $db->select()->from(self::TABLE)->where('ad_id', $adId)->orderby('created_at', 'DESC');

        if (isset($limit)){
            $db->limit($limit);
        }

        $data = $db->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment((int)$element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function getUserComments(int $userId): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('user_id', $userId)->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment((int)$element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }
}